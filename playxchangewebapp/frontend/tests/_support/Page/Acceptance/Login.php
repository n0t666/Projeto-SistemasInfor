<?php

declare(strict_types=1);

namespace frontend\tests\Page\Acceptance;

class Login
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \frontend\tests\AcceptanceTester;
     */
    public static $URL = '/site/login';
    public $usernameField = '#login-form input[name="LoginForm[username]"]';
    public $passwordField = '#login-form input[name="LoginForm[password]"]';
    public $loginButton = '#login-form button[name="login-button"]';

    public $userDropdown = '#userDropdown';


    protected $acceptanceTester;

    public function __construct(\frontend\tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function login($username, $password)
    {
        $I = $this->acceptanceTester;
        $I->amOnPage(self::$URL);
        $I->fillField($this->usernameField, $username);
        $I->fillField($this->passwordField, $password);
        $I->click($this->loginButton);
    }

    public function logout()
    {
        $I = $this->acceptanceTester;
        $I->click($this->userDropdown);
        $I->submitForm('#logout-form', []);
    }

}
