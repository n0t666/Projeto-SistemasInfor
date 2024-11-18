<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "listas".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $descricao
 * @property string|null $dataCriacao
 * @property int $idUtilizador
 * @property int $privacidade
 *
 * @property Gostoslista[] $gostoslistas
 * @property Userdatum $idUtilizador0
 * @property Jogo[] $jogos
 * @property Listasjogo[] $listasjogos
 * @property Userdatum[] $utilizadors
 */

class Lista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'idUtilizador', 'privacidade'], 'required'],
            [['descricao'], 'string'],
            [['dataCriacao'], 'safe'],
            [['idUtilizador', 'privacidade'], 'integer'],
            [['nome'], 'string', 'max' => 80],
            [['idUtilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['idUtilizador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'dataCriacao' => 'Data de Criação',
            'idUtilizador' => 'Utilizador',
            'privacidade' => 'Privacidade',
        ];
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(Userdata::class, ['id' => 'idUtilizador']);
    }

    /**
     * Gets query for [[Jogos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogos()
    {
        return $this->hasMany(Jogo::class, ['id' => 'jogo_id'])->viaTable('listasjogos', ['lista_id' => 'id']);
    }


    /**
     * Gets query for [[Gostos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGostos()
    {
        return $this->hasMany(UserData::class, ['id' => 'utilizador_id'])->viaTable('gostoslistas', ['lista_id' => 'id']);
    }
}
