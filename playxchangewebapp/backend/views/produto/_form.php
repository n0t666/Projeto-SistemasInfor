<?php

use common\models\Jogo;
use common\models\Plataforma;
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

    <?= $form->field($model, 'jogo_id')->dropDownList(
        ArrayHelper::map($jogos, 'id', 'nome'),
        ['prompt' => 'Selecione o jogo', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($model, 'plataforma_id')->dropDownList(
        ArrayHelper::map($plataformas, 'id', 'nome'),
        ['prompt' => 'Selecione a plataforma', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($model, 'preco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
