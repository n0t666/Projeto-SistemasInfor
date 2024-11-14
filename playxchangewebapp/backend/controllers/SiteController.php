<?php

namespace backend\controllers;

use common\models\Fatura;
use common\models\Jogo;
use common\models\LoginForm;
use common\models\Produto;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'funcionario', 'moderador'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $ultimosMeses = strtotime('-6 month'); // 6 meses
        $ultimosUtilizadores = User::find()->where(['>=', 'created_at', $ultimosMeses])->count();
        $totalVendas = Fatura::find()->count();
        $totalJogos = Jogo::find()->count();
        $progressoUtilizadores = ($ultimosUtilizadores / Yii::$app->params['metas']['crescimentoUtilizadores']) * 100;
        $progressoVendas = ($totalVendas / Yii::$app->params['metas']['crescimentoVendas']) * 100;
        $progressoJogos = ($totalJogos / Yii::$app->params['metas']['crescimentoJogos']) * 100;

        $dataProviderProdutos = new ActiveDataProvider([
            'query' => Produto::find()->orderBy(['id' => SORT_DESC])->limit(5),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'ultimosUtilizadores' => $ultimosUtilizadores,
            'totalVendas' => $totalVendas,
            'totalJogos' => $totalJogos,
            'progressoUtilizadores' => $progressoUtilizadores,
            'progressoVendas' => $progressoVendas,
            'progressoJogos' => $progressoJogos,
            'dataProviderProdutos' => $dataProviderProdutos,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('acederBackend')) {
                return $this->goBack();
            } else {
                Yii::$app->user->logout();
                return $this->redirect(['login']);
            }

        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function beforeAction($action){
        if (parent::beforeAction($action)) {
            if ($action->id=='error'){
                if(Yii::$app->user && Yii::$app->user->can('acederBackend')){
                    $this->layout = 'main';
                }else{
                    $this->layout = 'blank';
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
