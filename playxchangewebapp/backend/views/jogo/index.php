<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jogos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Criar Jogo', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>



                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'id',
                            'nome',
                            [
                                'attribute'=>'dataLancamento',
                                'content'=>function($model){
                                    return Yii::$app->formatter->asDate($model->dataLancamento,'php:m-d-Y');
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
                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
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
