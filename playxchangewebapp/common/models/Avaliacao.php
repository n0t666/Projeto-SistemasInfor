<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "avaliacoes".
 *
 * @property int $utilizador_id
 * @property int $jogo_id
 * @property float $numEstrelas
 * @property string $dataAvaliacao
 *
 * @property Comentario[] $comentarios
 * @property Jogo $jogo
 * @property Userdata $utilizador
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'jogo_id', 'numEstrelas'], 'required'],
            [['utilizador_id', 'jogo_id'], 'integer'],
            [['numEstrelas'], 'number'],
            [['dataAvaliacao'], 'safe'],
            [['utilizador_id', 'jogo_id'], 'unique', 'targetAttribute' => ['utilizador_id', 'jogo_id']],
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
            'utilizador_id' => 'Utilizador',
            'jogo_id' => 'Jogo',
            'numEstrelas' => 'Número de estrelas',
            'dataAvaliacao' => 'Data da avaliação ',
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dataAvaliacao',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * Gets query for [[Jogo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogo()
    {
        return $this->hasOne(Jogo::class, ['id' => 'jogo_id']);
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
