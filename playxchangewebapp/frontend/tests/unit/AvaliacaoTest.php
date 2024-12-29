<?php


namespace frontend\tests\Unit;

use common\models\Avaliacao;
use frontend\tests\UnitTester;

class AvaliacaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testGuardar(){
        $avaliacao = new Avaliacao();
        $avaliacao->utilizador_id = 1;
        $avaliacao->jogo_id = 54;
        $avaliacao->numEstrelas = 5;
        $avaliacao->save();
        $this->tester->seeRecord('common\models\Avaliacao', ['utilizador_id' => 1, 'jogo_id' => 54, 'numEstrelas' => 5]);
    }

    public function testEditar(){
        $avaliacao = $this->tester->grabRecord('common\models\Avaliacao', ['utilizador_id' => 19, 'jogo_id' => 19]);
        $this->assertNotNull($avaliacao, 'Avaliação não encontrada');
        $avaliacao->numEstrelas = 4.0;
        $avaliacao->save();
        $this->tester->seeRecord('common\models\Avaliacao', ['utilizador_id' => 19, 'jogo_id' => 19, 'numEstrelas' => 4.0]);
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['utilizador_id' => 19, 'jogo_id' => 19, 'numEstrelas' => 2.0]);
    }

    public function testApagar()
    {
        $avaliacao = $this->tester->grabRecord('common\models\Avaliacao', ['utilizador_id' => 1, 'jogo_id' => 19]);
        $this->assertNotNull($avaliacao, 'Avaliação não encontrada');
        $avaliacao->delete();
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['utilizador_id' => 1, 'jogo_id' => 19]);
    }

    public function testValidation()
    {
        $avaliacao = new Avaliacao();
        $this->assertFalse($avaliacao->validate(['utilizador_id']));
        $this->assertFalse($avaliacao->validate(['jogo_id']));
        $this->assertFalse($avaliacao->validate(['numEstrelas']));

        // Tipo de dados incorreto
        $avaliacao->utilizador_id = "a";
        $avaliacao->jogo_id = "a";
        $this->assertFalse($avaliacao->validate(['utilizador_id']));
        $this->assertFalse($avaliacao->validate(['jogo_id']));

        // Tipo de dados correto
        $avaliacao->utilizador_id = 1;
        $avaliacao->jogo_id = 54;
        $this->assertTrue($avaliacao->validate(['utilizador_id']));
        $this->assertTrue($avaliacao->validate(['jogo_id'],));

        // Utilizador e jogo não existentes
        $avaliacao->utilizador_id = 100;
        $avaliacao->jogo_id = 100;
        $this->assertFalse($avaliacao->validate(['utilizador_id']));
        $this->assertFalse($avaliacao->validate(['jogo_id'],));

        // Número de estrelas fora do intervalo
        $avaliacao->numEstrelas = 0;
        $this->assertFalse($avaliacao->validate(['numEstrelas']));
        $avaliacao->numEstrelas = 5.1;
        $this->assertFalse($avaliacao->validate(['numEstrelas']));

        // Número de estrelas correto
        $avaliacao->numEstrelas = 3;
        $this->assertTrue($avaliacao->validate(['numEstrelas'],"O número de estrelas não pode ser menor que 0.5"));




    }





}
