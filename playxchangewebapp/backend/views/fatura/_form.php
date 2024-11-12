<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fatura */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilizador_id')->textInput() ?>

    <?= $form->field($model, 'envio_id')->textInput() ?>

    <?= $form->field($model, 'codigo_id')->textInput() ?>

    <?= $form->field($model, 'dataEncomenda')->textInput() ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
