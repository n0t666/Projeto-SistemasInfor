<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CodigoPromocional */

$this->title = 'Código Promocional: ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Codigo Promocionals', 'url' => ['index']];
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
                            'codigo',
                            [
                                'attribute'=>'desconto',
                                'value'=>function($model){
                                    return $model->desconto . " %" ;
                                }
                            ],
                            [
                                'attribute'=>'isAtivo',
                                'value'=>function($model){
                                    return $model->isAtivo ? 'Sim' : 'Não';
                                }
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <?= Html::a('Atualizar', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-primary btn-sm btn-block',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm btn-block',
                        'data' => [
                            'confirm' => 'Tem a certeza que deseja apagar?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>