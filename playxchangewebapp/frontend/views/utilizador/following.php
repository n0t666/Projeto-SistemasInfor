<?php


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = $user->username . ' - Seguidores';

$this->registerCssFile('@web/css/followList.css');


?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="section-header mb-4">
                <h2>A seguir <span>(<?= count($followings) ?>)</span></h2>
            </div>
            <?php foreach ($followings as $following): ?>
                <div class="list-group bg">
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="<?= $following->fotoPerfil  ?>" class="rounded-circle me-3" alt="User Image">
                            <span class="fw-bold"><?= $following->user->username ?></span>
                        </div>

                        <?php if (!Yii::$app->user->isGuest): ?>
                            <?php
                            $isFollowing = isset($following[$following->id]) && $following[$following->id];
                            $actionUrl = $isFollowing ? Url::to(['utilizador/follow']) : Url::to(['utilizador/unfollow']);
                            $buttonText = $isFollowing ? 'Seguir' : 'Deixar de seguir';
                            ?>
                            <?php $form = ActiveForm::begin([
                                'action' => $actionUrl,
                                'id' => 'followForm_' . $following->id
                            ]); ?>

                            <?= Html::hiddenInput('userId', $following->id) ?>

                            <?= Html::submitButton($buttonText, [
                                'class' => 'btn btn-outline-primary px-4 py-2',
                            ]) ?>

                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
