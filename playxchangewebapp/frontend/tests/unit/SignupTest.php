<?php


namespace frontend\tests\Unit;

use frontend\models\SignupForm;
use frontend\tests\UnitTester;
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
        $signup->signup();
        $this->tester->seeRecord('common\models\User', ['username' => "test", 'email' => "test@gmail.com", 'status' => 9]);
        $this->tester->seeRecord('common\models\Userdata', ['nif' => "122456789", 'nome' => "Test Test"]);
        $this->tester->seeEmailIsSent();
        $emailMessage = $this->tester->grabLastSentEmail();
        verify($emailMessage)->instanceOf('yii\mail\MessageInterface');
        verify($emailMessage->getTo())->arrayHasKey($signup->email);
        verify($emailMessage->getSubject())->equals('Account registration at ' . Yii::$app->name);
        verify($emailMessage->getFrom())->arrayHasKey('support@example.com');
    }

    public function testValidation()
    {
        $signup = new SignupForm();

        // Obrigatório
        $this->assertFalse($signup->validate(['username']));
        $this->assertFalse($signup->validate(['email']));
        $this->assertFalse($signup->validate(['password']));
        $this->assertFalse($signup->validate(['nif']));
        $this->assertFalse($signup->validate(['nome']));

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

        // Testar unique

        // Como o tabela dos users é limpa antes de cada teste, não é possível testar o unique , por isso é necessário criar um user
        $user = new \common\models\User();
        $user->username = "test";
        $user->email = "test@gmail.com";
        $user->setPassword("testtest");
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->save();
        $user->status = 10;
        $user->save();


        $this->tester->seeRecord('common\models\User', ['username' => "test", 'email' => "test@gmail.com", 'status' => 10]);
        $signup->username = "test";
        $this->assertFalse($signup->validate(['username']));
        $signup->email = "test@gmail.com";
        $this->assertFalse($signup->validate(['email']));
        $signup->nif = "999999999";
        $this->assertFalse($signup->validate(['nif']));
    }


}
