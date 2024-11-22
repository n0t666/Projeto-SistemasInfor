<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plataformas".
 *
 * @property int $id
 * @property string $nome
 * @property string $logotipo
 *
 * @property Chafe[] $chaves
 * @property Produto[] $produtos
 */
class Plataforma extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plataformas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'logotipo'], 'required'],
            [['nome'], 'string', 'max' => 50],
            [['logotipo'], 'string', 'max' => 255],
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
            'logotipo' => 'Logotipo',
        ];
    }

    /**
     * Gets query for [[Chaves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChaves()
    {
        return $this->hasMany(Chave::class, ['plataforma_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['plataforma_id' => 'id']);
    }
}
