<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $jogo_id
 * @property int $plataforma_id
 * @property float $preco
 * @property int $quantidade
 *
 * @property Carrinho[] $carrinhos
 * @property Chave[] $chaves
 * @property Jogo $jogo
 * @property Linhascarrinho[] $linhascarrinhos
 * @property Linhasfatura[] $linhasfaturas
 * @property Plataforma $plataforma
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jogo_id', 'plataforma_id', 'preco', 'quantidade'], 'required'],
            [['jogo_id', 'plataforma_id', 'quantidade'], 'integer'],
            [['preco'], 'number'],
            [['jogo_id', 'plataforma_id'], 'unique', 'targetAttribute' => ['jogo_id', 'plataforma_id']],
            [['jogo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jogo::class, 'targetAttribute' => ['jogo_id' => 'id']],
            [['plataforma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plataforma::class, 'targetAttribute' => ['plataforma_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jogo_id' => 'Jogo',
            'plataforma_id' => 'Plataforma',
            'preco' => 'Preço',
            'quantidade' => 'Quantidade',
        ];
    }

    /**
     * Gets query for [[Carrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhos()
    {
        return $this->hasMany(Carrinho::class, ['id' => 'carrinhos_id'])->viaTable('linhascarrinho', ['produtos_id' => 'id']);
    }

    /**
     * Gets query for [[Chaves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChaves()
    {
        return $this->hasMany(Chave::class, ['produto_id' => 'id']);
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

    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinhos()
    {
        return $this->hasMany(LinhaCarrinho::class, ['produtos_id' => 'id']);
    }

    /**
     * Gets query for [[Linhasfaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasfaturas()
    {
        return $this->hasMany(Linhasfatura::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Plataforma]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlataforma()
    {
        return $this->hasOne(Plataforma::class, ['id' => 'plataforma_id']);
    }

    /*
     *  O afterSave é utilizado aqui para fazer update de todos os totais do carrinhos que tenham um determinado produto quando o preço do mesmo é alterado
     *  Neste caso é especifico é feito uma verificação para garantir que o cáculo é apenas efetuado quando se trata de um update e não de um insert
     *
     *
     */

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert && array_key_exists('preco', $changedAttributes)) { //Devolve um array com todos os campos novos
            if ($changedAttributes['preco'] != $this->preco) { //Verificar se o old attribute é diferente de o novo a ser inserido

                foreach ($this->carrinhos as $carrinho) { // intera sobre todos os carrinhos
                    $carrinho->recalculateTotal();
                }
            }
        }
    }
}
