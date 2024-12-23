<?php

namespace common\models;

use backend\controllers\UtilsController;
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
            [['utilizador_id', 'pagamento_id', 'envio_id', 'total', 'estado'], 'required'],
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
        ];
    }

    public function getDataEncomenda()
    {
        return $this->dataEncomenda ? date('d-m-Y', strtotime($this->dataEncomenda)) : null;
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert && array_key_exists('estado', $changedAttributes)) {
            if ($changedAttributes['estado'] != $this->estado) {
                $id = $this->id;
                $estado = $this->getEstadoLabel();
                $utilizador = $this->utilizador->user->username;
                $data = $this->dataEncomenda;
                $msg = "A encomenda feita a " . $data . " com o id " . $id . " mudou de estado para " . $estado;
                $obj = new \stdClass();
                $obj->id = $id;
                $obj->msg = $msg;
                $obj->user = $utilizador;
                $obj->estado = $this->estado;
                $json = json_encode($obj);
                UtilsController::publishMosquitto("ORDER-UPDATE", $json);
            }


        }
    }

    public function adicionarLinhaFatura($produtoId, $precoUnitario,$chaveId = null)
    {
        $linhaFatura = new LinhaFatura();
        $linhaFatura->fatura_id = $this->id;
        $linhaFatura->produto_id = $produtoId;
        $linhaFatura->precoUnitario = $precoUnitario;
        if($chaveId != null){
            $linhaFatura->chave_id = $chaveId;
        }
        if (!$linhaFatura->save()) {
            var_dump($linhaFatura->errors);
            die();
            throw new \Exception('Erro ao adicionar linha de fatura');
        }
        return $linhaFatura;
    }

    public function getLinhasFaturaGroup()
    {
        $linhasFatura = [];
        foreach ($this->linhasfaturas as $linha) {
            $produto = $linha->produto_id;
            if(!isset($linhasFatura[$produto])){
                $linhasFatura[$produto] = [
                    'produto' => $linha->produto,
                    'precoUnitario' => $linha->precoUnitario,
                    'quantidade' => 0,
                    'subtotal' => 0,
                    'chaves' => []
                ];
            }
            $linhasFatura[$produto]['quantidade'] += 1;
            $linhasFatura[$produto]['subtotal'] += $linha->precoUnitario;
            if($linha->chave_id != null){
                $linhasFatura[$produto]['chaves'][] = $linha->chave;
            }
        }
        return $linhasFatura;
    }

    public function getTotalSemDesconto()
    {
        $total = 0;
        foreach ($this->linhasfaturas as $linha) {
            $total += $linha->precoUnitario;
        }
        return $total;
    }

    public function getDesconto($totalSemDesconto)
    {
        $quantidadeDesconto = 0;
        if($this->codigo){
            $quantidadeDesconto = $this->codigo->aplicarDesconto($totalSemDesconto);
        }
        return $quantidadeDesconto;
    }



}
