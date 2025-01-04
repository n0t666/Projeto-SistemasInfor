<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class AboutCest
{

    public function _before(FunctionalTester $I)
    {

    }

    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnPage('site/about');
        $I->see('Acerca', 'div[class="section-title"]');
    }

}
