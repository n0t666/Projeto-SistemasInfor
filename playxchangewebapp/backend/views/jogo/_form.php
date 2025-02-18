<?php

use common\models\Distribuidora;
use common\models\Editora;
use common\models\Franquia;
use common\models\Genero;
use common\models\Tag;
use common\models\UploadForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var Franquia[] $franquias */
/* @var Distribuidora[] $distribuidoras */
/* @var Editora[] $editoras */
/* @var Tag[] $tags */
/* @var Genero[] $generos */
/* @var UploadForm  $modelUploadCapa */
/* @var UploadForm  $modelUploadScreenshots */
?>

<div class="jogo-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'dataLancamento')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'Introduza a data de lançamento ...'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
                ]
             ]
    )
    ?>


    <?= $form->field($model, 'descricao')->textarea(['rows' => 6, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'trailerLink')->textInput(['maxlength' => true, 'class' => 'form-control','type'=> 'url']) ?>

    <?= $form->field($model, 'franquia_id')->dropDownList(
    ArrayHelper::map($franquias, 'id', 'nome'),
    ['prompt' => 'Nenhuma franquia..', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($modelUploadCapa, 'imageFile')->fileInput(['class' => 'form-control','id'=>'inputCapa'])->label('Foto de Capa') ?>

    <?= $form->field($modelUploadScreenshots, 'imageFiles[]')->fileInput(['class' => 'form-control','multiple' => true, 'accept' => 'image/*','id'=>'inputScreenshots'])->label('Screenshots') ?>
    <div class="mt-3" id="screenshotPreview"></div>

    <?= $form->field($model, 'distribuidora_id')->dropDownList(
    ArrayHelper::map($distribuidoras, 'id', 'nome'),
    ['prompt' => 'Selecione a Distribuidora', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($model, 'editora_id')->dropDownList(
    ArrayHelper::map($editoras, 'id', 'nome'),
    ['prompt' => 'Selecione a Editora', 'class' => 'form-control select2']
    ) ?>

    <?= $form->field($model, 'tags')->checkboxList(
    ArrayHelper::map($tags, 'id', 'nome'),
    ) ?>

    <?= $form->field($model, 'generos')->checkboxList(
    ArrayHelper::map($generos, 'id', 'nome'),
    )->label('Géneros') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
