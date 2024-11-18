<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Metodo Pagamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?php if (Yii::$app->user->can('adicionarMetodosPagamento')): ?>
                            <?= Html::a('Criar Método de Pagamento', ['create'], ['class' => 'btn btn-success']) ?>
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
                                'attribute' => 'isAtivo',
                                'value' => function($model) {
                                    return $model->isAtivo ? 'Sim' : 'Não';
                                }
                            ],
                            [
                                'attribute' => 'logotipo',
                                'value' => function($model) {
                                    return Html::img('@utilsUrl/' . $model->logotipo, ['alt' => 'Logotipo', 'style' => 'max-width: 100px;']);
                                },
                                'format' => 'raw',
                            ],

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesMetodosEnvio'),
                                    'update' => Yii::$app->user->can('editarMetodosPagamento'),
                                    'delete' => Yii::$app->user->can('removerMetodosPagamento'),
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
