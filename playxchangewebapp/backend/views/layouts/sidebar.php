<?php


if (!empty($this->fotoPerfil) && file_exists(Yii::$app->user->identity->profile->fotoPerfil)) {
    $fotoPerfil = Yii::getAlias('@PerfilUrl') . '/' . Yii::$app->user->identity->profile->fotoPerfil;
} else {
    $fotoPerfil = Yii::getAlias('@imagesUrl') . '/' . 'default_user.jpg';
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $fotoPerfil ?>"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Funcionalidades de gestão', 'header' => true],
                    [
                        'label' => 'Gestão de Jogos',
                        'icon' => 'gamepad',
                        'items' => [
                            ['label' => 'Jogos', 'icon' => 'gamepad', 'url' => ['/jogo'], 'active' => Yii::$app->controller->id === 'jogo'],
                            ['label' => 'Franquias', 'icon' => 'tag', 'url' => ['/franquia'], 'active' => Yii::$app->controller->id === 'franquia'],
                            ['label' => 'Distribuidoras', 'icon' => 'store', 'url' => ['/distribuidora'], 'active' => Yii::$app->controller->id === 'distribuidora'],
                            ['label' => 'Tags', 'icon' => 'tags', 'url' => ['/tag'], 'active' => Yii::$app->controller->id === 'tag'],
                            ['label' => 'Editoras', 'icon' => 'book', 'url' => ['/editora'], 'active' => Yii::$app->controller->id === 'editora'],
                            ['label' => 'Géneros', 'icon' => 'folder', 'url' => ['/genero'], 'active' => Yii::$app->controller->id === 'genero'],
                            ['label' => 'Plataformas', 'icon' => 'laptop', 'url' => ['/plataforma'], 'active' => Yii::$app->controller->id === 'plataforma'],
                        ],
                    ],
                    [
                        'label' => 'Gestão de Utilizadores',
                        'icon' => 'users',
                        'items' => [
                            ['label' => 'Utilizadores', 'icon' => 'user', 'url' => ['/user/'], 'active' => Yii::$app->controller->id === 'user'],
                            ['label' => 'Listas', 'icon' => 'list', 'url' => ['/lista'], 'active' => Yii::$app->controller->id === 'lista'],
                            ['label' => 'Sugestões de Funcionalidades', 'icon' => 'lightbulb', 'url' => ['/sugestao-funcionalidade'], 'active' => Yii::$app->controller->id === 'sugestao-funcionalidade'],
                            ['label' => 'Denúncias', 'icon' => 'exclamation-triangle', 'url' => ['/denuncia'], 'active' => Yii::$app->controller->id === 'denuncia'],
                            ['label' => 'FAQs', 'icon' => 'question', 'url' => ['/faq'], 'active' => Yii::$app->controller->id === 'faq'],
                            ],
                    ],
                    [
                        'label' => 'Gestão de Vendas',
                        'icon' => 'shopping-cart',
                        'items' => [
                            ['label' => 'Códigos Promocionais', 'icon' => 'tags', 'url' => ['/codigo-promocional'], 'active' => Yii::$app->controller->id === 'codigo-promocional'],
                            ['label' => 'Encomendas', 'icon' => 'shopping-basket', 'url' => ['/fatura'], 'active' => Yii::$app->controller->id === 'fatura'],
                            ['label' => 'Chaves', 'icon' => 'key', 'url' => ['/chave'], 'active' => Yii::$app->controller->id === 'chave'],
                            ['label' => 'Métodos de Pagamento', 'icon' => 'credit-card', 'url' => ['/metodo-pagamento'], 'active' => Yii::$app->controller->id === 'metodo-pagamento'],
                            ['label' => 'Métodos de Envio', 'icon' => 'truck', 'url' => ['/metodo-envio'], 'active' => Yii::$app->controller->id === 'metodo-envio'],
                            ['label' => 'Ivas', 'icon' => 'percent', 'url' => ['/iva'], 'active' => Yii::$app->controller->id === 'iva'],
                        ],
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>