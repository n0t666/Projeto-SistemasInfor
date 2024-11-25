<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fatura */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado')->dropDownList(
        [
                $model::ESTADO_PENDING => 'Pendente',
                $model::ESTADO_PAID => 'Pago',
                $model::ESTADO_SHIPPED => 'Enviado',
                $model::ESTADO_DELIVERED => 'Entregue',
                $model::ESTADO_COMPLETED => 'Completado',
                $model::ESTADO_CANCELLED => 'Cancelado',
                $model::ESTADO_REFUNDED => 'Reembolsado',
        ],
        ['prompt' => 'Estado da encomenda...', 'class' => 'form-control']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
