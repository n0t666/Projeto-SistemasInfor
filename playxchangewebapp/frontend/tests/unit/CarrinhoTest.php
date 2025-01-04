<?php


namespace frontend\tests\Unit;

use common\models\Carrinho;
use common\models\CodigoPromocional;
use common\models\LinhaCarrinho;
use frontend\tests\UnitTester;

class CarrinhoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testGuardar()
    {
       $carrinho = new Carrinho();
       $carrinho->utilizador_id = 2;
       $carrinho->total = 0;
       $carrinho->count = 0;
       $this->assertTrue($carrinho->save(), 'Falha ao guardar carrinho');
       $this->tester->seeRecord('common\models\Carrinho', ['utilizador_id' => 2, 'total' => 0, 'count' => 0]);
    }

    public function testEditar(){
        $carrinho = $this->tester->grabRecord('common\models\Carrinho', ['id' => 2]);
        $this->assertNotNull($carrinho, 'Carrinho não encontrado');
        $carrinho->total = 10;
        $carrinho->count = 1;
        $this->assertTrue($carrinho->save(), 'Falha ao editar carrinho');
        $this->tester->seeRecord('common\models\Carrinho', ['id' => 2, 'total' => 10, 'count' => 1]);
        $this->tester->dontSeeRecord('common\models\Carrinho', ['id' => 2, 'total' => 0, 'count' => 0]);
    }

    public function testApagar()
    {
        $carrinho = $this->tester->grabRecord('common\models\Carrinho', ['id' => 2]);
        $this->assertNotNull($carrinho, 'Carrinho não encontrado');
        $carrinho->delete();
        $this->tester->dontSeeRecord('common\models\Carrinho', ['id' => 2]);
    }

    public function testRecalculateTotal()
    {
        $carrinho = $this->tester->grabRecord('common\models\Carrinho', ['id' => 3]);
        $this->assertNotNull($carrinho, 'Carrinho não encontrado');
        $produto = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $this->assertNotNull($produto, 'Produto não encontrado');
        $iva = $this->tester->grabRecord('common\models\Iva', ['id' => 1]);
        $this->assertNotNull($iva, 'Iva não encontrado');
        $linhaCarrinho = new LinhaCarrinho();
        $linhaCarrinho->carrinhos_id = $carrinho->id;
        $linhaCarrinho->produtos_id = $produto->id;
        $linhaCarrinho->quantidade = 10;
        $linhaCarrinho->save();
        $this->tester->seeRecord('common\models\LinhaCarrinho', ['carrinhos_id' => $carrinho->id, 'produtos_id' => $produto->id, 'quantidade' => 10]);
        $carrinho->refresh();
        $carrinho->recalculateTotal();
        $totalCarrinhoComIva = $produto->preco * 10 * (1 + $iva->percentagem / 100);
        $this->assertEquals($totalCarrinhoComIva , $carrinho->total);
        $this->assertEquals(10, $carrinho->count);
        $this->tester->seeRecord('common\models\Carrinho', ['id' => 3, 'total' => $totalCarrinhoComIva, 'count' => 10]);
        $this->tester->dontSeeRecord('common\models\Carrinho', ['id' => 3, 'total' => 0, 'count' => 0]);
    }

    public function testLimpar()
    {
        $carrinho = $this->tester->grabRecord('common\models\Carrinho', ['id' => 3]);
        $this->assertNotNull($carrinho, 'Carrinho não encontrado');
        $produto = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $this->assertNotNull($produto, 'Produto não encontrado');
        $linhaCarrinho = new LinhaCarrinho();
        $linhaCarrinho->carrinhos_id = $carrinho->id;
        $linhaCarrinho->produtos_id = $produto->id;
        $linhaCarrinho->quantidade = 10;
        $linhaCarrinho->save();
        $this->tester->seeRecord('common\models\LinhaCarrinho', ['carrinhos_id' => $carrinho->id, 'produtos_id' => $produto->id, 'quantidade' => 10]);
        $carrinho->refresh();
        $carrinho->limpar();
        $this->tester->dontSeeRecord('common\models\LinhaCarrinho', ['carrinhos_id' => $carrinho->id, 'produtos_id' => $produto->id, 'quantidade' => 10]);
        $this->tester->seeRecord('common\models\Carrinho', ['id' => 3, 'total' => 0, 'count' => 0]);
    }

    public function testValidation(){
        $carrinho = new Carrinho();
        $this->assertFalse($carrinho->validate(['utilizador_id']), 'Carrinho não pode ser guardado sem estar associado a um utilizador');

        // Testar regra inteiros
        $carrinho->utilizador_id = 1.5;
        $carrinho->count = 1.5;
        $this->assertFalse($carrinho->validate(['utilizador_id']), 'Carrinho não pode ser guardado com um id de utilizador que não seja inteiro');
        $this->assertFalse($carrinho->validate(['count']), 'Carrinho não pode ser guardado com um count que não seja inteiro');

        $carrinho->utilizador_id = 2;
        $carrinho->count = 1;
        $this->assertTrue($carrinho->validate(['utilizador_id']), 'Carrinho válido');
        $this->assertTrue($carrinho->validate(['count']), 'Carrinho válido');

        // Testar mínimo
        $carrinho->count = -1;
        $carrinho->total = -1;
        $this->assertFalse($carrinho->validate(['count']), 'Carrinho não pode ser guardado com um count menor que 0');
        $this->assertFalse($carrinho->validate(['total']), 'Carrinho não pode ser guardado com um count menor que 0');

        // Existir utilizador
        $carrinho->utilizador_id = 100;
        $this->assertFalse($carrinho->validate(['utilizador_id']), 'Carrinho não pode ser guardado com um id de utilizador que não exista');
    }




}
