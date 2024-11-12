<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=Yii::$app->user->identity->username;?></a>
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
                            ['label' => 'Jogos', 'icon' => 'gamepad', 'url' => ['/jogo']],
                            ['label' => 'Franquias', 'icon' => 'tag', 'url' => ['/franquia']],
                            ['label' => 'Screenshots', 'icon' => 'images', 'url' => ['/screenshot']],
                            ['label' => 'Distribuidoras', 'icon' => 'store', 'url' => ['/distribuidora']],
                            ['label' => 'Tags', 'icon' => 'tags', 'url' => ['/tag']],
                            ['label' => 'Editoras', 'icon' => 'book', 'url' => ['/editora']],
                            ['label' => 'Géneros', 'icon' => 'folder', 'url' => ['/genero']],
                        ],
                    ],
                    [
                        'label' => 'Gestão de Utilizadores',
                        'icon' => 'users',
                        'items' => [
                            ['label' => 'Utilizadores', 'icon' => 'user', 'url' => ['/user/']],
                            ['label' => 'Listas', 'icon' => 'list', 'url' => ['/lista']],
                            ['label' => 'Sugestões de Funcionalidades', 'icon' => 'lightbulb', 'url' => ['/suggestions/index']],
                        ],
                    ],
                    [
                        'label' => 'Gestão de Vendas',
                        'icon' => 'shopping-cart',
                        'items' => [
                            ['label' => 'Códigos Promocionais', 'icon' => 'tags', 'url' => ['/codigo-promocional']],
                            ['label' => 'Encomendas', 'icon' => 'shopping-basket', 'url' => ['/fatura']],
                            ['label' => 'Chaves', 'icon' => 'key', 'url' => ['/chave']],
                            ['label' => 'Produtos', 'icon' => 'cubes', 'url' => ['/produto']],
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