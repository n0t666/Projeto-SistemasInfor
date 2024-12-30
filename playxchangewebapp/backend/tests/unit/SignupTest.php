<?php


namespace backend\tests\Unit;

use backend\models\SignupForm;
use backend\tests\UnitTester;
use Yii;

class SignupTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testSignup()
    {
        $signup = new SignupForm();
        $signup->username = "test";
        $signup->email = "test@gmail.com";
        $signup->password = "testtest";
        $signup->nif = "122456789";
        $signup->nome = "Test Test";
        $signup->role = "cliente";
        $signup->status = 10;
        $signup->signup();
        $this->tester->seeRecord('common\models\User', ['username' => "test", 'email' => "test@gmail.com", 'status' => 10]);
        $this->tester->seeRecord('common\models\Userdata', ['nif' => "122456789", 'nome' => "Test Test"]);
        $this->tester->seeEmailIsSent(); // Verificar se o email foi de facto enviada
        $emailMessage = $this->tester->grabLastSentEmail(); // Obter o último email enviado
        verify($emailMessage)->instanceOf('yii\mail\MessageInterface');
        verify($emailMessage->getTo())->arrayHasKey($signup->email); // Verificar se o email foi enviado para o email do utilizador
        verify($emailMessage->getSubject())->equals('Account registration at ' . Yii::$app->name); // Verificar se o assunto do email é o esperado
        verify($emailMessage->getFrom())->arrayHasKey('support@example.com'); // Verificar se o email foi enviado do email de suporte
    }

    public function testValidateRole(){
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('cliente');
        $this->assertNotNull($role, 'Role não encontrada');
        $signup = new SignupForm();
        $signup->role = "cliente";
        $signup->validateRole('role', []);
        $this->assertEmpty($signup->errors);
    }

    public function testValidateRoleFail(){
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('teste');
        $this->assertNull($role, 'Role encontrada');
        $signup = new SignupForm();
        $signup->role = "teste";
        $signup->validateRole('role', []);
        $this->assertNotEmpty($signup->errors);
    }

    public function testValidation()
    {
        $signup = new SignupForm();


        // Obrigatório
        $this->assertFalse($signup->validate(['username']));
        $this->assertFalse($signup->validate(['email']));
        //$this->assertFalse($signup->validate(['password'])); // Apenas no signup por isso não é possível validar
        //$this->assertFalse($signup->validate(['nif']));
        $this->assertFalse($signup->validate(['nome']));

        $this->assertTrue($signup->validate(['role']));
        $this->assertTrue($signup->validate(['status']));

        // Testar com n de caracteres incorreto
        $signup->username = "a";
        $this->assertFalse($signup->validate(['username']));

        $signup->username = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis,.";
        $this->assertFalse($signup->validate(['username']));

        $signup->email = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis,.";
        $this->assertFalse($signup->validate(['email']));

        $signup->password = "a";
        $this->assertFalse($signup->validate(['password']));

        $signup->nif = "1";
        $this->assertFalse($signup->validate(['nif']));

        $signup->nome = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec qua";
        $this->assertFalse($signup->validate(['nome']));

        // Testar com n de caracteres correto
        $signup->username = "test";
        $this->assertTrue($signup->validate(['username']));

        $signup->email = "test@gmail.com";
        $this->assertTrue($signup->validate(['email']));

        $signup->password = "testtest";
        $this->assertTrue($signup->validate(['password']));

        $signup->nif = "122456789";
        $this->assertTrue($signup->validate(['nif']));

        $signup->nome = "Test Test";
        $this->assertTrue($signup->validate(['nome']));

        $signup->email = "abc.com";
        $this->assertFalse($signup->validate(['email']));

        $signup->email = "abc@com";
        $this->assertFalse($signup->validate(['email']));


        // Validar o NIF com 9 digitos numéricos
        $signup->nif = "AAAAAAAAA";
        $this->assertFalse($signup->validate(['nif']));

        $signup->nif = "123456789";
        $this->assertTrue($signup->validate(['nif']));
    }
}
