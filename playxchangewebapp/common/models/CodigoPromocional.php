<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "codigosPromocionais".
 *
 * @property int $id
 * @property string $codigo
 * @property float $desconto
 * @property int $isAtivo
 */
class CodigoPromocional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'codigosPromocionais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'desconto', 'isAtivo'], 'required'],
            [['desconto'], 'number'],
            [['isAtivo'], 'integer'],
            [['codigo'], 'string', 'max' => 50],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'desconto' => 'Desconto',
            'isAtivo' => 'Is Ativo',
        ];
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['codigo_id' => 'id']);
    }


    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadores()
    {
        return $this->hasMany(UserData::class, ['id' => 'utilizador_id'])->viaTable('utilizacaocodigos', ['codigo_id' => 'id']);
    }
}
