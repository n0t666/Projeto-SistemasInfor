<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "denuncias".
 *
 * @property int $denunciante_id
 * @property int $denunciado_id
 * @property string $motivo
 * @property string|null $dataDenuncia
 * @property int|null $estado
 *
 * @property Userdata $denunciado
 * @property Userdata $denunciante
 */
class Denuncia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'denuncias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['denunciante_id', 'denunciado_id', 'motivo'], 'required'],
            [['denunciante_id', 'denunciado_id', 'estado'], 'integer'],
            [['motivo'], 'string'],
            [['dataDenuncia'], 'safe'],
            [['denunciante_id', 'denunciado_id'], 'unique', 'targetAttribute' => ['denunciante_id', 'denunciado_id']],
            [['denunciante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['denunciante_id' => 'id']],
            [['denunciado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['denunciado_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'denunciante_id' => 'Denunciante',
            'denunciado_id' => 'Denunciado',
            'motivo' => 'Motivo',
            'dataDenuncia' => 'Data Denúncia',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Denunciado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenunciado()
    {
        return $this->hasOne(Userdata::class, ['id' => 'denunciado_id']);
    }

    /**
     * Gets query for [[Denunciante]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDenunciante()
    {
        return $this->hasOne(Userdata::class, ['id' => 'denunciante_id']);
    }
}
