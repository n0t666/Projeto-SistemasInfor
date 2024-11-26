<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

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
            [['produto_id', 'chave'], 'required'],
            [['produto_id', 'plataforma_id', 'isUsada'], 'integer'],
            [['dataGeracao', 'dataExpiracao'], 'date', 'format' => 'php:d-m-Y'],
            //[['dataGeracao', 'dataExpiracao'], 'safe'],
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

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataGeracao'],
                ],
                'value' => function ($event) {
                    return $this->dataGeracao ? date('d-m-Y', strtotime($this->dataGeracao)) : null;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataGeracao'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataGeracao'],
                ],
                'value' => function ($event) {
                    try {
                        if (empty($this->dataGeracao)) {
                            $this->dataGeracao = null;
                        }else{
                            $this->dataGeracao = date('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataLancamento = date('Y-m-d');
                    }

                    return $this->dataGeracao;
                },
            ],

            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataExpiracao'],
                ],
                'value' => function ($event) {
                    return $this->dataGeracao ? date('d-m-Y', strtotime($this->dataGeracao)) : null;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dataExpiracao'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dataExpiracao'],
                ],
                'value' => function ($event) {
                    try {
                        if (empty($this->dataExpiracao)) {
                            $this->dataExpiracao = null;
                        }else{
                            $this->dataExpiracao = date('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        Yii::error("Erro durante a conversão" . $e->getMessage(), __METHOD__);
                        $this->dataExpiracao = null;
                    }

                    return $this->dataExpiracao;
                },
            ],
        ];
    }
}
