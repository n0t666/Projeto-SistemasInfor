<?php

use common\models\Jogo;
use common\models\MultiUploadForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Screenshot */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $modelUpload MultiUploadForm */
/* @var $jogo Jogo */

?>

<div class="screenshot-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'jogo_id')->hiddenInput(['value' => $jogo->id])->label(false) ?>

    <?= $form->field($modelUpload, 'imageFile')->fileInput(['class' => 'form-control']) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
