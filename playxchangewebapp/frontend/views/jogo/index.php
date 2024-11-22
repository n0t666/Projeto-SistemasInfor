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
<div class="container my-5">
        <?= ListView::widget([ // Usar a lisview devido ao facto de facilitar a paginação e posteriormente filtros
            'dataProvider' => $dataProvider,
            'itemView' => function ($model, $key, $index, $widget) {
                $viewUrl = \yii\helpers\Url::to(['jogo/view', 'id' => $model->id]);

                return '<a href="' . $viewUrl . '" class="card-link">' . $this->render('_jogo', [
                        'jogo' => $model,
                    ]) . '</a>';
            },
            'itemOptions' => [
                'class' => 'col-12 col-sm-6 col-md-4 col-lg-3',
            ],
            'layout' => "<div class='row g-4'>{items}</div>\n{pager}", // Especificar o layout de forma a fica tudo na mesma grid
            'pager' => [
                'class' => 'yii\bootstrap5\LinkPager',
            ],
        ]) ?>
</div>

