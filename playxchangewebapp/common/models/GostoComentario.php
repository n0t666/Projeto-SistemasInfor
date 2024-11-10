<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gostoscomentarios".
 *
 * @property int $utilizador_id
 * @property int $comentario_id
 *
 * @property Comentario $comentario
 * @property Userdata $utilizador
 */
class GostoComentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gostoscomentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'comentario_id'], 'required'],
            [['utilizador_id', 'comentario_id'], 'integer'],
            [['utilizador_id', 'comentario_id'], 'unique', 'targetAttribute' => ['utilizador_id', 'comentario_id']],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentario::class, 'targetAttribute' => ['comentario_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'utilizador_id' => 'Utilizador ID',
            'comentario_id' => 'Comentario ID',
        ];
    }

    /**
     * Gets query for [[Comentario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentario::class, ['id' => 'comentario_id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(Userdata::class, ['id' => 'utilizador_id']);
    }
}
