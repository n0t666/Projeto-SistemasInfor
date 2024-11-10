<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhasfatura".
 *
 * @property int $fatura_id
 * @property int $produto_id
 * @property int $chave_id
 * @property float $precoUnitario
 *
 * @property Chave $chave
 * @property Fatura $fatura
 * @property Produto $produto
 */
class LinhaFatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhasfatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fatura_id', 'produto_id', 'chave_id', 'precoUnitario'], 'required'],
            [['fatura_id', 'produto_id', 'chave_id'], 'integer'],
            [['precoUnitario'], 'number'],
            [['fatura_id', 'produto_id', 'chave_id'], 'unique', 'targetAttribute' => ['fatura_id', 'produto_id', 'chave_id']],
            [['chave_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chave::class, 'targetAttribute' => ['chave_id' => 'id']],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fatura_id' => 'Fatura ID',
            'produto_id' => 'Produto ID',
            'chave_id' => 'Chave ID',
            'precoUnitario' => 'Preco Unitario',
        ];
    }

    /**
     * Gets query for [[Chave]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChave()
    {
        return $this->hasOne(Chave::class, ['id' => 'chave_id']);
    }

    /**
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'fatura_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
