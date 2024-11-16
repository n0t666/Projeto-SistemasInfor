<?php

use common\models\UploadForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MetodoPagamento */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $modelUpload UploadForm */
?>

<div class="metodo-pagamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isAtivo')->dropDownList([
        1 => 'Sim',
        0 => 'Não'
    ], ['prompt' => 'Selecione...']) ?>


    <?= $form->field($modelUpload, 'imageFile')->fileInput(['class' => 'form-control'])->label('Logótipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
