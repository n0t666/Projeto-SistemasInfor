<?php

use common\models\Userdata;
use frontend\models\UpdateForm;
use kartik\date\DatePicker;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/* @var $model UpdateForm */

?>




<div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id' => 'update-form']); ?>
                        <div class="d-flex flex-column align-items-center text-center">
                            <!-- Cover Image Section -->
                            <div class="position-relative w-100" style="height: 150px;">
                                <img id="cover-img-preview" src="<?= Yii::$app->user->identity->profile->fotoCapa?>" alt="Cover" class="img-fluid w-100 h-100">
                                <?= $form->field($model, 'bannerImageFile')->fileInput([
                                    'id' => 'cover-picture',
                                    'style' => 'display: none;',

                                    'onchange' => 'previewImage(event, "cover-img-preview", "cover-picture", "remove-cover", "add-cover")'
                                ])->label(false) ?>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <?= Html::label('<i class="fas fa-camera fa-2x"></i>', 'cover-picture', ['id' => 'add-cover', 'class' => 'text-white']) ?>
                                </div>
                                <button id="remove-cover" type="button" style="display: none;" class="remove-btn position-absolute bottom-0 end-0" onclick="removeCover()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Profile Image Section -->
                            <div class="position-relative mt-4">
                                <img id="profile-img-preview" src="<?= Yii::$app->user->identity->profile->fotoPerfil?>" alt="Admin" class="rounded-circle p-1 bg-primary">
                                <?= $form->field($model, 'profileImageFile')->fileInput([
                                    'id' => 'profile-picture',
                                    'style' => 'display: none;',
                                    'onchange' => 'previewImage(event, "profile-img-preview", "profile-picture", "remove-profile", "add-profile")'
                                ])->label(false) ?>
                                <label for="profile-picture" id="add-profile" class="position-absolute bottom-0 end-0 mb-2 me-2 text-white">
                                    <i class="fas fa-camera fa-lg"></i>
                                </label>
                                <button id="remove-profile" type="button" style="display: none;" class="remove-btn position-absolute bottom-0 end-0 mb-2 me-2" onclick="removeProfile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <hr class="my-2">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mx-auto justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-12 text-secondary">
                                <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'class' => 'form-control w-100','template' => "{input}\n{label}\n{error}",]) ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-secondary">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true,              'template' => "{input}\n{label}\n{error}",]) ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 text-secondary">
                                <?= $form->field($model, 'biografia')->textarea(['maxlength' => true, 'class' => 'form-control w-100']) ?>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 text-secondary">
                                <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 text-secondary">
                                <?= $form->field($model, 'dataNascimento')->widget(DatePicker::class, [
                                        'options' => ['placeholder' => 'Introduza a data de nascimento ...'],
                                        'pluginOptions' => [
                                            'todayHighlight' => false,
                                            'todayBtn' => false,
                                            'autoclose' => true,
                                            'format' => 'dd-mm-yyyy'
                                        ]
                                    ]
                                )
                                ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'privacidadeSeguidores')->dropDownList([
                            UserData::STATUS_PRIVATE => 'Privado',
                            UserData::STATUS_PUBLIC => 'Público',
                            UserData::STATUS_MUTUAL => 'Mútuo',
                        ]) ?>

                        <?= $form->field($model, 'privacidadeFavoritos')->dropDownList([
                            UserData::STATUS_PRIVATE => 'Privado',
                            UserData::STATUS_PUBLIC => 'Público',
                            UserData::STATUS_MUTUAL => 'Mútuo',
                        ]) ?>

                        <?= $form->field($model, 'privacidadeJogos')->dropDownList([
                            UserData::STATUS_PRIVATE => 'Privado',
                            UserData::STATUS_PUBLIC => 'Público',
                            UserData::STATUS_MUTUAL => 'Mútuo',
                        ]) ?>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary px-4']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
