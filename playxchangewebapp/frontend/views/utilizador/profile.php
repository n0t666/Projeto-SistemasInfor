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
            <img src="<?= $user->profile->fotoCapa ?>" alt="" class="img-fluid">
            <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                    <div class="d-flex align-items-center justify-content-around m-4">
                        <div class="text-center">
                            <i class="fa fa-user fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1"><?= UtilsController::number_format_short(count($user->profile->seguidores)) ?></h4>
                            <p class="mb-0 fs-4">Seguidores</p>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-check fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1"><?= UtilsController::number_format_short(count($user->profile->seguidos)) ?></h4>
                            <p class="mb-0 fs-4">A seguir</p>
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
                                    <img src="<?= $user->profile->fotoPerfil ?>" alt="" class="w-100 h-100 pfp">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="fs-5 mb-0 fw-semibold"><?= Html::encode($user->username) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-last">
                    <ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end my-3 gap-3 me-lg-5">
                        <?php if ($user->id): ?>
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
                        <li class="position-relative">
                            <a href="<?= Url::to(['user/edit', 'id' => $user->id]) ?>" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <ul class="nav nav-pills user-profile-tab justify-content-end mt-2 bg-light-info rounded-2" id="pills-tab"
                role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                            role="tab" aria-controls="pills-profile" aria-selected="true">
                        <i class="fa fa-user me-2 fs-6"></i>
                        <span class="d-none d-md-block">Profile</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-followers-tab">
                        <i class="fa fa-heart me-2 fs-6"></i>
                        <span class="d-none d-md-block">Followers</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-friends-tab">
                        <i class="fa fa-users me-2 fs-6"></i>
                        <span class="d-none d-md-block">Friends</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-gallery-tab">
                        <i class="fa fa-photo me-2 fs-6"></i>
                        <span class="d-none d-md-block">Gallery</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
             tabindex="0">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-none border">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-3">Introduction</h4>
                            <p>Hello, I am Mathew Anderson. I love making websites and graphics. Lorem ipsum dolor sit
                                amet, consectetur adipiscing elit.</p>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-briefcase text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">Sir, P P Institute Of Science</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-envelope text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">xyzjonathan@gmail.com</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-desktop text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">www.xyz.com</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-2">
                                    <i class="fa fa-list text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">Newyork, USA - 100001</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<?php

if ((!yii::$app->user->isGuest)) {
    Modal::begin([
        'title' => 'Fazer denúncia',
        'id' => 'modal-report',
        'options' => ['class' => 'modal fade ']
    ]);
    echo "<div id='modalContent'>";
    echo $this->render('/denuncia/_form', [
        'model' => $denuncia,
        'userId' => $model->id,
        'action' => Url::to(['denuncia/create']),
    ]);
    echo "</div>";
    Modal::end();
}


?>
