<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class AboutCest
{
    public function _before(FunctionalTester $I)
    {
        ob_clean();
        ob_flush();
    }

    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnPage('site/about');
        $I->see('About', 'h1');
    }



    // tests

public function tryToTest(FunctionalTester $I)
    {
    }
}
