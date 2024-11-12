<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Produto */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jogo_id')->textInput() ?>

    <?= $form->field($model, 'plataforma_id')->textInput() ?>

    <?= $form->field($model, 'preco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
