<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distribuidoras';
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
                            <?php if (Yii::$app->user->can('adicionarDistribuidoras')): ?>
                            <?= Html::a('Criar Distribuidora', ['create'], ['class' => 'btn btn-success']) ?>
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
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesDistribuidoras'),
                                    'update' => Yii::$app->user->can('editarDistribuidoras'),
                                    'delete' => Yii::$app->user->can('removerDistribuidoras'),
                                ],
                            ],
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
