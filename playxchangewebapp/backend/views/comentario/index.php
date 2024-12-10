<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comentarios do ' . $user->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute'=>'utilizador_id',
                                'content'=>function($model){
                                    return $model->utilizador->user->username;
                                }
                            ],
                            [
                                'attribute'=>'jogo_id',
                                'content'=>function($model){
                                    return $model->jogo->nome;
                                }
                            ],
                            'comentario:ntext',
                            'dataComentario',

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' =>true,
                                    'update' => false,
                                    'delete' => true,
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
