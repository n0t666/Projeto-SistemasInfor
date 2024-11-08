<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Faqs".
 *
 * @property int $id
 * @property string $pergunta
 * @property string $descricao
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Faqs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pergunta', 'descricao'], 'required'],
            [['descricao'], 'string'],
            [['pergunta'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pergunta' => 'Pergunta',
            'descricao' => 'Descricao',
        ];
    }
}
