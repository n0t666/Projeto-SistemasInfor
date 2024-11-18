<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Utilizadores';
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
                            <?php if (Yii::$app->user->can('adicionarUtilizadores')): ?>
                            <?= Html::a('Criar Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute'=>'username',
                                'content'=>function($model){
                                    return $model->user->username;
                                }
                            ],
                            //'auth_key',
                            //'password_hash',
                            //'password_reset_token',
                            [
                                'attribute'=>'email',
                                'content'=>function($model){
                                    return Yii::$app->formatter->asEmail($model->user->email);
                                }
                            ],
                            [
                                'attribute'=>'status',
                                'content'=>function($model){
                                    return $model->user->getStatusLabel();
                                }
                            ],
                            //'created_at',
                            //'updated_at',
                            //'verification_token',

                            [
                                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    'view' => Yii::$app->user->can('verDetalhesUtilizadores'),
                                    'update' => Yii::$app->user->can('editarDetalhesUtilizadores'),
                                    'delete' => Yii::$app->user->can('banirUtilizador'),
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
