<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Franquia */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="franquia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
