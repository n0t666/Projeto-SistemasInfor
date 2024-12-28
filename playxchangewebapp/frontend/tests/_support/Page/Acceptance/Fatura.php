<?php

declare(strict_types=1);

namespace frontend\tests\Page\Acceptance;

class Fatura
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \frontend\tests\AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\frontend\tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }

}
