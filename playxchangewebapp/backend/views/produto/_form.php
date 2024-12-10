<?php

use common\models\Jogo;
use common\models\Plataforma;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Produto */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var Jogo[] $jogos */
/* @var Plataforma[] $plataformas */

?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jogo_id')->hiddenInput(['value' => $model->jogo_id])->label(false) ?>


    <?= $form->field($model, 'plataforma_id')->dropDownList(
        ArrayHelper::map($plataformas, 'id', 'nome'),
        ['prompt' => 'Selecione a plataforma', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($model, 'preco')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'digits' => 0,
            'allowMinus' => false,
            'rightAlign' => false,
            'suffix' => ' €',
        ],
        'options' => ['class' => 'form-control']
    ]) ?>



    <?= $form->field($model, 'quantidade')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'digits' => 0,
            'allowMinus' => false,
            'rightAlign' => false
        ],
        'displayOptions' => [
                'placeholder' => 'Introduza uma quantidade válida...'
            ],
        'options' => ['class' => 'form-control']
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
