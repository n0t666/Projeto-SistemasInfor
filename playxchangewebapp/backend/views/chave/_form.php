<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Chave */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="chave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produto_id')->textInput() ?>

    <?= $form->field($model, 'plataforma_id')->textInput() ?>

    <?= $form->field($model, 'chave')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataGeracao')->textInput() ?>

    <?= $form->field($model, 'dataExpiracao')->textInput() ?>

    <?= $form->field($model, 'isUsada')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
