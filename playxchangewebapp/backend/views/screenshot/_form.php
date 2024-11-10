<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Screenshot */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="screenshot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jogo_id')->textInput() ?>

    <?= $form->field($model, 'caminho')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
