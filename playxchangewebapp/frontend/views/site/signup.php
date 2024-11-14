<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registar';

$img = Yii::getAlias('@web') . "/images/authForms/register2.jpg";

?>
<div class="site-signup my-5">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                <div class="card-img-left d-none d-md-flex" style="width: 45%; background: scroll center url('<?= $img ?>'); background-size: cover;">
                </div>
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Registar</h5>

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'nome', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingNome'],
                        ])->textInput(['id' => 'floatingNome', 'placeholder' => 'Nome Completo', 'required' => true, 'autocomplete' => 'off']) ?>
                    </div>
                    

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'nif', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingNif'],
                        ])->textInput(['id' => 'floatingNif', 'placeholder' => 'NIF', 'required' => false, 'autocomplete' => 'off','type' => 'number']) ?>
                    </div>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingInputUsername'],
                        ])->textInput(['id' => 'floatingInputUsername', 'placeholder' => 'myusername', 'required' => true, 'autofocus' => true, 'autocomplete' => 'off']) ?>
                    </div>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'email', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingInputEmail'],
                        ])->input('email', ['id' => 'floatingInputEmail', 'placeholder' => 'name@example.com', 'autocomplete' => 'off']) ?>
                    </div>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'password', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingPassword'],
                        ])->passwordInput(['id' => 'floatingPassword', 'placeholder' => 'Password', 'autocomplete' => 'new-password']) ?>
                    </div>

                    <div class="d-grid mb-2">
                        <?= Html::submitButton('Registar', ['class' => 'btn btn-lg btn-primary btn-login fw-bold text-uppercase', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <a class="d-block text-center mt-2 small" href="#">Have an account? Sign In</a>

                    <hr class="my-4">
                </div>
            </div>
        </div>
    </div>
</div>
