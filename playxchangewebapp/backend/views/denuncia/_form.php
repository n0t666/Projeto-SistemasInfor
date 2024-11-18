<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="denuncia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'denunciante_id')->textInput() ?>

    <?= $form->field($model, 'denunciado_id')->textInput() ?>

    <?= $form->field($model, 'motivo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dataDenuncia')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
