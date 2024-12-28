<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use yii\helpers\Url;

/**
 * Class LoginCest
 */
class LoginCest
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I){
        $I->amOnPage(Url::toRoute('/site/login'));
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function tryLoginBackendUser(FunctionalTester $I)
    {

        $I->fillField('input[name="LoginForm[username]"]', 'leandro');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('entrar]');
    }

}
