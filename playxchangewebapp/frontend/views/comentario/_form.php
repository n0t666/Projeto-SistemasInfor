<?php


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="comentario-form">

    <?php $form = ActiveForm::begin(['action' => $action]); ?>

    <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model, 'jogo_id')->hiddenInput(['value' => $jogoId])->label(false) ?>

    <?= $form->field($model, 'comentario')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Submeter', ['class' => 'btn btn-success w-100']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>