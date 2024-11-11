<?php

namespace frontend\models;

use common\models\Userdata;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nif;
    public $nome;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este username já foi usado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já foi usado.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['nif', 'string','min' => 9, 'max' => 9],
            ['nif', 'unique', 'targetClass' => '\common\models\Userdata', 'message' => 'Este NIF já está associado a outra conta.'],

            ['nome', 'required'],
            ['nome', 'string', 'max' => 200],

        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            if($user->save()){
                $auth = Yii::$app->authManager;
                $ClientRole = $auth->getRole('cliente');
                $auth->assign($ClientRole, $user->id);
                $userdata = new Userdata();
                $userdata->user_id = $user->id;
                $userdata->nif = $this->nif;
                $userdata->nome = $this->nome;
                if($userdata->save(false)){
                    $transaction->commit();
                    return $this->sendEmail($user);
                }else{
                    $transaction->rollBack();
                }
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }



        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
