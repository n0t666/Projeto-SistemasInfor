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

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'CPU Traffic',
                'number' => '10 <small>%</small>',
                'icon' => 'fas fa-cog',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Messages',
                'number' => '1,410',
                'icon' => 'far fa-envelope',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '410',
                'theme' => 'success',
                'icon' => 'far fa-flag',
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Uploads',
                'number' => '13,648',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-copy',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '41,410',
                'icon' => 'far fa-bookmark',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php $infoBox = \hail812\adminlte\widgets\InfoBox::begin([
                'text' => 'Likes',
                'number' => '41,410',
                'theme' => 'success',
                'icon' => 'far fa-thumbs-up',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) ?>
            <?= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $infoBox->id . '-ribbon',
                'text' => 'Ribbon',
            ]) ?>
            <?php \hail812\adminlte\widgets\InfoBox::end() ?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Events',
                'number' => '41,410',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-calendar-alt',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ],
                'loadingStyle' => true
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 ">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'success'
            ]) ?>
            <?= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $smallBox->id . '-ribbon',
                'text' => 'Ribbon',
                'theme' => 'warning',
                'size' => 'lg',
                'textSize' => 'lg'
            ]) ?>
            <?php \hail812\adminlte\widgets\SmallBox::end() ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '44',
                'text' => 'User Registrations',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                'loadingStyle' => true
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= GridView::widget([
                'dataProvider' => $dataProviderProdutos,
                'columns' => [
                    ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                    //'id',
                    'jogo_id',
                    //'plataforma_id',
                    'preço',
                    'quantidade',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]); ?>
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
                                'label' => 'Preço',
                                'attribute' => 'preco',
                                'format' => ['currency'],
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-right'],
                            ],
                            [
                                'label' => 'Quantidade',
                                'attribute' => 'quantidade',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Preço',
                                'attribute' => 'preco',
                                'format' => ['currency'],
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-right'],
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-sm table-striped table-bordered m-0'],
                    ]); ?>
                </div>
            </div>
        </div>


    </div>

</div>