<?php

use common\models\Jogo;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $jogo Jogo */

$this->title = 'Screenshots do jogo: ' . $jogo->nome;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?php if (Yii::$app->user->can('adicionarScreenshots')): ?>
                            <?= Html::a('Criar Screenshot', ['create', 'jogoId' => $jogo->id], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,

                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //'id',
                            //'jogo_id',
                            [
                                'attribute' => 'filename',
                                'label' => 'Nome Ficheiro',
                            ],
                            [
                                'format' => 'html',
                                'value' => function ($model) {
                                    return Html::img(Yii::getAlias('@screenshotsJogoUrl') . '/' . $model->filename, [
                                        'alt' => 'Screenshot',
                                        'class' => 'img-thumbnail',
                                        'style' => 'width:100px;'
                                    ]);
                                },
                            ],
                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesScreenshots'),
                                    'update' => Yii::$app->user->can('editarScreenshots'),
                                    'delete' => Yii::$app->user->can('removerScreenshots'),
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) use ($jogo) {
                                    if ($action === 'update') {
                                        return Url::to(['screenshot/update', 'id' => $model->id, 'jogoId' => $jogo->id]);
                                    }
                                    return Url::to([$action, 'id' => $model->id]);
                                }],
                        ],

                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],


                    ]); ?>


                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
