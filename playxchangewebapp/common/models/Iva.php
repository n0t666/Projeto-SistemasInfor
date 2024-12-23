<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "Ivas".
 *
 * @property int $id
 * @property string $nome
 * @property float $percentagem
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Ivas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'percentagem'], 'required'],
            [['percentagem'], 'number', 'min' => 0, 'max' => 100],
            [['created_at', 'updated_at'], 'safe'],
            [['nome'], 'string', 'max' => 100],
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
            'percentagem' => 'Percentagem',
            'created_at' => 'Data de criação',
            'updated_at' => 'Data de edição',
        ];
    }

    public function behaviors() {

        return[
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
}
