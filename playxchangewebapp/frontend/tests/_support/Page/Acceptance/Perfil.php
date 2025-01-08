<?php

declare(strict_types=1);

namespace frontend\tests\Page\Acceptance;

class Perfil
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

    public static $URL = '/utilizador/profile?username=pedro';

    public $seguidoresLink = 'Seguidores';
    public $seguidosLink = 'A seguir';

    public $favoritosLink = 'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/utilizador/favoritos?username=pedro"]';
    public $jogadosLink = 'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/utilizador/jogados?username=pedro"]';
    public $desejadosLink = 'a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/utilizador/desejados?username=pedro"]';

    public $userDropdown = '#userDropdown';

    public function __construct(\frontend\tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }

    private function click($element)
    {
        $I = $this->acceptanceTester;
        $I->wait(5);
        $I->moveMouseOver($element);
        $I->wait(2);
        $I->click($element);
        $I->wait(2);
    }

    public function simulateUserDropdownProfile()
    {
        $I = $this->acceptanceTester;
        $I->wait(5);
        $I->click('#userDropdown');
        $I->click('a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/utilizador/profile?username=pedro"]');
        $I->wait(2);
    }

    public function simulateUserDropdownEncomendas()
    {
        $I = $this->acceptanceTester;
        $I->wait(5);
        $I->click('#userDropdown');
        $I->click('a[href="/Projeto-SistemasInfor/playxchangewebapp/frontend/web/fatura/index"]');
        $I->wait(2);
    }


    public function enterSeguidores()
    {
        $I = $this->acceptanceTester;
        $this->click($this->seguidoresLink);
    }

    public function enterSeguidos()
    {
        $I = $this->acceptanceTester;
        $I->click($this->seguidosLink);
    }

    public function enterCompras()
    {
        $I = $this->acceptanceTester;
        $this->click('Compras');
    }

    public function enterFavoritos()
    {
        $I = $this->acceptanceTester;
        $this->click($this->favoritosLink);
    }

    public function enterJogados()
    {
        $I = $this->acceptanceTester;
        $this->click($this->jogadosLink);
    }

    public function enterDesejados()
    {
        $I = $this->acceptanceTester;
        $this->click($this->desejadosLink);
    }

}
