<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\frontend\assets\CustomAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96"/>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg"/>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <link rel="icon" type="image/x-icon" href="/favicon.ico"/>

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top justify-content-center',
            ],
        ]);
        $menuItems = [
            ['label' => 'Jogos', 'url' => ['/site/about']],
            ['label' => 'Listas', 'url' => ['/site/contact']],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mx-auto'],
            'items' => $menuItems,
        ]);


        if (Yii::$app->user->isGuest) {
            echo Html::tag('div',
                Html::a('Login', ['/site/login'], ['class' => 'btn btn-dark login text-decoration-none']) .
                Html::a('Register', ['/site/signup'], ['class' => 'btn btn-dark register text-decoration-none']),
                ['class' => ['d-flex']]
            );
        } else {
            $username = Yii::$app->user->identity->username;
            $profilePicture = 'https://t3.ftcdn.net/jpg/06/33/54/78/360_F_633547842_AugYzexTpMJ9z1YcpTKUBoqBF0CUCk10.jpg';

            echo Html::beginTag('li', ['class' => 'nav-item dropdown me-2']);


            echo Html::beginTag('a', [
                'class' => 'nav-link dropdown-toggle d-flex align-items-center',
                'href' => '#',
                'id' => 'userDropdown',
                'role' => 'button',
                'data-bs-toggle' => 'dropdown',
                'aria-expanded' => 'false',
            ]);

            echo Html::img($profilePicture, [
                'alt' => 'Profile Picture',
                'class' => 'rounded-circle me-2',
                'style' => 'width: 40px; height: 40px;',
            ]);

            echo Html::encode($username);
            echo Html::endTag('a');

            echo Html::beginTag('ul', ['class' => 'dropdown-menu dropdown-menu-dark', 'aria-labelledby' => 'userDropdown']);
            echo Html::tag('li', Html::a('Perfil', ['/site/profile'], ['class' => 'dropdown-item']));
            echo Html::tag('li', Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton('Logout', ['class' => 'dropdown-item'])
                . Html::endForm());
            echo Html::endTag('ul');

            echo Html::beginTag('li', ['class' => 'nav-item dropdown me-2']);
            echo Html::beginTag('a', [
                'class' => 'btn btn-outline-light d-none d-md-block ms-2',
                'href' => 'carrinho',
            ]);
            echo '<i class="fas fa-shopping-basket"></i>';
            echo '  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark mt-1">
            99+
            <span class="visually-hidden">número itens carrinho</span>
            </span>';
            echo Html::endTag('a');
        }
        echo Html::endTag('li');
        echo Html::button('<i class="fas fa-search"></i>', [
            'class' => 'btn btn-outline-light d-none d-md-block ms-2',
            'title' => 'Pesquisar',
            'id' => 'search_1'
        ]);

        echo Html::beginTag('div', ['class' => 'd-md-none']);
        echo Html::beginTag('form', [
            'action' => '/Projeto-SistemasInfor/playxchangewebapp/frontend/web/site/search',
            'method' => 'get',
            'class' => 'd-flex mt-2',
        ]);

        echo Html::input('text', 'query', '', [
            'id' => 'search_input',
            'class' => 'form-control shadow-none',
            'placeholder' => 'Pesquise aqui...',
            'aria-label' => 'Procurar'
        ]);

        echo Html::endTag('form');
        echo Html::endTag('div');
        NavBar::end();
        ?>
    </header>
    <main role="main" class="flex-shrink-0">
        <div class="container" id="contentHolder">
            <div class="search_input_top" id="search_input_box">
                <div class="container">
                    <?= Html::beginForm(['/site/search'], 'get', ['class' => 'd-flex justify-content-between search-inner']);
                    echo Html::textInput('query', null, [
                        'class' => 'form-control shadow-none',
                        'placeholder' => 'Pesquise aqui...',
                        'id' => 'search_input',
                        'aria-label' => 'Procurar',
                    ]);
                    echo Html::tag('span', '', [
                        'class' => 'fas fa-times',
                        'id' => 'close_search',
                        'title' => 'Fechar'
                    ]);
                    echo Html::endForm(); ?>
                </div>
            </div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="<?= Yii::getAlias('@web') . "/images/logo.png"?>" height="100"  class="img-fluid"></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            All rights reserved | This template is made with <i class="fa fa-heart"
                                                                                aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->






    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
