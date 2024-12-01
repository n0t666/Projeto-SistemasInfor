<?php


use yii\bootstrap5\BootstrapAsset;
use yii\widgets\ListView;

$this->title = 'Comentários de ' . $jogo->nome;

$this->registerCssFile('@web/css/review.css', ['depends' => [BootstrapAsset::className()]]);

?>

    <div class="row reviews-section mt-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="reviews-title">Comentários de <?= $jogo->nome ?></h1>
            </div>
            <?= ListView::widget([
                'dataProvider' => $reviews,
                'itemView' => '/comentario/_comentario',
                'layout' => "{items}\n{pager}",
                'itemOptions' => [
                    'class' => 'review-item',
                ],
            ]) ?>
        </div>
    </div>
