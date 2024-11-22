<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Chave */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="chave-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'produto_id')->dropDownList(
        ArrayHelper::map($produtos, 'id', function ($produto) {
            return $produto->jogo->nome . ' (' . $produto->plataforma->nome . ')';
        }),
        ['prompt' => 'Escolha um jogo..', 'class' => 'form-control']
    ) ?>

    <?= $form->field($model, 'dataGeracao')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'Introduza a data de geração (opcional) ...'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
        ]
    )
    ?>

    <?= $form->field($model, 'dataExpiracao')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'Introduza a data de expiração (opcional) ...'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
        ]
    )
    ?>

    <?= $form->field($model, 'chave')->widget(MaskedInput::class, [
        'mask' => '*****-*****-*****',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
