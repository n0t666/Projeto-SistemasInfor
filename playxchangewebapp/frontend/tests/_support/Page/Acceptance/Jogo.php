<?php

declare(strict_types=1);

namespace frontend\tests\Page\Acceptance;

class Jogo // Utilizado a página do jogo 19 (Grand Theft Auto V)
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \frontend\tests\AcceptanceTester;
     */

    public static $URL = '/jogo/view?id=19';

    public $favoritosButton = '.btn.btn-favorite';
    public $jogadosButton = '.btn.btn-played';
    public $desejadosButton = '.btn.btn-wishlist';

    public $favoritosButtonAtivo = '.btn.btn-favorite.ativo';
    public $jogadosButtonAtivo = '.btn.btn-played.ativo';
    public $desejadosButtonAtivo = '.btn.btn-wishlist.ativo';

    public $plataformaDropdown = '#plataforma-dropdown';

    public $carrinhoButton = '.cart-button';

    public $targetLink = 'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/jogo/view?id=19"]';

    public $gameCard = '.card.game-card:first-child';

    public $interactionCardDiv = '.card.game-card:first-child .center-links';

    public $filledStar = '.filled-stars';

    public $inputAvaliacao = '#avaliacao-numestrelas';

    public $removeAvaliacaoButton = '//div[@class="clear-rating" and @title="Clear"]';






    protected $acceptanceTester;

    public function __construct(\frontend\tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }

    public function simulateEnterDetails()
    {
        $I = $this->acceptanceTester;
        $I->wait(2);
        $I->click('Jogos');
        $I->wait(2);
        $I->executeJS('document.querySelector(\'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/jogo/view?id=19"]\').click();');
        $I->wait(1);
    }

    private function click($element)
    {
        $I = $this->acceptanceTester;
        $I->waitForElementVisible($element, 10);
        $I->waitForElementClickable($element, 10);
        $I->click($element);
        $I->wait(2);
    }

    private function select($element, $option)
    {
        $I = $this->acceptanceTester;
        $I->waitForElementVisible($element, 10);
        $I->wait(2);
        $I->selectOption($element, $option);
        $I->wait(2);
    }

    private function type($element, $text)
    {
        $I = $this->acceptanceTester;
        $I->waitForElementVisible($element, 10);
        $I->wait(2);
        $I->fillField($element, $text);
        $I->wait(2);
    }

    public function addFavoritos()
    {

        $this->click($this->favoritosButton);
    }

    public function addJogados()
    {
        $this->click($this->jogadosButton);
    }

    public function addDesejados()
    {
        $this->click($this->desejadosButton);
    }

    public function removeFavoritos()
    {
        $this->click($this->favoritosButtonAtivo);
    }

    public function removeJogados()
    {
        $this->click($this->jogadosButtonAtivo);
    }

    public function removeDesejados()
    {
        $this->click($this->desejadosButtonAtivo);
    }

    public function addCarrinho()
    {
        $I = $this->acceptanceTester;
        $this->select($this->plataformaDropdown, 1); // PlayStation 4 (primeira opção)
        $I->wait(5);
        $this->click($this->carrinhoButton);
    }









}
