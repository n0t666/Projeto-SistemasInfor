<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $jogo_id
 * @property string $comentario
 * @property string|null $dataComentario
 *
 * @property Userdata $utilizador
 * @property Jogo $jogo
 * @property GostoComentario[] $gostosComentarios
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'jogo_id', 'comentario'], 'required'],
            [['utilizador_id', 'jogo_id'], 'integer'],
            [['comentario'], 'string'],
            [['dataComentario'], 'safe'],
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
            'comentario' => 'Comentario',
            'dataComentario' => 'Data Comentario',
        ];
    }

    /**
     * Gets query for [[Gostoscomentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGostoscomentarios()
    {
        return $this->hasMany(GostoComentario::class, ['comentario_id' => 'id']);
    }

    /**
     * Relacionamento com o utilizador (quem fez a avaliação).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(Userdata::class, ['id' => 'utilizador_id']);
    }

    /**
     * Relacionamento com o jogo (avaliado pelo utilizador).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogo()
    {
        return $this->hasOne(Jogo::class, ['id' => 'jogo_id']);
    }

}
