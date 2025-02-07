
<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Avaliacao */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="avaliacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilizador_id')->textInput()->label(false) ?>

    <?= $form->field($model, 'jogo_id')->textInput()->label(false) ?>

    <?= $form->field($model, 'numEstrelas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataAvaliacao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
