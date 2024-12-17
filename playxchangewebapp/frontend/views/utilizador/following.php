<?php


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = $user->username . ' - Seguidores';

$this->registerCssFile('@web/css/followList.css');


?>

<div class="container mt-2 fol-container">
    <div class="row">
        <div class="col-md-12">
            <div class="section-header mb-4">
                <h2>A seguir <span>(<?= count($followings) ?>)</span></h2>
            </div>
            <?php foreach ($followings as $following): ?>
                <div class="list-group bg">
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="<?= Url::to(['utilizador/profile', 'username' => $following->user->username]) ?>" class="d-flex align-items-center text-decoration-none fw">
                                <img src="<?= $following->getFotoPerfil()  ?>" class="rounded-circle me-3" alt="User Image" style="width: 40px; height: 40px;">
                                <span class="fw-bold"><?= Html::encode($following->user->username) ?></span>
                            </a>
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
                                'class' => 'btn btn-outline-primary px-3 py-1 rounded-pill',
                            ]) ?>

                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
