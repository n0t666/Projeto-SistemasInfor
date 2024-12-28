<?php


namespace frontend\tests\Acceptance;

use frontend\tests\AcceptanceTester;
use frontend\tests\Page\Acceptance\Carrinho;
use frontend\tests\Page\Acceptance\Jogo;

class ComprasCest
{
    public function _before(AcceptanceTester $I,\frontend\tests\Page\Acceptance\Login $loginPage)
    {
        $loginPage->login('pedro', '12345678');
        $I->wait(2);
    }

    public function testAddCarrinho(AcceptanceTester $I, Jogo $jogoPage, Carrinho $carrinhoPage)
    {
        $I->amGoingTo("Testar a adição de um jogo ao carrinho");
        $I->wait(2);
        $jogoPage->addCarrinho();
        $I->wait(2);
        $I->see('Item adicionado ao carrinho com sucesso!');
        $I->wait(2);
        $carrinhoPage->enterCarrinho();
        $I->wait(2);
        $I->see('Grand Theft Auto V');
        $I->seeInField($carrinhoPage->quantidadeInput, '1');
        $I->see('PlayStation 4', $carrinhoPage->plataforma);

    }
}
