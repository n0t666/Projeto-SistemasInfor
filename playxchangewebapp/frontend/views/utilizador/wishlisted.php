<?php

use backend\controllers\UtilsController;
use frontend\controllers\UtilizadorController;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Desejados por ' . $user->username;

?>

<div class="container-fluid my-5 game-grid">
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">
                    Desejados (<?= UtilsController::number_format_short(UtilizadorController::getNumFavoritos($user->id))?>)
                </h2>

                <a href="<?= Url::to(['utilizador/profile', 'username' => $user->username]) ?>" class="btn btn-link text-muted text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Voltar ao Perfil
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    $jogo = $model->jogo;
                    $viewUrl = \yii\helpers\Url::to(['jogo/view', 'id' => $model->id]);

                    return '<a href="' . $viewUrl . '" class="card-link">' . $this->render('/jogo/_jogo', [
                            'jogo' => $jogo,
                        ]) . '</a>';
                },
                'itemOptions' => [
                    'class' => 'col-12 col-sm-6 col-md-4 col-lg-3',
                ],
                'layout' => "<div class='row g-4'>{items}</div>\n{pager}",
                'pager' => [
                    'class' => 'yii\bootstrap5\LinkPager',
                ],
            ]) ?>
        </div>
    </div>
</div>

