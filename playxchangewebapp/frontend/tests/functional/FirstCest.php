<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }

    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('/site/about');
        $I->see('About', 'h1');
    }

}
