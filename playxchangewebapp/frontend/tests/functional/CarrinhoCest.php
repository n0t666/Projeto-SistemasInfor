<?php


namespace frontend\tests\Functional;

use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use frontend\tests\Page\Acceptance\Login;

class CarrinhoCest
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

    public function _before(FunctionalTester $I)
    {
    }

    public function testVer(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('carrinho/index');
        $I->see('O seu carrinho está vazio');
    }

    public function testVerGuest(FunctionalTester $I) // Caso tente aceder ao carrinho sem estar logado, é redirecionado para a página de login
    {
        $I->amOnRoute('carrinho/index');
        $I->see('Login');
    }

    public function testAddGuest(FunctionalTester $I) // Caso tente adicionar um produto ao carrinho sem estar logado, é redirecionado para a página de login
    {
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->dontSee('Adicionar ao carrinho');
        $I->amOnRoute('linha-carrinho/create');
        $I->see('Login');
    }

    public function testAdicionar(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->see('Adicionar ao carrinho');
        $I->selectOption('select[name="LinhaCarrinho[produtos_id]"]', '1');
        $I->see('PlayStation 4');
        $I->submitForm('#jogo-carrinho', ["LinhaCarrinho[quantidade]" => 5]);
        $I->see('Item adicionado ao carrinho com sucesso!');
        $I->click('#carrinho-btn');
        $I->see('Grand Theft Auto V');
    }

    public function testRemover(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->see('Adicionar ao carrinho');
        $I->selectOption('select[name="LinhaCarrinho[produtos_id]"]', '1');
        $I->see('PlayStation 4');
        $I->submitForm('#jogo-carrinho', ["LinhaCarrinho[quantidade]" => 5]);
        $I->see('Item adicionado ao carrinho com sucesso!');
        $I->click('#carrinho-btn');
        $I->see('Grand Theft Auto V');
        $I->click('#delete_19');
        $I->see('Produto removido do carrinho.');
        $I->see('O seu carrinho está vazio');
    }

    public function testAlterarQuantidade(FunctionalTester $I, Login $loginPage)
    {
        $user = $I->grabFixture('user', 0);
        $loginPage->login($user['username'], '12345678');
        $I->see('pedro');
        $I->amOnRoute('jogo/view', ['id' => 19]);
        $I->see('Adicionar ao carrinho');
        $I->selectOption('select[name="LinhaCarrinho[produtos_id]"]', '1');
        $I->see('PlayStation 4');
        $I->submitForm('#jogo-carrinho', ["LinhaCarrinho[quantidade]" => 5]);
        $I->see('Item adicionado ao carrinho com sucesso!');
        $I->click('#carrinho-btn');
        $I->see('Grand Theft Auto V');
        $I->seeInField('input[name="quantidades[1]"]', '5');
        $I->submitForm('#carrinho', ["quantidades[1]" => 3]);
        $I->see('Carrinho atualizado com sucesso!');
        $I->seeInField('input[name="quantidades[1]"]', '3');
    }
}
