<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'PLAYxCHANGE',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'pluralize' => true,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'GET desejados' => 'desejados',
                        'GET jogados' => 'jogados',
                        'GET favoritos' => 'favoritos',
                        'POST interagir' => 'interagir',
                    ]
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodo-pagamento',
                    'pluralize' => false
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/metodo-envio',
                    'pluralize' => false,
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/codigo-promocional',
                    'pluralize' => false
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'POST adicionar' => 'add-produto',
                        'DELETE limpar' => 'clear',
                        'DELETE linha-apagar' => 'apagar-linha',
                        'POST decrementar' => 'decrement-produto',
                    ],
                    'pluralize' => true
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/jogo',
                    'extraPatterns' => [

                    ],
                    'pluralize' => true
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [


                    ],
                    'pluralize' => true
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/avaliacao',
                    'extraPatterns' => [


                    ],
                    'pluralize' => false
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/comentario',
                    'extraPatterns' => [


                    ],
                    'pluralize' => true
                ],
            ],
        ],
    ],
    'params' => $params,
];
