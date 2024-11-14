<?php

use common\models\User;
use common\models\Userdata;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $userData Userdata */
/* @var $roles[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        User::STATUS_ACTIVE => 'Ativo',
        User::STATUS_INACTIVE => 'Inativo',
        User::STATUS_DELETED => 'Banido',
    ]) ?>

    <?= $form->field($userData, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userData, 'nif')->textInput(['maxlength' => true]) ?>


    <?= $form->field($userData, 'dataNascimento')->widget(DatePicker::class, [
            'options' => ['placeholder' => 'Introduza a data de nascimento ...'],
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
        ]
    )
    ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
