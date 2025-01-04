<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->see('Gestão e Compra de Videojogos Facilitada');
        $I->seeLink('Acerca');
        $I->seeLink('FAQs');
        $I->seeLink('Jogos');
        $I->seeLink('Login');
        $I->seeLink('Register');
    }
}