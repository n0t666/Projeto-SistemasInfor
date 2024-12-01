<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comentario */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
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
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>