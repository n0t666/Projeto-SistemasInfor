<?php


namespace frontend\tests\Unit;

use common\models\CodigoPromocional;
use common\models\Fatura;
use common\models\Produto;
use frontend\tests\UnitTester;

class FaturaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }


    public function testAdicionarLinhaFatura()
    {
        $produto = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $chave = $this->tester->grabRecord('common\models\Chave', ['id' => 1]);

        $this->assertNotNull($produto, 'Produto não encontrado');
        $this->assertNotNull($chave, 'Chave não encontrada');

        // Testar adicionar produto físico á fatura
        $fatura = new \common\models\Fatura();
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->save();
        $linhaFatura = $fatura->adicionarLinhaFatura($produto);
        $this->assertInstanceOf(\common\models\LinhaFatura::class, $linhaFatura);
        $this->assertEquals($produto->id, $linhaFatura->produto_id);
        $this->assertEquals($produto->preco, $linhaFatura->precoUnitario);

        // Testar adicionar produto digital á fatura
        $fatura = new \common\models\Fatura();
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->save();
        $linhaFatura = $fatura->adicionarLinhaFatura($produto, $chave->id);
        $this->assertInstanceOf(\common\models\LinhaFatura::class, $linhaFatura);
        $this->assertEquals($produto->id, $linhaFatura->produto_id);
        $this->assertEquals($produto->preco, $linhaFatura->precoUnitario);
        $this->assertEquals($chave->id, $linhaFatura->chave_id);

        // Testar produto inexistente
        $this->tester->expectThrowable(\Exception::class, function () use ($fatura) {
            $fatura->adicionarLinhaFatura(new Produto());
        }, 'Produto não existe');

        // Testar chave inexistente
        $this->tester->expectThrowable(\Exception::class, function () use ($fatura, $produto) {
            $fatura->adicionarLinhaFatura($produto, 100);
        }, 'Chave não existe');
    }

    public function testGetLinhasFaturaGroup(){
        $fatura = new Fatura();
        $produtoId1 = $this->tester->grabRecord('common\models\Produto', ['id' => 1]);
        $produtoId2 = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->save();
        $fatura->adicionarLinhaFatura($produtoId1);
        $fatura->adicionarLinhaFatura($produtoId1);
        $fatura->adicionarLinhaFatura($produtoId2);
        $linhasFatura = $fatura->getLinhasFaturaGroup();

        $this->assertArrayHasKey($produtoId1->id, $linhasFatura);
        $this->assertEquals(2, $linhasFatura[$produtoId1->id]['quantidade']); // 2 produtos com o mesmo id tem de ter quantidade 2 pois são agrupados
        $this->assertEquals(2 * $produtoId1->preco, $linhasFatura[$produtoId1->id]['subtotal']); // 2 * preço do produto
        $this->assertArrayHasKey($produtoId2->id, $linhasFatura);
        $this->assertEquals(1, $linhasFatura[$produtoId2->id]['quantidade']);
        $this->assertEquals($produtoId2->preco, $linhasFatura[$produtoId2->id]['subtotal']);
    }

    public function testGetTotalSemDesconto()
    {
        $fatura = new Fatura();
        $produtoId1 = $this->tester->grabRecord('common\models\Produto', ['id' => 1]);
        $produtoId2 = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->save();
        $fatura->adicionarLinhaFatura($produtoId1);
        $fatura->adicionarLinhaFatura($produtoId2);
        $quantiaEsperada = $produtoId1->preco + $produtoId2->preco;
        $this->assertEquals($quantiaEsperada, $fatura->getTotalSemDesconto());
    }

    public function testGetDesconto()
    {
        $codigo = new CodigoPromocional();
        $codigo->codigo = "TESTE";
        $codigo->desconto = 50;
        $codigo->isAtivo = 1;
        $codigo->save();

        $fatura = new Fatura();
        $produtoId1 = $this->tester->grabRecord('common\models\Produto', ['id' => 1]);
        $produtoId2 = $this->tester->grabRecord('common\models\Produto', ['id' => 2]);
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->codigo_id = $codigo->id;
        $fatura->save();
        $fatura->adicionarLinhaFatura($produtoId1);
        $fatura->adicionarLinhaFatura($produtoId2);
        $totalSemDesconto = $produtoId1->preco + $produtoId2->preco;
        $this->assertEquals($totalSemDesconto * ($codigo->desconto / 100), $fatura->getDesconto($totalSemDesconto));
    }

    public function testGuardar()
    {
        $fatura = new Fatura();
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $fatura->save();
        $produtoId1 = $this->tester->grabRecord('common\models\Produto', ['id' => 1]);
        $fatura->adicionarLinhaFatura($produtoId1);
        $this->tester->seeRecord('common\models\Fatura', ['utilizador_id' => 1, 'pagamento_id' => 1, 'envio_id' => 1, 'total' => 0, 'estado' => Fatura::ESTADO_PAID]);
        $this->tester->seeRecord('common\models\LinhaFatura', ['fatura_id' => $fatura->id, 'produto_id' => $produtoId1->id]);
    }

    public function testValidation()
    {
        $fatura = new Fatura();
        $this->assertFalse($fatura->validate(['utilizador_id']));
        $this->assertFalse($fatura->validate(['pagamento_id']));
        $this->assertFalse($fatura->validate(['envio_id']));
        $this->assertFalse($fatura->validate(['total']));
        $this->assertFalse($fatura->validate(['estado']));

        // Tipo de dados incorreto
        $fatura->utilizador_id = "a";
        $fatura->pagamento_id = "a";
        $fatura->envio_id = "a";
        $fatura->total = "a";
        $fatura->estado = "a";
        $this->assertFalse($fatura->validate(['utilizador_id']));
        $this->assertFalse($fatura->validate(['pagamento_id']));
        $this->assertFalse($fatura->validate(['envio_id']));
        $this->assertFalse($fatura->validate(['total']));
        $this->assertFalse($fatura->validate(['estado']));

        // Tipo de dados correto
        $fatura->utilizador_id = 1;
        $fatura->pagamento_id = 1;
        $fatura->envio_id = 1;
        $fatura->total = 0;
        $fatura->estado = Fatura::ESTADO_PAID;
        $this->assertTrue($fatura->validate(['utilizador_id']));
        $this->assertTrue($fatura->validate(['pagamento_id']));
        $this->assertTrue($fatura->validate(['envio_id']));
        $this->assertTrue($fatura->validate(['total']));
        $this->assertTrue($fatura->validate(['estado']));

        // Utilizador, pagamento e envio não existentes
        $fatura->utilizador_id = 100;
        $fatura->pagamento_id = 100;
        $fatura->envio_id = 100;
        $fatura->codigo_id = 100;
        $this->assertFalse($fatura->validate(['utilizador_id']));
        $this->assertFalse($fatura->validate(['pagamento_id']));
        $this->assertFalse($fatura->validate(['envio_id']));
        $this->assertFalse($fatura->validate(['codigo_id']));

        // Estado fora do intervalo
        $fatura->estado = 100;
        $this->assertFalse($fatura->validate(['estado']));

        // Estado dentro do intervalo
        $fatura->estado = Fatura::ESTADO_PAID;
        $this->assertTrue($fatura->validate(['estado']));
    }


}
