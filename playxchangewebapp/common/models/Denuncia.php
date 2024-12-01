<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
    const STATUS_PROCESSING = 0;
    const STATUS_REFUSED = 1;
    const STATUS_BANNED = 2;


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

    public function getStatusLabel()
    {
        switch ($this->estado) {
            case self::STATUS_PROCESSING:
                return 'A processar';
            case self::STATUS_REFUSED:
                return 'Recusado';
            case self::STATUS_BANNED:
                return 'Banido';
            default:
                return 'Desconhecido';
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataDenuncia'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataDenuncia'],
                ],
                'value' => function ($event) {
                    try {
                        $this->dataDenuncia = new Expression('NOW()');
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataDenuncia = date('Y-m-d');
                    }

                    return $this->dataDenuncia;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataDenuncia'],
                ],
                'value' => function ($event) {
                    return $this->dataDenuncia ? date('d-m-Y', strtotime($this->dataDenuncia)) : null;
                },
            ],
        ];
    }
}
