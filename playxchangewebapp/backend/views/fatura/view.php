<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Fatura */

$this->title = 'Detalhes fatura';
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
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
                                'attribute' => 'utilizador_id',
                                'value' => function($model) {
                                    return $model->utilizador->nome;
                                },
                                'label' => 'Nome do Cliente',
                            ],
                            [
                                'value' => function($model) {
                                    return $model->utilizador->user->username;
                                },
                                'label' => 'Username do cliente',
                            ],
                            [
                                'attribute' => 'pagamento_id',
                                'value' => function($model) {
                                    return $model->pagamento->nome;
                                },
                            ],
                            [
                                'attribute' => 'envio_id',
                                'value' => function($model) {
                                    return $model->envio->nome;
                                },
                            ],
                            [
                                'attribute' => 'codigo_id',
                                'value' => function($model) {
                                    return $model->codigo->codigo ? $model->codigo->codigo : '';
                                },
                            ],
                            'dataEncomenda',
                            [
                                'attribute' => 'total',
                                'value' => function($model) {
                                    return $model->total . ' €';
                                },
                            ],
                            [
                                'attribute' => 'estado',
                                'value' => function($model) {
                                    return $model->getEstadoLabel();
                                },
                            ],
                        ],
                    ]) ?>
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
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>