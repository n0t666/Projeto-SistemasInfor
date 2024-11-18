<?php

use yii\grid\GridView;

$this->title = 'Página inicial';

/* @var $ultimosUtilizadores */
/* @var $totalVendas */
/* @var $totalJogos */

/* @var $progressoUtilizadores */
/* @var $progressoVendas */
/* @var $progressoJogos */


?>

<div class="container-fluid">
    <h4 class="text-center mb-4">Estatísticas Gerais</h4>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Novos utilizadores nos últimos 6 meses',
                'number' => $ultimosUtilizadores,
                'icon' => 'fas fa-users',
                'iconTheme' => 'bg-info',
                'progress' => [
                    'width' => $progressoUtilizadores . '%',
                    'description' => 'Crescimento: ' . round($progressoUtilizadores, 2) . '%',
                ]
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total de vendas efetuadas',
                'number' => $totalVendas,
                'icon' => 'fas fa-shopping-cart',
                'iconTheme' => 'bg-success',
                'progress' => [
                    'width' => $progressoVendas . '%',
                    'description' => 'Meta atingida: ' . round($progressoVendas, 2) . '%',
                ]
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total de jogos na plataforma',
                'number' => $totalJogos,
                'icon' => 'fas fa-gamepad',
                'iconTheme' => 'bg-warning',
                'progress' => [
                    'width' => $progressoJogos,
                    'description' => 'Completo: ' . round($progressoJogos, 2) . '%',
                ]
            ]) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title"><i class="fas fa-cogs"></i> Últimos Produtos</h5>
            </div>
            <div class="card-body p-0">
                <?= GridView::widget([
                    'dataProvider' => $dataProviderProdutos,
                    'columns' => [
                        [
                            'label' => 'Nome',
                            'attribute' => 'jogo_id',
                            'value' => function ($model) {
                                return $model->jogo->nome;
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Quantidade',
                            'attribute' => 'quantidade',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Plataforma',
                            'attribute' => 'plataforma_id',
                            'value' => function ($model) {
                                return $model->plataforma->nome;
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Preço',
                            'attribute' => 'preco',
                            'format' => ['currency','EUR'],
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        [
                            'label' => 'Nome',
                            'attribute' => 'jogo_id',
                            'value' => function ($model) {
                                return $model->jogo->nome;
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                    ],
                    'tableOptions' => ['class' => 'table table-sm table-striped table-bordered m-0'],
                ]); ?>
            </div>
        </div>
    </div>


</div>

</div>