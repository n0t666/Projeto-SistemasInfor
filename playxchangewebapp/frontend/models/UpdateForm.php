<?php

namespace frontend\models;

use common\models\Userdata;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UpdateForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $nif;
    public $nome;

    public $profileImageFile;
    public $profileImageFilename;

    public $bannerImageFile;
    public $bannerImageFilename;

    public $privacidadeSeguidores;
    public $privacidadePerfil;
    public $privacidadeJogos;
    public $biografia;
    public $dataNascimento;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['not', ['id' => $this->id]], 'message' => 'Este username já foi usado.'],
            ['username', 'string', 'min' => 2, 'max' => 255, 'skipOnEmpty' => true],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['not', ['id' => $this->id]], 'message' => 'Este email já foi usado.', 'skipOnEmpty' => true],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'skipOnEmpty' => true],

            ['nif', 'string','min' => 9, 'max' => 9, 'skipOnEmpty' => true],
            ['nif', 'unique', 'targetClass' => '\common\models\Userdata', 'filter' => ['not', ['user_id' => $this->id]], 'message' => 'Este NIF já está associado a outra conta.'],

            ['nome', 'string', 'max' => 200, 'skipOnEmpty' => true],

            [['profileImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg'],
            [['bannerImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,jpeg'],

            [['privacidadeSeguidores', 'privacidadePerfil', 'privacidadeJogos'], 'integer'],
            ['privacidadeSeguidores', 'default', 'value' => Userdata::STATUS_PUBLIC],
            ['privacidadeSeguidores', 'in', 'range' => [Userdata::STATUS_PRIVATE, Userdata::STATUS_PUBLIC, Userdata::STATUS_MUTUAL]],
            ['privacidadePerfil', 'default', 'value' => Userdata::STATUS_PUBLIC],
            ['privacidadePerfil', 'in', 'range' => [Userdata::STATUS_PRIVATE, Userdata::STATUS_PUBLIC]],
            ['privacidadeJogos', 'default', 'value' => Userdata::STATUS_PUBLIC],
            ['privacidadeJogos', 'in', 'range' => [Userdata::STATUS_PRIVATE, Userdata::STATUS_PUBLIC, Userdata::STATUS_MUTUAL]],

            ['biografia', 'string', 'max' => 150, 'skipOnEmpty' => true],
            [['dataNascimento'], 'safe'],
            ['dataNascimento', 'validarDataNascimento'],
        ];
    }

    public function validarDataNascimento($attribute, $params)
    {
        if (strtotime($this->$attribute) > time()) {
            $this->addError($attribute, 'A data de nascimento não pode estar no futuro.');
        }
    }

    public function edit()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = Yii::$app->user->identity;
        $profile = $user->profile;



        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->password) {
                $user->setPassword($this->password);
                $user->generateAuthKey();
            }

            if ($user->email !== $this->email) {
                $user->email = $this->email;
                $user->generateEmailVerificationToken();
            }

            $user->username = $this->username;


            if ($user->save()) {
                $profile->nif = $this->nif;
                $profile->nome = $this->nome;
                $profile->privacidadeSeguidores = $this->privacidadeSeguidores;
                $profile->privacidadePerfil = $this->privacidadePerfil;
                $profile->privacidadeJogos = $this->privacidadeJogos;
                $profile->biografia = $this->biografia;
                $profile->dataNascimento = $this->dataNascimento;

                if($this->profileImageFile){
                    $pfp = $this->upload($this->profileImageFile,'@perfilPath');
                    if($pfp){
                        $profile->fotoPerfil = $pfp;
                    }
                }

                if($this->bannerImageFile){
                    $banner = $this->upload($this->bannerImageFile,'@perfilPath');
                    if($banner){
                        $profile->fotoCapa = $banner;
                    }
                }

                if ($profile->save(false) ) {
                    $transaction->commit();
                    return true;
                }
            }
            $transaction->rollBack();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return false;
    }

    public function upload($imageFile, $alias)
    {
        $path = Yii::getAlias($alias);
        $fileName = Yii::$app->getSecurity()->generateRandomString() . '.' . $imageFile->extension;
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        if ($imageFile->saveAs($filePath)) {
            return $fileName;
        }

        return false;
    }




}
