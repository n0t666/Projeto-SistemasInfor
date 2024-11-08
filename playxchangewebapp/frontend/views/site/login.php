<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Entrar';
\frontend\assets\CustomAsset::register($this);

$img = Yii::getAlias('@web') . "/images/authForms/login.jpg";

?>
<div class="site-login my-xl-2">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                <div class="card-img-left d-none d-md-flex" style=" width: 45%;background: scroll center url('<?= $img ?>');background-size: cover;">
                </div>
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Login</h5>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingInputUsername'],
                        ])->textInput([
                            'id' => 'floatingInputUsername',
                            'placeholder' => 'myusername',
                            'autofocus' => true,
                            'autocomplete' => 'off'
                        ]) ?>
                    </div>

                    <div class="form-floating mb-3">
                        <?= $form->field($model, 'password', [
                            'options' => ['class' => 'form-floating mb-3'],
                            'template' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['for' => 'floatingPassword'],
                        ])->passwordInput([
                            'id' => 'floatingPassword',
                            'placeholder' => 'Password',
                            'autocomplete' => 'new-password'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class='form-check'>{input}{label}</div>\n{error}",
                        ]) ?>
                    </div>

                    <div class="my-1 mx-0" style="color:#999;">
                        If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                        <br>
                        Need a new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                    </div>

                    <div class="d-grid">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-login fw-bold text-uppercase', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
