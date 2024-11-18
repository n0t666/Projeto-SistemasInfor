<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var Jogo[] $jogos */
/* @var Plataforma[] $plataformas */

$this->title = 'Produtos';
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
                            <?php if (Yii::$app->user->can('adicionarProdutos')): ?>
                            <?= Html::a('Criar Produto', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </div>
                    </div>



                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute'=>'jogo_id',
                                'content'=>function($model){
                                    return $model->jogo->nome;
                                }
                            ],
                            [
                                'attribute'=>'plataforma_id',
                                'content'=>function($model){
                                    return $model->plataforma->nome;
                                }
                            ],
                            [
                                'attribute'=>'preco',
                                'content'=>function($model){
                                    return $model->preco . '€';
                                }
                            ],
                            [
                                'attribute'=>'quantidade',
                                'content'=>function($model){
                                    return $model->quantidade . ' unidades';
                                }
                            ],
                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesProdutos'),
                                    'update' => Yii::$app->user->can('editarProdutos'),
                                    'delete' => Yii::$app->user->can('removerProdutos'),
                                ],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
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
