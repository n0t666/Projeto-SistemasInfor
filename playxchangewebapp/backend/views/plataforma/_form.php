<?php

use common\models\UploadForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Plataforma */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $modelUpload UploadForm */

?>

<div class="plataforma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUpload, 'imageFile')->fileInput(['class' => 'form-control'])->label('Logótipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
