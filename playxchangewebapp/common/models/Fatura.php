<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $pagamento_id
 * @property int $envio_id
 * @property int|null $codigo_id
 * @property string $dataEncomenda
 * @property float $total
 * @property int $estado
 *
 * @property CodigoPromocional $codigo
 * @property MetodoEnvio $envio
 * @property LinhaFatura[] $linhasfaturas
 * @property MetodoPagamento $pagamento
 * @property Userdata $utilizador
 */
class Fatura extends \yii\db\ActiveRecord
{
    const ESTADO_PENDING = 1;
    const ESTADO_PAID = 2;
    const ESTADO_SHIPPED = 3;
    const ESTADO_DELIVERED = 4;
    const ESTADO_COMPLETED = 5;
    const ESTADO_CANCELLED = 6;
    const ESTADO_REFUNDED = 7;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'pagamento_id', 'envio_id','total', 'estado'], 'required'],
            [['utilizador_id', 'pagamento_id', 'envio_id', 'codigo_id', 'estado'], 'integer'],
            [['dataEncomenda'], 'safe'],
            [['total'], 'number'],
            [['codigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodigoPromocional::class, 'targetAttribute' => ['codigo_id' => 'id']],
            [['pagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetodoPagamento::class, 'targetAttribute' => ['pagamento_id' => 'id']],
            [['envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetodoEnvio::class, 'targetAttribute' => ['envio_id' => 'id']],
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
            'pagamento_id' => 'Método de Pagamento',
            'envio_id' => 'Método de Expedição',
            'codigo_id' => 'Codigo Promocional',
            'dataEncomenda' => 'Data da Encomenda',
            'total' => 'Total',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Codigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodigo()
    {
        return $this->hasOne(CodigoPromocional::class, ['id' => 'codigo_id']);
    }

    /**
     * Gets query for [[Envio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnvio()
    {
        return $this->hasOne(MetodoEnvio::class, ['id' => 'envio_id']);
    }

    /**
     * Gets query for [[Linhasfaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasfaturas()
    {
        return $this->hasMany(LinhaFatura::class, ['fatura_id' => 'id']);
    }

    /**
     * Gets query for [[Pagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPagamento()
    {
        return $this->hasOne(MetodoPagamento::class, ['id' => 'pagamento_id']);
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'dataEncomenda',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dataEncomenda'],
                ],
                'value' => function ($event) {
                    return $this->dataEncomenda ? date('d-m-Y', strtotime($this->dataEncomenda)) : null;
                },
            ],
        ];
    }

    public function getEstadoLabel()
    {
        switch ($this->estado) {
            case self::ESTADO_PENDING:
                return 'Pendente';
            case self::ESTADO_PAID:
                return 'Pago';
            case self::ESTADO_SHIPPED:
                return 'Enviado';
            case self::ESTADO_CANCELLED:
                return 'Cancelado';
            case self::ESTADO_DELIVERED:
                return 'Entregue';
            case self::ESTADO_COMPLETED:
                return 'Completado';
            case self::ESTADO_REFUNDED:
                return 'Reembolsado';
            default:
                return 'Desconhecido';
        }
    }


}
