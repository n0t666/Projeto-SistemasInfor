<?php

declare(strict_types=1);

namespace frontend\tests\Page\Acceptance;

class Carrinho
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public $usernameField = '#username';
     * public $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * @var \frontend\tests\AcceptanceTester;
     */

    public static $URL = '/carrinho';

    public $tr = 'tr #jogo_19';

    public $removerButton = 'tr#jogo_19 #delete_19';
    public $quantidadeInput = 'tr#jogo_19 .quantity-input';

    public $plataforma = 'tr#jogo_19 .cart__plataforma';

    public $preco = 'tr#jogo_19 .cart__price';

    public $quantidadeMenos = '.dec.qtybtn';

    public $quantidadeMais = '.inc.qtybtn';

    public $atualizarButton = '#quantitySub';

    public $codigoDescontoInput = '#coupon-code';

    public $aplicarDescontoButton = '#apply-coupon';

    public $checkoutButton = '#checkout-btn';

    public $submitOrderButton = '.custom-btn-order';

    public $envio = 'input[name="Fatura[envio_id]"][value="2"]';

    public $metodoPagamento = 'input[name="Fatura[pagamento_id]"][value="1"]';




    protected $acceptanceTester;

    public function __construct(\frontend\tests\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        // you can inject other page objects here as well
    }

    public function enterCarrinho()
    {
        $I = $this->acceptanceTester;
        $I->amOnPage(self::$URL);
    }

}
