<?php

use backend\controllers\UtilsController;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Url;

/* @var $user common\models\User */

$this->registerCssFile('@web/css/user.css', ['depends' => [BootstrapAsset::className()]]);


$this->title = $user->username;


?>


<div class="container">
    <div class="card overflow-hidden">
        <div class="card-body p-0">
            <img src="<?= $user->profile->getFotoCapa() ?>" alt="" class="img-fluid w-100" style="object-fit: cover; height: 300px;">
            <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                    <div class="d-flex align-items-center justify-content-around m-4">
                        <?  ?>
                        <div class="text-center">
                            <i class="fa fa-user fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1"><?= UtilsController::number_format_short(count($user->profile->seguidores)) ?></h4>
                            <a href="<?= Url::to(['utilizador/followers', 'username' => $user->username]) ?>" class="mb-0 fs-4">Seguidores</a>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-check fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1"><?= UtilsController::number_format_short(count($user->profile->seguidos)) ?></h4>
                            <a href="<?= Url::to(['utilizador/following', 'username' => $user->username]) ?>" class="mb-0 fs-4">A seguir</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                    <div class="mt-n5">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                 style="width: 110px; height: 110px;">
                                <div class="border border-0 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                     style="width: 100px; height: 100px;">
                                    <img src="<?= $user->profile->getFotoPerfil() ?>" alt="" class="w-100 h-100 pfp">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <h5 class="fs-5 mb-0 fw-semibold"><?= Html::encode($user->username) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-last">
                    <ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 gap-3 me-lg-5">
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id != $user->id): ?>
                            <li>
                                <?php $form = ActiveForm::begin([
                                    'action' => $isFollowing ? Url::to(['utilizador/unfollow']) : Url::to(['utilizador/follow']),
                                    'method' => 'POST',
                                    'id' => 'followForm_' . $user->id
                                ]); ?>

                                <?= Html::hiddenInput('userId', $user->id) ?>

                                <?= Html::submitButton($isFollowing ? 'Deixar de seguir' : 'Seguir', [
                                    'class' => 'btn btn-primary px-4 py-2 fs-5',
                                    'style' => 'border-radius: 30px;'
                                ]) ?>

                                <?php ActiveForm::end(); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($user->id && !Yii::$app->user->isGuest && Yii::$app->user->identity->id != $user->id ): ?>
                            <li class="d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary p-2 fs-4 rounded-circle d-flex align-items-center justify-content-center"
                                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false" style="width: 40px; height: 40px;">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <?php $form = ActiveForm::begin([
                                                'action' => $isBlocked ? Url::to(['utilizador/unblock']) : Url::to(['utilizador/block']),
                                                'method' => 'post',
                                                'id' => 'blockForm_' . $user->id
                                            ]); ?>

                                            <?= Html::hiddenInput('userId', $user->id) ?>

                                            <?= Html::submitButton($isBlocked ? 'Desbloquear' : 'Bloquear', ['class' => 'dropdown-item']) ?>

                                            <?php ActiveForm::end(); ?>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                               data-bs-target="#modal-report">Denunciar</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $user->id): ?>
                        <li class="position-relative">
                            <a href="<?= Url::to(['utilizador/update']) ?>" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
             tabindex="0">
            <?php if($user->profile->biografia ):?>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-3">Biografia</h4>
                            <p><?= $user->profile->biografia ?>  </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>

</div>
</div>

<?php

if ((!yii::$app->user->isGuest && $denuncia->isNewRecord)) {
    Modal::begin([
        'title' => 'Fazer denúncia',
        'id' => 'modal-report',
        'options' => ['class' => 'modal fade ']
    ]);
    echo "<div id='modalContent'>";
    echo $this->render('/denuncia/_form', [
        'model' => $denuncia,
        'action' => Url::to(['denuncia/create']),
    ]);
    echo "</div>";
    Modal::end();
}


?>
