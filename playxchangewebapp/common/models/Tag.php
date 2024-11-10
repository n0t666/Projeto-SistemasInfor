<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Tags".
 *
 * @property int $id
 * @property string $nome
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 200],
            [['nome'], 'unique'],
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
        ];
    }

    public function getJogos(){
        return $this->hasMany(Jogo::class, ['id' => 'jogo_id'])->viaTable('jogosTags', ['tag_id' => 'id']);
    }
}
