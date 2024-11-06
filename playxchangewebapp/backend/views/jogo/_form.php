<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Jogo $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\Tag[] $tags  */

var_dump($tags);

?>

<div class="jogo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataLancamento')->textInput() ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'trailerLink')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'franquia_id')->textInput() ?>

    <?= $form->field($model, 'imagemCapa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publicadora_id')->textInput() ?>

    <?= $form->field($model, 'editora_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
