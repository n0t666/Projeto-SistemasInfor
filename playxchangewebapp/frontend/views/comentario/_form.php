<?php


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(['action' => ['comentario/create']]); ?>

    <?= $form->field($model, 'jogo_id')->hiddenInput(['value' => $jogoId]) ?>

    <?= $form->field($model, 'comentario')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success w-full']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>