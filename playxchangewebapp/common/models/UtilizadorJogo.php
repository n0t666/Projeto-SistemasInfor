<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "utilizadoresJogos".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $jogo_id
 * @property int $isJogado
 * @property int $isDesejado
 * @property int $isFavorito
 */
class UtilizadorJogo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizadoresJogos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'jogo_id'], 'required'],
            [['utilizador_id', 'jogo_id', 'isJogado', 'isDesejado', 'isFavorito'], 'integer'],
            [['jogo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jogo::class, 'targetAttribute' => ['jogo_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador ID',
            'jogo_id' => 'Jogo ID',
            'isJogado' => 'Is Jogado',
            'isDesejado' => 'Is Desejado',
            'isFavorito' => 'Is Favorito',
        ];
    }

    public function getUtilizador()
    {
        return $this->hasOne(Userdata::class, ['id' => 'utilizador_id']);
    }

    public function getJogo()
    {
        return $this->hasOne(Jogo::class, ['id' => 'jogo_id']);
    }

}
