<?php


namespace frontend\tests\Acceptance;

use common\models\User;
use Facebook\WebDriver\WebDriverKeys;
use frontend\tests\AcceptanceTester;
use frontend\tests\Page\Acceptance\Carrinho;
use frontend\tests\Page\Acceptance\Jogo;
use frontend\tests\Page\Acceptance\Login;
use frontend\tests\Page\Acceptance\Perfil;

class ComprasCest
{
    public function _before(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('pedro', '12345678');
        $I->wait(2);
    }

    public function testAddCarrinho(AcceptanceTester $I, Jogo $jogoPage, Carrinho $carrinhoPage, Perfil $perfilPage)
    {
        $I->amGoingTo("Testar a adição de um jogo ao carrinho");
        $I->wait(1);
        $jogoPage->simulateEnterDetails();
        $jogoPage->addCarrinho();
        $I->wait(2);
        $I->see('Item adicionado ao carrinho com sucesso!');
        $I->wait(2);
        $carrinhoPage->enterCarrinho();
        $I->wait(2);
        $I->see('Grand Theft Auto V');
        $I->seeInField($carrinhoPage->quantidadeInput, '1');
        $I->see('PlayStation 4', $carrinhoPage->plataforma);
        $I->see('30.00€', $carrinhoPage->preco);
        //$I->clearField($carrinhoPage->quantidadeInput); Não funciona
        //$I->pressKey($carrinhoPage->quantidadeInput, ['Ctrl', 'a'], WebDriverKeys::DELETE);
        $I->executeJS("document.querySelector('{$carrinhoPage->quantidadeInput}').value = '';");
        $I->wait(3);
        $I->fillField($carrinhoPage->quantidadeInput, '5');
        $I->click($carrinhoPage->atualizarButton);
        $I->wait(2);
        $I->see('Carrinho atualizado com sucesso!');
        $I->wait(2);
        $I->seeInField($carrinhoPage->quantidadeInput, '5');
        $I->see('150.00€', $carrinhoPage->preco);
        $I->fillField($carrinhoPage->codigoDescontoInput,'SEMIVA');
        $I->click($carrinhoPage->aplicarDescontoButton);
        $I->wait(2);
        $I->see('Cupão aplicado: SEMIVA');
        $I->wait(2);
        $I->click($carrinhoPage->checkoutButton);
        $I->wait(2);
        $I->see('Completar compra');
        $I->see('Escolha o método de entrega');
        $I->see('Escolha o método de pagamento');
        $I->see('Cupão (Código: SEMIVA)');
        $I->checkOption($carrinhoPage->envio);
        $I->wait(2);
        $I->checkOption($carrinhoPage->metodoPagamento);
        $I->wait(2);
        $I->click($carrinhoPage->submitOrderButton);
        $I->wait(2);
        $I->see(' Fatura criada com sucesso.');
        $I->wait(2);
    }

}
