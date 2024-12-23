<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
            [['comentario'], 'string', 'max' => 2000],
            [['utilizador_id', 'jogo_id'], 'unique', 'targetAttribute' => ['utilizador_id', 'jogo_id'], 'message' => 'Já fez um comentário para este jogo'],
            [['jogo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jogo::class, 'targetAttribute' => ['jogo_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['utilizador_id' => 'id']],
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
            'utilizador_id' => 'Utilizador',
            'jogo_id' => 'Jogo',
            'comentario' => 'Comentário',
            'dataComentario' => 'Data do Comentário',
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

    public function beforeDelete() // Antes de apagar temos de garantir que todas as entidades relacioandas são devidamente apagadas senão irá dar erro
    {

        GostoComentario::deleteAll(['comentario_id' => $this->id]);

        return parent::beforeDelete();
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataComentario'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataComentario'],
                ],
                'value' => function ($event) {
                    try {
                        $this->dataComentario = new Expression('NOW()');
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataComentario = date('Y-m-d');
                    }

                    return $this->dataComentario;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataComentario'],
                ],
                'value' => function ($event) {
                    return $this->dataComentario ? date('d-m-Y', strtotime($this->dataComentario)) : null;
                },
            ],
        ];
    }

}
