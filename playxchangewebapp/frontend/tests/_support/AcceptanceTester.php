<?php

declare(strict_types=1);

namespace frontend\tests;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    public function login($name, $password)
    {
        $I = $this;
        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('login')) {
            return;
        }

        $I->amOnPage('site/login');
        $I->submitForm('#login-form', [
            'LoginForm[username]' => $name,
            'LoginForm[password]' => $password
        ]);
        $I->wait(2);
        $I->see($name, '#userDropdown');
        // saving snapshot
        $I->saveSessionSnapshot('login');
    }

}
