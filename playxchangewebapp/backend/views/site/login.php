<?php

use yii\bootstrap5\Toast;
use yii\helpers\Html;
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Iniciar Sessão</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model,'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                    'labelOptions' => [
                        'class' => ''
                    ],
                    'uncheck' => null
                ])->label('Lembrar-me') ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton('entrar', ['class' => 'btn btn-primary btn-block text-uppercase']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>
    </div>
    <!-- /.login-card-body -->
</div>

<?php
echo Html::beginTag('div', ['id' => 'messages-holder', 'class' => 'position-fixed top-0 end-0 p-3', 'style' => 'z-index: 1050;']);
if (Yii::$app->session->hasFlash('success')) {
    echo Toast::widget([
        'title' => 'Sucesso',
        'body' => Yii::$app->session->getFlash('success'),
        'options' => [
            'class' => 'toast fade show bg-success text-white',
            'data-autohide' => 'true',
            'data-delay' => 100,
            'id' => 'success-toast',
        ]
    ]);
}

if (Yii::$app->session->hasFlash('error')) {
    echo Toast::widget([
        'title' => 'Erro',
        'body' => Yii::$app->session->getFlash('error'),
        'options' => [
            'class' => 'toast fade show bg-danger text-white',
            'data-autohide' => 'true',
            'data-delay' => 100,
            'id' => 'error-toast',
        ]
    ]);
}
echo Html::endTag('div');
?>