<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlataformaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plataformas';
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
                            <?php if (Yii::$app->user->can('adicionarPlataformas')): ?>
                            <?= Html::a('Criar Plataforma', ['create'], ['class' => 'btn btn-success']) ?>
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
                                'attribute' => 'logotipo',
                                'value' => function($model) {
                                    return Html::img('@utilsUrl/' . $model->logotipo, ['alt' => 'Logotipo', 'style' => 'max-width: 100px;']);
                                },
                                'format' => 'raw',
                            ],

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesPlataformas'),
                                    'update' => Yii::$app->user->can('editarPlataformas'),
                                    'delete' => Yii::$app->user->can('removerPlataformas'),
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
