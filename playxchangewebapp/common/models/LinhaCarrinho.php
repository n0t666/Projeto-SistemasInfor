<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "linhascarrinho".
 *
 * @property int $carrinhos_id
 * @property int $produtos_id
 * @property int $quantidade
 * @property string|null $dataAdicao
 *
 * @property Carrinho $carrinhos
 * @property Produto $produtos
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhascarrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade'], 'required'],
            [['carrinhos_id', 'produtos_id', 'quantidade'], 'integer'],
            [['dataAdicao'], 'safe'],
            [['carrinhos_id', 'produtos_id'], 'unique', 'targetAttribute' => ['carrinhos_id', 'produtos_id']],
            [['carrinhos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinho::class, 'targetAttribute' => ['carrinhos_id' => 'id']],
            [['produtos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produtos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'carrinhos_id' => 'Carrinhos ID',
            'produtos_id' => 'Produtos ID',
            'quantidade' => 'Quantidade',
            'dataAdicao' => 'Data Adicao',
        ];
    }

    /**
     * Gets query for [[Carrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhos()
    {
        return $this->hasOne(Carrinho::class, ['id' => 'carrinhos_id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasOne(Produto::class, ['id' => 'produtos_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dataAdicao',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
