<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\ProfileFixture;
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
            ],
            'profile' => [
                'class' => ProfileFixture::class,
                'dataFile' => codecept_data_dir() . 'profile_data.php',
            ],
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

    public function testLoginBackendUserAsCliente(FunctionalTester $I)
    {
        $I->amGoingTo('Logar como cliente no backend');
        $auth = \Yii::$app->authManager;
        $user = $I->grabFixture('user', 0);
        $auth->revokeAll($user['id']);
        $auth->assign($auth->getRole('cliente'), $user['id']);
        $I->fillField('input[name="LoginForm[username]"]', $user['username']);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('entrar');
        $I->see('Não tem permissões para aceder ao backend.');
        $I->dontSee('Página inicial');
        $I->amOnRoute('site/index');
        $I->see('Iniciar Sessão');
        $I->see('entrar');
    }

    public function testLoginBackendUserAsAdmin(FunctionalTester $I)
    {
        $I->amGoingTo('Logar como admin no backend');
        $auth = \Yii::$app->authManager;
        $user = $I->grabFixture('user', 0);
        $auth->revokeAll($user['id']);
        $auth->assign($auth->getRole('admin'), $user['id']);
        $I->fillField('input[name="LoginForm[username]"]', $user['username']);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('entrar');
        $I->see('Página inicial');
        $I->dontSee('Não tem permissões para aceder ao backend.');
    }

    public function testLoginBackendUserAsModerador(FunctionalTester $I)
    {
        $I->amGoingTo('Logar como moderador no backend');
        $auth = \Yii::$app->authManager;
        $user = $I->grabFixture('user', 0);
        $auth->revokeAll($user['id']);
        $auth->assign($auth->getRole('moderador'), $user['id']);
        $I->fillField('input[name="LoginForm[username]"]', $user['username']);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('entrar');
        $I->see('Página inicial');
        $I->dontSee('Não tem permissões para aceder ao backend.');
    }

    public function testLoginBackendUserAsFunc(FunctionalTester $I)
    {
        $I->amGoingTo('Logar como funcionário no backend');
        $auth = \Yii::$app->authManager;
        $user = $I->grabFixture('user', 0);
        $auth->revokeAll($user['id']);
        $auth->assign($auth->getRole('funcionario'), $user['id']);
        $I->fillField('input[name="LoginForm[username]"]', $user['username']);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('entrar');
        $I->see('Página inicial');
        $I->dontSee('Não tem permissões para aceder ao backend.');
    }



}
