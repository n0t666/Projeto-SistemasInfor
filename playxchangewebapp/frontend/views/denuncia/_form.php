<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="denuncia-form">

    <?php $form = ActiveForm::begin(['action' => $action]); ?>


    <?= $form->field($model, 'dataAvaliacao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
