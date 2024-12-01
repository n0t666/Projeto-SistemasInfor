<?php

use common\models\Denuncia;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="denuncia-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'estado')->dropDownList(
        [
                Denuncia::STATUS_PROCESSING => 'Pendente',
                Denuncia::STATUS_REFUSED => 'Recusada',
                Denuncia::STATUS_BANNED => 'Banido'
        ],
        ['prompt' => 'Selecione o estado da denuncia...']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
