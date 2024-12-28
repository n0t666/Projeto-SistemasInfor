<?php


namespace frontend\tests\Acceptance;

use Codeception\Attribute\After;
use Codeception\Attribute\Depends;
use frontend\tests\AcceptanceTester;
use frontend\tests\Page\Acceptance\Jogo;
use frontend\tests\Page\Acceptance\Perfil;

class InteracaoJogoCest  // Utilizado a página do jogo 19 (Grand Theft Auto V)
{
    public function _before(AcceptanceTester $I)
    {
        $I->login('pedro', '12345678');
        $I->wait(2);
    }

    public function testFavoritos(AcceptanceTester $I, Jogo $jogoPage, Perfil $perfilPage)
    {
        $I->amGoingTo("Testar os favoritos");
        $I->wait(2);
        $jogoPage->simulateEnterDetails();
        $jogoPage->addFavoritos();
        $I->wait(2);
        $I->seeElement($jogoPage->favoritosButtonAtivo);
        $I->see(' Estado do jogo atualizado com sucesso.');
        $I->wait(5);
        $I->executeJS('document.getElementById("success-toast").style.display = "none";');
        $perfilPage->simulateUserDropdown();
        $I->wait(2);
        $perfilPage->enterFavoritos();
        $I->wait(2);
        $I->see('Favoritos');
        $I->seeElement($jogoPage->targetLink);
        $I->moveMouseOver($jogoPage->gameCard);
        $I->click($jogoPage->interactionCardDiv . ' ' . $jogoPage->favoritosButton);
        $I->wait(2);
        $I->see(' Estado do jogo atualizado com sucesso.');
        $I->dontSeeElement($jogoPage->targetLink);
        $I->wait(2);
    }

    public function testJogados(AcceptanceTester $I, Jogo $jogoPage, Perfil $perfilPage)
    {
            $I->amGoingTo("Testar os favoritos");
            $I->wait(2);
            $jogoPage->simulateEnterDetails();
            $jogoPage->addJogados();
            $I->wait(2);
            $I->seeElement($jogoPage->jogadosButtonAtivo);
            $I->see(' Estado do jogo atualizado com sucesso.');
            $I->wait(5);
            $I->executeJS('document.getElementById("success-toast").style.display = "none";');
            $perfilPage->simulateUserDropdown();
            $I->wait(2);
            $perfilPage->enterJogados();
            $I->wait(2);
            $I->see('Jogados');
            $I->seeElement($jogoPage->targetLink);
            $I->moveMouseOver($jogoPage->gameCard);
            $I->click($jogoPage->interactionCardDiv . ' ' . $jogoPage->jogadosButton);
            $I->wait(2);
            $I->see(' Estado do jogo atualizado com sucesso.');
            $I->dontSeeElement($jogoPage->targetLink);
            $I->wait(2);
    }

    public function testDesejados(AcceptanceTester $I, Jogo $jogoPage, Perfil $perfilPage)
    {
        $I->amGoingTo("Testar os favoritos");
        $I->wait(2);
        $jogoPage->simulateEnterDetails();
        $jogoPage->addDesejados();
        $I->wait(2);
        $I->seeElement($jogoPage->desejadosButtonAtivo);
        $I->see(' Estado do jogo atualizado com sucesso.');
        $I->wait(5);
        $I->executeJS('document.getElementById("success-toast").style.display = "none";');
        $perfilPage->simulateUserDropdown();
        $I->wait(2);
        $perfilPage->enterDesejados();
        $I->wait(2);
        $I->see('Desejados');
        $I->seeElement($jogoPage->targetLink);
        $I->moveMouseOver($jogoPage->gameCard);
        $I->click($jogoPage->interactionCardDiv . ' ' . $jogoPage->desejadosButton);
        $I->wait(2);
        $I->see(' Estado do jogo atualizado com sucesso.');
        $I->dontSeeElement($jogoPage->targetLink);
        $I->wait(2);
    }


}
