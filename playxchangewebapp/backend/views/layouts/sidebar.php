<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="site/index" class="brand-link">
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
                    [
                        'label' => 'Starter Pages',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    ['label' => 'Funcionalidades de gestão', 'header' => true],
                    [
                        'label' => 'Gestão de Utilizadores',
                        'icon' => 'users',
                        'items' => [
                            ['label' => 'Utilizadores', 'icon' => 'user', 'url' => ['/user/index']],
                            ['label' => 'Listas', 'icon' => 'list', 'url' => ['/user/lists']],
                            ['label' => 'Sugestões de Funcionalidades', 'icon' => 'lightbulb', 'url' => ['/suggestions/index']],
                        ],
                    ],
                    [
                        'label' => 'Gestão de Jogos',
                        'icon' => 'gamepad',
                        'items' => [
                            ['label' => 'Jogos', 'icon' => 'gamepad', 'url' => ['/jogo']],
                            ['label' => 'Franquias', 'icon' => 'tag', 'url' => ['/franquia']],
                            ['label' => 'Screenshots', 'icon' => 'images', 'url' => ['/screenshot']],
                            ['label' => 'Distribuidoras', 'icon' => 'store', 'url' => ['/distributora']],
                            ['label' => 'Tags', 'icon' => 'tags', 'url' => ['/tag']],
                            ['label' => 'Editoras', 'icon' => 'book', 'url' => ['/publicadora']],
                            ['label' => 'Géneros', 'icon' => 'folder', 'url' => ['/genero']],
                        ],
                    ],
                    [
                        'label' => 'Gestão de Vendas',
                        'icon' => 'shopping-cart',
                        'items' => [
                            ['label' => 'Vendas', 'icon' => 'dollar-sign', 'url' => ['/sales/index']],
                            ['label' => 'Códigos Promocionais', 'icon' => 'tags', 'url' => ['/promo-code/index']],
                            ['label' => 'Encomendas', 'icon' => 'shopping-basket', 'url' => ['/fatura']],
                            ['label' => 'Chaves', 'icon' => 'key', 'url' => ['/chaves']],
                            ['label' => 'Produtos', 'icon' => 'cubes', 'url' => ['/produtos']],
                        ],
                    ],
                    ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>