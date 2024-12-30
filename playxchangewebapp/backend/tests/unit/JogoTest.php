<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Jogo;

class JogoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testGuardar(){
        $jogo = new Jogo();
        $jogo->nome = "Jogo Teste";
        $jogo->descricao = "Descrição do jogo teste";
        $jogo->dataLancamento = "01-01-1111";
        $jogo->trailerLink = "https://www.youtube.com/watch?v=123456";
        $jogo->distribuidora_id = 3;
        $jogo->editora_id = 10;
        $jogo->imagemCapa = "imagem.jpg";
        $this->assertTrue($jogo->save(), 'Falha ao guardar jogo: ' . json_encode($jogo->errors)); // Fazer json encode para mostrar todos erros numa string
        $this->tester->seeRecord('common\models\Jogo', ['nome' => "Jogo Teste", 'descricao' => "Descrição do jogo teste", 'trailerLink' => "https://www.youtube.com/watch?v=123456", 'distribuidora_id' => 3, 'editora_id' => 10]);
    }

    public function testEditar()
    {
        $jogo = $this->tester->grabRecord('common\models\Jogo', ['nome' => "Grand Theft Auto V"]);
        $this->assertNotNull($jogo, 'Jogo não encontrado');
        $jogo->nome = "Grand Theft Auto VI";
        $this->assertTrue($jogo->save(), 'Falha ao editar jogo: ' . json_encode($jogo->errors));
        $this->tester->seeRecord('common\models\Jogo', ['nome' => "Grand Theft Auto VI"]);
        $this->tester->dontSeeRecord('common\models\Jogo', ['nome' => "Grand Theft Auto V"]);
    }

    public function testApagar()
    {
        $jogo = new Jogo();
        $jogo->nome = "Jogo Teste";
        $jogo->descricao = "Descrição do jogo teste";
        $jogo->dataLancamento = "01-01-1111";
        $jogo->trailerLink = "https://www.youtube.com/watch?v=123456";
        $jogo->distribuidora_id = 3;
        $jogo->editora_id = 10;
        $jogo->imagemCapa = "imagem.jpg";
        $this->assertTrue($jogo->save(), 'Falha ao guardar jogo: ' . json_encode($jogo->errors));
        $jogo->delete();
        $this->tester->dontSeeRecord('common\models\Jogo', ['nome' => "Jogo Teste"]);
    }

    public function testValidation()
    {
        // Obrigatório
        $jogo = new Jogo();
        $this->assertFalse($jogo->validate(['nome']));
        $this->assertFalse($jogo->validate(['dataLancamento']));
        $this->assertFalse($jogo->validate(['trailerLink']));
        $this->assertFalse($jogo->validate(['distribuidora_id']));
        $this->assertFalse($jogo->validate(['editora_id']));
        $this->assertFalse($jogo->validate(['imagemCapa']));

        // Formato da data - formato incorreto
        $jogo->dataLancamento = "1111-01-01";
        $this->assertFalse($jogo->validate(['dataLancamento']));

        // Formato da data - formato correto
        $jogo->dataLancamento = "01-01-1111";
        $this->assertTrue($jogo->validate(['dataLancamento']));

        // Tipo dados
        $jogo->nome = 1;
        $this->assertFalse($jogo->validate(['nome']));

        $jogo->nome ="A";
        $this->assertTrue($jogo->validate(['nome']));

        $jogo->franquia_id = "A";
        $this->assertFalse($jogo->validate(['franquia_id']));

        $jogo->distribuidora_id = "A";
        $this->assertFalse($jogo->validate(['distribuidora_id']));

        $jogo->editora_id = "A";
        $this->assertFalse($jogo->validate(['editora_id']));

        $jogo->imagemCapa = 1;
        $this->assertFalse($jogo->validate(['imagemCapa']));

        // Tamanho máximo
        $jogo->nome = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec qua";
        $this->assertFalse($jogo->validate(['nome']));

        $jogo->imagemCapa = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis,.";
        $this->assertFalse($jogo->validate(['imagemCapa']));

        // Formato do link do trailer
        $jogo->trailerLink = "www.youtube.com/watch?v=123456";
        $this->assertFalse($jogo->validate(['trailerLink']));

        $jogo->trailerLink = "https://www.youtube.com/watch?v=123456";
        $this->assertTrue($jogo->validate(['trailerLink']));

        // Unique
        $jogo->nome = "Grand Theft Auto V";
        $this->assertFalse($jogo->validate(['nome']));

        $jogo->nome = "Jogo Teste";
        $this->assertTrue($jogo->validate(['nome']));

        // Existir
        $jogo->distribuidora_id = 100;
        $this->assertFalse($jogo->validate(['distribuidora_id']));

        $jogo->distribuidora_id = 3;
        $this->assertTrue($jogo->validate(['distribuidora_id']));

        $jogo->editora_id = 100;
        $this->assertFalse($jogo->validate(['editora_id']));

        $jogo->editora_id = 10;
        $this->assertTrue($jogo->validate(['editora_id']));

        $jogo->franquia_id = 100;
        $this->assertFalse($jogo->validate(['franquia_id']));

        $jogo->franquia_id = 3;
        $this->assertTrue($jogo->validate(['franquia_id']));

    }


}
