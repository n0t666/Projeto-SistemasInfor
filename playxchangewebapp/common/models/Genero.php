<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "generos".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Jogo[] $jogos
 */
class Genero extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 100],
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

    /**
     * Gets query for [[Jogos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJogos()
    {
        return $this->hasMany(Jogo::class, ['id' => 'jogo_id'])->viaTable('jogosgeneros', ['genero_id' => 'id']);
    }
}
