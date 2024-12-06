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
                                    return $model->codigo ? $model->codigo->codigo : 'Sem código';
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

                    <h4 class="mt-5">Detalhes da Fatura</h4>
                    <table class="table table-hover">
                        <thead class="">
                        <tr>
                            <th>Produto</th>
                            <th>Preço Unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Chaves</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($linhasFatura as $linha): ?>
                            <tr>
                                <td>
                                    <i class="fas fa-gamepad"></i>
                                    <?= Html::encode($linha['produto']->jogo->nome) ?>
                                </td>
                                <td>
                                    <i class="fas fa-euro-sign"></i>
                                    <?= Yii::$app->formatter->asCurrency($linha['precoUnitario']) ?>
                                </td>
                                <td>
                                    <i class="fas fa-sort-numeric-up"></i>
                                    <?= Html::encode($linha['quantidade']) ?>
                                </td>
                                <td>
                                    <i class="fas fa-money-bill-wave"></i>
                                    <?= Yii::$app->formatter->asCurrency($linha['subtotal']) ?>
                                </td>
                                <td>
                                    <?php if (!empty($linha['chaves'])): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($linha['chaves'] as $chave): ?>
                                                <li><i class="fas fa-key"></i> <?= Html::encode($chave->chave) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <i class="fas fa-times-circle text-danger"></i> Sem Chaves
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <?= Html::a('Atualizar', ['update', 'id' => $model->id], [
                                'class' => 'btn btn-primary  w-100',
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