<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property float|null $total
 *
 * @property LinhaCarrinho[] $linhascarrinhos
 * @property Produto[] $produtos
 * @property Userdata $utilizador
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id'], 'required'],
            [['utilizador_id','count'], 'integer'],
            [['total'], 'number'],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userdata::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['carrinhos_id' => 'id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['id' => 'produtos_id'])->viaTable('linhascarrinho', ['carrinhos_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(Userdata::class, ['id' => 'utilizador_id']);
    }

    public function fields()
    {
        $fields = parent::fields();

        return $fields;
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        if (Yii::$app->controller && Yii::$app->controller->module->id == 'api') {
            return [
                'linhascarrinhos',
            ];
        } else {
            return [];
        }
    }

    public function recalculateTotal()
    {
        $total = 0;
        $totalProdutos = 0;
        foreach ($this->linhascarrinhos as $linhaCarrinho) {
            $total += $linhaCarrinho->produtos->preco * $linhaCarrinho->quantidade;
            $totalProdutos += $linhaCarrinho->quantidade;
        }
        $this->total = $total;
        $this->count = $totalProdutos;

        if (!$this->save(false)) {
            throw new \Exception('Erro ao salvar o carrinho após recalcular o total');
        }
    }

}
