<?php

use common\models\Denuncia;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DenunciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Denuncias';
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
                            <?php if (Yii::$app->user->can('denunciarUtilizador')): ?>
                            <?= Html::a('Criar Denúncia', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute'=>'denunciante_id',
                                'content'=>function($model){
                                    return $model->denunciante->user->username;
                                }
                            ],
                            [
                                'attribute'=>'denunciado_id',
                                'content'=>function($model){
                                    return $model->denunciado->user->username;
                                }
                            ],
                            //'motivo:ntext',
                            [
                                'attribute'=>'dataDenuncia',
                                'content'=>function($model){
                                    return Yii::$app->formatter->asDatetime($model->dataDenuncia,'php:d-m-Y');
                                }
                            ],
                            [
                                'attribute'=>'estado',
                                'content'=>function($model){
                                    return $model->getStatusLabel();
                                }
                            ],
                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesDenuncias'),
                                    'update' => function ($model) {
                                        return Yii::$app->user->can('editarDenuncias') && $model->estado == Denuncia::STATUS_PROCESSING;
                                    },
                                    'delete' => Yii::$app->user->can('apagarDenuncias'),
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
