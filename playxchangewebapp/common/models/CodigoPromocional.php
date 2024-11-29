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

    CONST STATUS_DISABLED = 0; // Desconto não pode ser usado no checkout

    CONST STATUS_ACTIVATED = 1; // Desconto pode ser usado no checkout

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
            [['desconto'], 'integer','max'=>100],
            [['isAtivo'], 'integer'],
            [['codigo'], 'string', 'max' => 50],
            [['codigo'], 'unique'],
            ['isAtivo', 'in', 'range' => [self::STATUS_ACTIVATED, self::STATUS_DISABLED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'desconto' => 'Desconto',
            'isAtivo' => 'Ativo',
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
