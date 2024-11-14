<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GeneroSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row mt-2">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'id' => 'search-form'
        ]); ?>
        <div class="input-group">
            <?= $form->field($model, 'globalSearch')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Pesquisar...',
            ])->label(false) ?>
            <div class="input-group-addon pl-2  ">
                <?= Html::submitButton(
                    '<i class="fas fa-search"></i>',
                    ['class' => 'btn btn-primary']
                ) ?>
                <?= Html::resetButton(
                    '<i class="fas fa-undo"></i>',
                    ['class' => 'btn btn-outline-secondary', 'onclick' => 'resetForm()']
                ) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>
