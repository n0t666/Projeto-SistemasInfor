<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jogos';

?>
<div class="container-fluid my-5 game-grid">
    <div class="row">
        <div class="col-12 col-lg-3 mb-4">
            <div class="sidebar p-4 shadow-sm rounded">
                <h5 class="mb-3"><i class="fas fa-filter"></i> Filtrar por:</h5>
                <?= $this->render('_search', ['searchModel' => $searchModel]) ?>
            </div>
        </div>
        <div class="col-lg-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    $viewUrl = \yii\helpers\Url::to(['jogo/view', 'id' => $model->id]);

                    return '<a href="' . $viewUrl . '" class="card-link">' . $this->render('_jogo', [
                            'jogo' => $model,
                        ]) . '</a>';
                },
                'itemOptions' => [
                    'class' => 'col-12 col-sm-6 col-md-4 col-lg-4',
                ],
                'layout' => "<div class='row g-4'>{items}</div>\n{pager}",
                'pager' => [
                    'class' => 'yii\bootstrap5\LinkPager',
                ],
            ]) ?>
        </div>
    </div>
</div>

