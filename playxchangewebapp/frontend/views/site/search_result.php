<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Resultados da pesquisa: ' . Html::encode($searchQuery);


?>
<div class="section-header mb-4 mt-3">
    <h2>
        <?php if ($category === 'all'): ?>
            Todos resultados
        <?php elseif ($category === 'users'): ?>
            Users
        <?php elseif ($category === 'games'): ?>
            Jogos
        <?php endif; ?>
        <span>(<?= count($dataProvider->getModels()) ?> Itens)</span>
    </h2>
    <p>A mostrar resultado para: <strong>"<?= Html::encode($searchQuery) ?>"</strong></p>
</div>

<div class="row search-result">
    <div class="col-md-3 search-cat">
        <div class="list-group">
            <a href="<?= Url::to(['search', 'category' => 'all', 'query' => $searchQuery]) ?>" class="list-group-item <?= $category === 'all' ? 'active' : '' ?>">
                Todos
            </a>
            <a href="<?= Url::to(['search', 'category' => 'users', 'query' => $searchQuery]) ?>" class="list-group-item <?= $category === 'users' ? 'active' : '' ?>">
                Users
            </a>
            <a href="<?= Url::to(['search', 'category' => 'games', 'query' => $searchQuery]) ?>" class="list-group-item <?= $category === 'games' ? 'active' : '' ?>">
                Jogos
            </a>
        </div>
    </div>

    <div class="col-md-9">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_search_item',
            'layout' => "{items}\n{pager}",
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
            ],
        ]) ?>
    </div>
</div>





