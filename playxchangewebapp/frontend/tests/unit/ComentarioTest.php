<?php


namespace frontend\tests\Unit;

use common\models\Avaliacao;
use common\models\Comentario;
use frontend\tests\UnitTester;

class ComentarioTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }


    public function testGuardar()
    {
        $avaliacao = new Avaliacao();
        $avaliacao->utilizador_id = 2;
        $avaliacao->jogo_id = 54;
        $avaliacao->numEstrelas = 5;
        $avaliacao->save();
        $this->tester->seeRecord('common\models\Avaliacao', ['utilizador_id' => 2, 'jogo_id' => 54, 'numEstrelas' => 5]);

        $comentario = new Comentario();
        $comentario->utilizador_id = 2;
        $comentario->jogo_id = 54;
        $comentario->comentario = "Gostei muito do jogo";
        $comentario->save();

        $this->tester->seeRecord('common\models\Comentario', ['utilizador_id' => 2, 'jogo_id' => 54, 'comentario' => "Gostei muito do jogo"]);
    }

    public function testEditar(){
        $comentario = $this->tester->grabRecord('common\models\Comentario', ['id' => 9]);
        $this->assertNotNull($comentario, 'Comentário não encontrado');
        $comentario->comentario = "Gostei muito do jogo, recomendo";
        $comentario->save();
        $this->tester->seeRecord('common\models\Comentario', ['id' => 9, 'comentario' => "Gostei muito do jogo, recomendo"]);
        $this->tester->dontSeeRecord('common\models\Comentario', ['id' => 9, 'comentario' => "Gostei muito do jogo"]);
    }

    public function testApagar()
    {
        $comentario = $this->tester->grabRecord('common\models\Comentario', ['id' => 9]);
        $this->assertNotNull($comentario, 'Comentário não encontrado');
        $comentario->delete();
        $this->tester->dontSeeRecord('common\models\Comentario', ['id' => 9]);
    }

    public function testValidation(){
        $comentario = new Comentario();
        $this->assertFalse($comentario->validate(['utilizador_id']));
        $this->assertFalse($comentario->validate(['jogo_id']));
        $this->assertFalse($comentario->validate(['comentario']));

        $comentario->utilizador_id = "aa";
        $comentario->jogo_id = "aa";
        $this->assertFalse($comentario->validate(['utilizador_id']));
        $this->assertFalse($comentario->validate(['jogo_id']));

        $comentario->utilizador_id = 2;
        $comentario->jogo_id = 54;
        $this->assertTrue($comentario->validate(['utilizador_id']));
        $this->assertTrue($comentario->validate(['jogo_id']));


        // Comentario com mais de 2000 caracteres
        $comentario->comentario = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestibu";
        $this->assertFalse($comentario->validate(['comentario']));

        $comentario->comentario = "Gostei muito do jogo";
        $this->assertTrue($comentario->validate(['comentario']));

        $comentario->utilizador_id = 100;
        $comentario->jogo_id = 100;
        $this->assertFalse($comentario->validate(['utilizador_id']));
        $this->assertFalse($comentario->validate(['jogo_id']));
    }

    public function testComentarioDuplicado(){
        $comentario = new Comentario();
        $comentario->utilizador_id = 19;
        $comentario->jogo_id = 19;
        $comentario->comentario = "ASDasdsa";
        $this->assertFalse($comentario->validate(['utilizador_id', 'jogo_id']));
        $comentario->save();
        $this->tester->dontSeeRecord('common\models\Comentario', ['utilizador_id' => 19, 'jogo_id' => 19, 'comentario' => "ASDasdsa"]);
        $this->tester->seeRecord('common\models\Comentario', ['utilizador_id' => 19, 'jogo_id' => 19, 'comentario' => "let's go one moree"]);
    }



}
