<?php


namespace frontend\tests\Unit;

use common\models\CodigoPromocional;
use frontend\tests\UnitTester;

class CodigoPromocionalTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testAplicarDesconto(){
        $codigo = new CodigoPromocional();
        $codigo->desconto = 10;

        // Testar se o desconto é aplicado corretamente, sendo que aplicar desconto devolve o valor do desconto e não o valor final
        $total = 100;
        $this->assertEquals(10, $codigo->aplicarDesconto($total));


        // Se o desconto for maior que o valor total, o desconto deve ser igual ao valor total
        $codigo->desconto = 105;
        $total = 2;
        $this->assertEquals(2, $codigo->aplicarDesconto($total));
    }

    public function testGuardar()
    {
        $codigo = new CodigoPromocional();
        $codigo->codigo = "TESTE";
        $codigo->desconto = 10;
        $codigo->isAtivo = 1;
        $this->assertTrue($codigo->save(), 'Falha ao guardar código: ' . json_encode($codigo->errors));
        $this->tester->seeRecord('common\models\CodigoPromocional', ['codigo' => "TESTE", 'desconto' => 10, 'isAtivo' => 1]);
    }

    public function testEditar(){
        $codigo = $this->tester->grabRecord('common\models\CodigoPromocional', ['codigo' => "COMIVA"]);
        $this->assertNotNull($codigo, 'Código não encontrado');
        $codigo->codigo = "COMIVAEDITADO";
        $codigo->desconto = 20;
        $this->assertTrue($codigo->save(), 'Falha ao editar código: ' . json_encode($codigo->errors));
        $this->tester->seeRecord('common\models\CodigoPromocional', ['codigo' => "COMIVAEDITADO", 'desconto' => 20]);
        $this->tester->dontSeeRecord('common\models\CodigoPromocional', ['codigo' => "COMIVA", 'desconto' => 10]);
    }

    public function testApagar()
    {
        $codigo = $this->tester->grabRecord('common\models\CodigoPromocional', ['codigo' => "SEMIVA"]);
        $this->assertNotNull($codigo, 'Código não encontrado');
        $codigo->delete();
        $this->tester->dontSeeRecord('common\models\CodigoPromocional', ['codigo' => "SEMIVA"]);
    }

    public function testValidation(){
        $codigo = new CodigoPromocional();
        $this->assertFalse($codigo->validate(), 'Código não pode ser guardado sem código, desconto e isAtivo');

        // Testar erro limite de caracteres
        $codigo->codigo = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras efficitur maximus est, sit amet viverra sem efficitur ac. Nam a est lacinia, varius urna sit amet, elementum nisi. Nunc in rhoncus tellus. Mauris sem ex, auctor sit amet rutrum feugiat, molestie ac lectus. In metus eros, rhoncus quis tincidunt sed, pellentesque.";
        $this->assertFalse($codigo->validate(['codigo']), 'Código não pode ter mais de 50 caracteres');

        // Testar codigo válido
        $codigo->codigo = "UMCODIGO";
        $this->assertTrue($codigo->validate(['codigo']), 'Código válido');

        // Testar número string em vez de número
        $codigo->desconto = "fdsfsd";
        $this->assertFalse($codigo->validate(['desconto']), 'Desconto não pode ser uma string');

        // Testar desconto maior que 100
        $codigo->desconto = 101;
        $this->assertFalse($codigo->validate(['desconto']), 'Desconto não pode ser maior que 100');

        // Testar desconto menor que 0
        $codigo->desconto = -1;
        $this->assertFalse($codigo->validate(['desconto']), 'Desconto não pode ser menor que 0');

        // Testar desconto válido
        $codigo->desconto = 10;
        $this->assertTrue($codigo->validate(['desconto']), 'Desconto válido');

        // Testar um valor inválido para isAtivo
        $codigo->isAtivo = 2;
        $this->assertFalse($codigo->validate(['isAtivo']), 'só pode ser 0 ou 1');

        // Testar isAtivo válido
        $codigo->isAtivo = 1;
        $this->assertTrue($codigo->validate(['isAtivo']));

        // Testar unique para o código
        $codigo->codigo = "SEMIVA";
        $codigo->desconto = 10;
        $codigo->isAtivo = 1;
        $this->assertFalse($codigo->save(), 'Código não pode ser guardado se já existir um código com o mesmo nome');

        // Testar código único
        $codigo->codigo = "SEMIVAS";
        $this->assertTrue($codigo->save(), 'Código deve ser guardado se for único');
    }

    public function testIsUsedByUser()
    {
        $codigo = new CodigoPromocional();
        $codigo->codigo = "TESTE2";
        $codigo->desconto = 10;
        $codigo->isAtivo = 1;
        $codigo->save();
        $user = $this->tester->grabRecord('common\models\Userdata', ['id' => 1]);
        $this->assertCount(0, $codigo->utilizadores, 'O código promocional não deve estar associado a nenhum utilizador');
        $this->assertFalse($codigo->isUsedByUser($user), 'Código não foi utilizado por nenhum utilizador');
        $codigo->link('utilizadores', $user);
        $codigo->refresh();
        $this->assertCount(1, $codigo->utilizadores, 'O código promocional deve estar associado a 1 utilizador');
        $this->assertEquals($user->id, $codigo->utilizadores[0]->id, 'O utilizador associado ao código promocional é o utilizador correto');
        $this->assertTrue($codigo->isUsedByUser($user), 'Código foi utilizado por um utilizador');
    }










}
