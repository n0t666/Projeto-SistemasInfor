<?php

use backend\models\SignupForm;
use common\models\User;
use common\models\Userdata;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model SignupForm */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(
        ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'), // Map the roles to the dropdown
        ['prompt' => 'Selecione um Papel'] // Optional prompt
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            User::STATUS_ACTIVE => 'Ativo',
            User::STATUS_INACTIVE => 'Inativo',
            User::STATUS_DELETED => 'Banido',
        ],
        ['prompt' => 'Selecione o Status']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
