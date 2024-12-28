<?php

namespace common\models;

use backend\controllers\UtilsController;
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


    public function aplicarDesconto($total)
    {
        $valorDescontado = ($total * $this->desconto / 100);
        return min($valorDescontado, $total); // Retorna o menor valor entre o desconto e o total sendo no caso se o desconto for maior que o total, retorna o total
    }

    public function isUsedByUser($user)
    {
        return $user->getCodigos()
            ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id'])
            ->andWhere(['codigosPromocionais.id' => $this->id])
            ->exists();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert && $this->isAtivo == self::STATUS_ACTIVATED) {
            $msg = "Aproveite o código \"{$this->codigo}\" e ganhe {$this->desconto}% de desconto no seu próximo pedido!";
            $obj = new \stdClass();
            $obj->msg = $msg;
            $obj->codigo = $this->attributes;
            $json = json_encode($obj);
            UtilsController::publishMosquitto("NEW-PROMO", $json);
        }

    }

}
