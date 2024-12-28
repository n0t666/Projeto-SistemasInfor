<?php


namespace frontend\tests\Acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class MainCest
{
    public function _before(AcceptanceTester $I)
    {
    }


    protected function formParamsLogin($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function mainTest(AcceptanceTester $I, \frontend\tests\Page\Acceptance\Login $loginPage)
    {
        $loginPage->login('pedro', '12345678');
        $I->wait(2);
        $I->amOnPage('/');
        $I->wait(1);
        $I->see('pedro');
        $I->see('Jogos');
        $I->click('Jogos');
        $I->see('Filtrar por:');
        $I->wait(1);
        // $I->click('//div[@data-key="19"]//a'); (Está a dar erro, clica nos favoritos em vez de clicar no jogo)
        $I->executeJS('document.querySelector(\'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/jogo/view?id=19"]\').click();');
        $I->wait(1);
        $I->see('Grand Theft Auto V');
    }
}
