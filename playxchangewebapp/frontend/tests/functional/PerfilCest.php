<?php


namespace frontend\tests\Functional;

use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use common\models\Userdata;
use frontend\tests\FunctionalTester;
use frontend\tests\Page\Acceptance\Login;
use Yii;

class PerfilCest
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
            'profile' => [
                'class' => ProfileFixture::class,
                'dataFile' => codecept_data_dir() . 'profile_data.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
    }


    public function testEditar(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('utilizador/update');
        $I->seeInField('UpdateForm[nome]', $profile['nome']);
        $I->seeInField('UpdateForm[nif]', $profile['nif']);
        $data = Yii::$app->formatter->asDate($profile['dataNascimento'], 'php:d-m-Y');
        $I->seeInField('UpdateForm[dataNascimento]', $data);
        $I->seeInField('UpdateForm[biografia]', $profile['biografia']);
        $I->seeInField('UpdateForm[email]', $user['email']);
        $I->seeInField('UpdateForm[privacidadeSeguidores]', $profile['privacidadeSeguidores']);
        $I->seeInField('UpdateForm[privacidadePerfil]', $profile['privacidadePerfil']);
        $I->seeInField('UpdateForm[privacidadeJogos]', $profile['privacidadeJogos']);
        $I->fillField('UpdateForm[nome]', 'novoNome');
        $I->fillField('UpdateForm[nif]', '111111111');
        $I->fillField('UpdateForm[dataNascimento]', '01-01-2000');
        $I->fillField('UpdateForm[biografia]', 'novaBio');
        $I->fillField('UpdateForm[email]', 'novoEmail@gmail.com');
        $I->selectOption('UpdateForm[privacidadeSeguidores]', '1');
        $I->selectOption('UpdateForm[privacidadePerfil]', '1');
        $I->selectOption('UpdateForm[privacidadeJogos]', '1');
        $I->submitForm('#update-form', []);
        $I->see(' Perfil atualizado com sucesso!');
        $I->seeRecord('common\models\Userdata', ['nif' => '111111111', 'nome' => 'novoNome', 'dataNascimento' => '2000-01-01', 'biografia' => 'novaBio', 'privacidadeSeguidores' => '1', 'privacidadePerfil' => '1', 'privacidadeJogos' => '1','id' => $profile['id']]);
    }

    public function testDesativarConta(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('utilizador/update');
        $I->click('Desativar');
        $I->see('Conta apagada com sucesso!');
        $I->seeRecord('common\models\User', ['status' => '0', 'id' => $user['id']]);
    }

    public function testEditarGuest(FunctionalTester $I, Login $loginPage)
    {
        $I->amOnRoute('utilizador/update');
        $I->see('Login');
    }

    public function testLogout(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $loginPage->logout();
        $I->dontSee('pedro');
    }

    public function testVerPerfilPublico(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $targetUser = $I->grabFixture('user', 1);
        $targetProfile = $I->grabFixture('profile', 1);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('utilizador/profile', ['username' => $targetUser['username']]);
        $I->see($targetProfile['nome']);
    }

    public function testVerPerfilPrivado(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $targetUser = $I->grabFixture('user', 1);
        $targetProfile = $I->grabFixture('profile', 1);
        $loginPage->login($user['username'], '12345678');
        $targetProfileModel = $I->grabRecord('common\models\Userdata', ['user_id' => $targetUser['id']]);
        $targetProfileModel->privacidadePerfil = Userdata::STATUS_PRIVATE;
        $targetProfileModel->save();
        $I->amOnRoute('utilizador/profile', ['username' => $targetUser['username']]);
        $I->see('Ocorreu um problema ao processar o seu pedido');
    }

    public function testSeguir(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $targetUser = $I->grabFixture('user', 1);
        $targetProfile = $I->grabFixture('profile', 1);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('utilizador/profile', ['username' => $targetUser['username']]);
        $I->submitForm('#followForm_' . $targetProfile['id'], []);
        $I->see('Deixar de seguir');
        $I->click('Deixar de seguir');
        $I->see('Seguir');
    }

    public function testBloquear(FunctionalTester $I, Login $loginPage){
        $user = $I->grabFixture('user', 0);
        $profile = $I->grabFixture('profile', 0);
        $targetUser = $I->grabFixture('user', 1);
        $targetProfile = $I->grabFixture('profile', 1);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('utilizador/profile', ['username' => $targetUser['username']]);
        $I->submitForm('#blockForm_' . $targetProfile['id'], []);
        $I->see('Desbloquear');
        $loginPage->logout();
        $loginPage->login($targetUser['username'], '12345678');
        $I->see($targetUser['username']);
        $I->amOnRoute('utilizador/profile', ['username' => $user['username']]);
        $I->see('Ocorreu um problema ao processar o seu pedido');
    }


}
