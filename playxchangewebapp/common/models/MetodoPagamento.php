<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodospagamento".
 *
 * @property int $id
 * @property string $nome
 * @property int $isAtivo
 * @property string|null $logotipo
 *
 * @property Fatura[] $faturas
 */
class MetodoPagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodospagamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['isAtivo'], 'integer'],
            [['nome'], 'string', 'max' => 100],
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
            'isAtivo' => 'Ativo',
            'logotipo' => 'Logotipo',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        if (Yii::$app->controller && Yii::$app->controller->module->id == 'api') {
            return [
                'id',
                'nome',
                'isAtivo',
                'logotipo' => function ($model) {
                    return Yii::getAlias('@utilsUrl') . '/' . $model->logotipo;
                },
            ];
        } else {
            return $fields;
        }
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['pagamento_id' => 'id']);
    }
}
