<?php

use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Iva */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="iva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'percentagem')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'digits' => 2,
            'allowMinus' => false,
            'rightAlign' => false,
            'suffix' => ' %',
        ],
        'options' => ['class' => 'form-control']
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
