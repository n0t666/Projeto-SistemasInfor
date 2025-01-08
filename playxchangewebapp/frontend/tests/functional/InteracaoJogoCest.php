<?php


namespace frontend\tests\Functional;

use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use frontend\tests\Page\Acceptance\Login;

class InteracaoJogoCest
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

    public function testFavoritos(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-favorite');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->seeElement('.btn-favorite.ativo');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isFavorito' => '1']);
        $I->amOnRoute('utilizador/favoritos',['username' => $user['username']]);
        $I->seeElement('#jogo_21');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-favorite');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->dontSeeElement('.btn-favorite.ativo');
        $I->seeElement('.btn-favorite');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isFavorito' => '0']);
        $I->amOnRoute('utilizador/favoritos',['username' => $user['username']]);
        $I->dontSeeElement('#jogo_21');
    }

    public function testDesejados(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-wishlist');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->seeElement('.btn-wishlist.ativo');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isDesejado' => '1']);
        $I->amOnRoute('utilizador/desejados',['username' => $user['username']]);
        $I->seeElement('#jogo_21');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-wishlist');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->dontSeeElement('.btn-favorite.ativo');
        $I->seeElement('.btn-favorite');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isDesejado' => '0']);
        $I->amOnRoute('utilizador/desejados',['username' => $user['username']]);
        $I->dontSeeElement('#jogo_21');
    }

    public function testJogados(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-played');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->seeElement('.btn-played.ativo');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isJogado' => '1']);
        $I->amOnRoute('utilizador/jogados',['username' => $user['username']]);
        $I->seeElement('#jogo_21');
        $I->amOnRoute('jogo/view', ['id' => 21]);
        $I->click('.btn-played');
        $I->see('Estado do jogo atualizado com sucesso.');
        $I->dontSeeElement('.btn-favorite.ativo');
        $I->seeElement('.btn-favorite');
        $I->seeRecord('common\models\UtilizadorJogo', ['jogo_id' => '21', 'utilizador_id' => $user['id'], 'isJogado' => '0']);
        $I->amOnRoute('utilizador/jogados',['username' => $user['username']]);
        $I->dontSeeElement('#jogo_21');
    }



}
