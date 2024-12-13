<?php

namespace backend\controllers;

use backend\models\CodigoPromocionalSearch;
use backend\models\FaturaSearch;
use Yii;
use common\models\Fatura;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller
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
                        'actions' => ['update','delete','view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['update','delete','view'],
                        'allow' => true,
                        'roles' => ['funcionario'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin','funcionario','moderador'],
                    ],
                ],
                'denyCallback' => function () {
                    \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
                    $this->goHome();
                }
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
     * Lists all Fatura models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new FaturaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Displays a single Fatura model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if(Yii::$app->user->can('verDetalhesEncomendas')){
            $fatura = $this->findModel($id);
            $linhasFatura = [];
            $totalSemDesconto = 0;

            foreach ($fatura->linhasfaturas as $linha) { // Visto que no meu caso cada item de uma compra é uma linha de fatura diferente, é necessário agrupar para mostrar
                $produto = $linha->produto_id;
                if (!isset($linhasFatura[$produto])) {
                    $linhasFatura[$produto] = [
                        'produto' => $linha->produto,
                        'precoUnitario' => $linha->precoUnitario,
                        'quantidade' => 0,
                        'subtotal' => 0,
                        'chaves' => []
                    ];
                }

                $linhasFatura[$produto]['quantidade'] += 1;
                $linhasFatura[$produto]['subtotal'] += $linha->precoUnitario;

                if ($linha->chave != null) {
                    $linhasFatura[$produto]['chaves'][] = $linha->chave;
                }

                $totalSemDesconto += $linha->precoUnitario;
                $quantidadeDesconto = 0;
                if ($fatura->codigo) {
                    $desconto = $fatura->codigo->desconto;
                    $quantidadeDesconto = ($totalSemDesconto * $desconto) / 100;
                }
            }



            return $this->render('view', [
                'model' => $fatura,
                'linhasFatura' => $linhasFatura,
                'totalSemDesconto' => $totalSemDesconto,
                'quantidadeDesconto' => $quantidadeDesconto,
            ]);
        }else{
            return $this->goHome();
        }
    }

    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('alterarEstadoEncomenda')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }
    }


    protected function findModel($id)
    {
        if (($model = Fatura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
