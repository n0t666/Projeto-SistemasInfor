<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chaves".
 *
 * @property int $id
 * @property int $produto_id
 * @property int $plataforma_id
 * @property string $chave
 * @property string|null $dataGeracao
 * @property string|null $dataExpiracao
 * @property int $isUsada
 *
 * @property LinhaFatura[] $linhasfaturas
 * @property Plataforma $plataforma
 * @property Produto $produto
 */
class Chave extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chaves';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'plataforma_id', 'chave'], 'required'],
            [['produto_id', 'plataforma_id', 'isUsada'], 'integer'],
            [['dataGeracao', 'dataExpiracao'], 'safe'],
            [['chave'], 'string', 'max' => 255],
            [['chave'], 'unique'],
            [['plataforma_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plataforma::class, 'targetAttribute' => ['plataforma_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto_id' => 'Produto',
            'plataforma_id' => 'Plataforma',
            'chave' => 'Chave',
            'dataGeracao' => 'Data de Geração',
            'dataExpiracao' => 'Data de Expiração',
            'isUsada' => 'Usada',
        ];
    }

    /**
     * Gets query for [[Linhasfaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasfaturas()
    {
        return $this->hasMany(Linhafatura::class, ['chave_id' => 'id']);
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
