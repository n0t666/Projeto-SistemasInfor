<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Toast;
use yii\helpers\Url;

AppAsset::register($this);
\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\frontend\assets\CustomAsset::register($this);

$this->registerJsFile(
    '@web/js/globalSearch.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$img = Yii::getAlias('@web') . "/images/logo.png";



?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
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
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top justify-content-center py-2',
            ],
        ]);

        echo Html::a(
            Html::img($img
                , ['alt' => 'Your Logo', 'class' => 'navbar-brand', 'style' => 'width: 50px;']),
            Yii::$app->homeUrl,
            ['class' => 'navbar-brand']
        );

        $menuItems = [
            [
                'label' => 'Jogos',
                'url' => ['/jogo'],
                'linkOptions' => ['class' => Yii::$app->controller->id == 'jogo' ? 'active' : ''],
            ],
            [
                'label' => 'FAQs',
                'url' => ['/site/faq'],
                'linkOptions' => ['class' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'faq' ? 'active' : ''],
            ],
            [
                'label' => 'Acerca',
                'url' => ['/site/about'],
                'linkOptions' => ['class' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'about' ? 'active' : ''],
            ],
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



            echo Html::beginTag('li', ['class' => 'nav-item dropdown me-2']);


            echo Html::beginTag('a', [
                'class' => 'nav-link dropdown-toggle d-flex align-items-center',
                'href' => '#',
                'id' => 'userDropdown',
                'role' => 'button',
                'data-bs-toggle' => 'dropdown',
                'aria-expanded' => 'false',
            ]);

            if(!Yii::$app->user->identity->profile) {
                $img = Yii::getAlias('@imagesUrl') . '/' . 'default_user.jpg';
                echo Html::img($img, [
                    'alt' => 'Profile Picture',
                    'class' => 'rounded-circle me-2',
                    'style' => 'width: 40px; height: 40px; object-fit: cover;',
                ]);
            }else{
                echo Html::img(Yii::$app->user->identity->profile->getFotoPerfil(), [
                    'alt' => 'Profile Picture',
                    'class' => 'rounded-circle me-2',
                    'style' => 'width: 40px; height: 40px; object-fit: cover;',
                ]);
            }


            echo Html::encode($username);
            echo Html::endTag('a');

            echo Html::beginTag('ul', ['class' => 'dropdown-menu dropdown-menu-dark', 'aria-labelledby' => 'userDropdown']);
            if (Yii::$app->user->can('visualizarPerfil')){
                echo Html::tag('li', Html::a('Perfil', ['/utilizador/profile','username' => $username], ['class' => 'dropdown-item']));
            }

            if(Yii::$app->user->can('visualizarEncomendas')){
                echo Html::tag('li', Html::a('Encomendas', ['fatura/index'], ['class' => 'dropdown-item']));
            }
            echo Html::tag('li', Html::beginForm(['/site/logout'],'post', ['id' => 'logout-form'])
                . Html::submitButton('Logout', ['class' => 'dropdown-item'])
                . Html::endForm());
            echo Html::endTag('ul');
            if (Yii::$app->user->can('visualizarItensCarrinho')){
                echo Html::beginTag('li', ['class' => 'nav-item dropdown me-2']);
                echo Html::beginTag('a', [
                    'class' => 'btn btn-outline-light d-none d-md-block ms-2',
                    'id' => 'carrinho-btn',
                    'href' =>  Url::toRoute('carrinho/')
                ]);
                $carrinho = Yii::$app->user->identity->profile->carrinho;
                if($carrinho){
                    $total = Yii::$app->user->identity->profile->carrinho->count;
                    if($total == null){
                        $total = 0;
                    }
                }else{
                    $total = 0;
                }
                echo '<i class="fas fa-shopping-basket"></i>';
                echo '  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark mt-1" id="quant-nav"> ' . $total .
                    '<span class="visually-hidden">número itens carrinho</span>
            </span>';
                echo Html::endTag('a');
            }
        }
        echo Html::endTag('li');
            echo Html::button('<i class="fas fa-search"></i>', [
                'class' => 'btn btn-outline-light d-none d-md-block ms-2',
                'title' => 'Pesquisar',
                'id' => 'search_1'
            ]);

            echo Html::beginTag('div', ['class' => 'd-md-none']);
            echo Html::beginTag('form', [
                'action' => '/search',
                'method' => 'get',
                'class' => 'd-flex mt-2',
        ]);

        echo Html::dropDownList('category', null, [
            'all' => 'Todos',
            'jogos' => 'Jogos',
            'utilizadores' => 'Utilizadores'
        ], ['class' => 'form-select me-2', 'aria-label' => 'Select Category']);



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
                    <?= Html::beginForm(['/site/search'], 'get', ['class' => 'd-flex justify-content-between search-inner mt-3']); ?>
                    <?= Html::dropDownList('category', null, [
                        'all' => 'Todos',
                        'games' => 'Jogos',
                        'users' => 'Utilizadores'
                    ], [
                        'class' => 'form-select me-2',
                        'aria-label' => 'Select Category',
                        'style' => 'max-width: 150px;'
                    ]); ?>

                    <?= Html::textInput('query', null, [
                        'class' => 'form-control shadow-none',
                        'placeholder' => 'Pesquise aqui...',
                        'id' => 'search_input',
                        'aria-label' => 'Procurar',
                    ]); ?>

                    <button class="btn btn-outline-primary" type="submit" title="Pesquisar">
                        <i class="fas fa-search"></i>
                    </button>

                    <?= Html::endForm(); ?>
                </div>
            </div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?php
            echo Html::beginTag('div', ['id' => 'messages-holder', 'class' => 'position-fixed top-0 end-0 p-3', 'style' => 'z-index: 1050;']);
            if (Yii::$app->session->hasFlash('success')) {
                echo Toast::widget([
                    'title' => 'Sucesso',
                    'body' => Yii::$app->session->getFlash('success'),
                    'options' => [
                        'class' => 'toast fade show bg-success text-white',
                        'data-autohide' => 'true',
                        'data-delay' => 100,
                        'id' => 'success-toast',
                    ]
                ]);
            }

            if (Yii::$app->session->hasFlash('error')) {
                echo Toast::widget([
                    'title' => 'Erro',
                    'body' => Yii::$app->session->getFlash('error'),
                    'options' => [
                        'class' => 'toast fade show bg-danger text-white',
                        'data-autohide' => 'true',
                        'data-delay' => 100,
                        'id' => 'error-toast',
                    ]
                ]);
            }
            echo Html::endTag('div');
            ?>

            <?= $content ?>
        </div>
    </main>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
