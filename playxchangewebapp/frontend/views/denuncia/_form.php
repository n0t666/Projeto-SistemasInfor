<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="denuncia-form">

    <?php $form = ActiveForm::begin(['action' => $action]); ?>


    <?= $form->field($model, 'denunciante_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'denunciado_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'motivo')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar denúncia', ['class' => 'btn btn-success w-100 my-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
