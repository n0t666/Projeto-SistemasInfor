<?php

use yii\helpers\Html;

$this->title = 'Editar Perfil';

$this->registerCssFile('@web/css/userEdit.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);
$this->registerJsFile('@web/js/userEdit.js', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);

$user = Yii::$app->user->identity;
$this->registerJsVar('originalCoverImage', $user->profile->fotoCapa);
$this->registerJsVar('originalProfileImage', $user->profile->fotoPerfil);
?>

<div class="container">
    <div class="main-body">
        <div class="row">
            <?=$this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>


