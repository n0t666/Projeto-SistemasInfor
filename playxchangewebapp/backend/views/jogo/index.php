<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jogos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?php if (Yii::$app->user->can('adicionarJogos')): ?>
                                <?= Html::a('Criar Jogo', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //'id',
                            'nome',
                            [
                                'attribute'=>'dataLancamento',
                                'content'=>function($model){
                                    return Yii::$app->formatter->asDate($model->dataLancamento,'php:d-m-Y');
                                }
                            ],
                            //'descricao:ntext',
                            //'trailerLink',
                            [
                                'attribute'=>'franquia_id',
                                'content'=>function($model){
                                    return $model->franquia ? $model->franquia->nome : 'N/A';
                                }
                            ],
                            //'imagemCapa',
                            [
                                'attribute'=>'distribuidora_id',
                                'content'=>function($model){
                                    return $model->distribuidora ? $model->distribuidora->nome : 'N/A';
                                }
                            ],
                            [
                                'attribute'=>'editora_id',
                                'content'=>function($model){
                                    return $model->editora ? $model->editora->nome : 'N/A';
                                }
                            ],
                            [
                                'format' => 'raw',
                                'content' => function ($model) {
                                    if (Yii::$app->user->can('verTudo')) {
                                        return Html::a('<i class="fas fa-image"></i>', ['screenshot/index', 'jogoId' => $model->id], [
                                            'class' => 'btn btn-info btn-sm',
                                            'encode' => false,
                                        ]);
                                    }
                                    return '';
                                },
                            ],
                            [
                                'format' => 'raw',
                                'content' => function ($model) {
                                    if (Yii::$app->user->can('verTudo')) {
                                        return Html::a('<i class="fas fa-box"></i>', ['produto/index', 'jogoId' => $model->id], [
                                            'class' => 'btn btn-success btn-sm',
                                            'encode' => false,
                                        ]);
                                    }
                                    return '';
                                },
                            ],
                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesJogos'),
                                    'update' => Yii::$app->user->can('editarJogos'),
                                    'delete' => Yii::$app->user->can('removerJogos'),
                                ],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap5\LinkPager',
                        ],
                        'tableOptions' => [
                            'class'=>'table table-striped'
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
