<?php


namespace frontend\tests\Functional;

use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use frontend\tests\Page\Acceptance\Jogo;
use frontend\tests\Page\Acceptance\Login;

class AvaliacaoCest
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

    public function testAdicionar(FunctionalTester $I,Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->see('Guardar Avaliação');
        $I->fillField('Avaliacao[numEstrelas]', '5');
        $I->click('Guardar Avaliação');
        $I->see(' Avaliação atualizada com sucesso! ');
        $I->seeRecord('common\models\Avaliacao', ['numEstrelas' => '5', 'jogo_id' => '19']);

    }

    public function testVerGuest(FunctionalTester $I)
    {
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->dontSee('Guardar Avaliação');
    }

    public function testGuardarGuest(FunctionalTester $I)
    {
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->dontSee('Guardar Avaliação');
        $I->amOnRoute('avaliacao/create');
        $I->see('Login');
    }

    /* N funciona pq click espera um botão/link porem o componente é uma div que age no onclick
    public function testApagar(FunctionalTester $I,Login $loginPage,Jogo $jogoPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->see('Guardar Avaliação');
        $I->click('div[class="clear-rating"]');
        $I->click('Guardar Avaliação');
        $I->see('Avaliação removida com sucesso!');
    }
    */



}
