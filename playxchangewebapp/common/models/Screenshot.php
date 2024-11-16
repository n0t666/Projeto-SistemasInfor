<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screenshots".
 *
 * @property int $id
 * @property int $jogo_id
 *
 * @property Jogo $jogo
 */
class Screenshot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'screenshots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jogo_id'], 'required'],
            [['jogo_id'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['jogo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jogo::class, 'targetAttribute' => ['jogo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jogo_id' => 'Jogo ID',
            'filename' => 'Filename',
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
}
