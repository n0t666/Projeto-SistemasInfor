<?php

namespace backend\controllers;

use backend\models\JogoSearch;
use backend\models\MetodoEnvioSearch;
use Yii;
use common\models\MetodoEnvio;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MetodoEnvioController implements the CRUD actions for MetodoEnvio model.
 */
class MetodoEnvioController extends Controller
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
                        'actions' => ['create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['admin'],
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
     * Lists all MetodoEnvio models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new MetodoEnvioSearch();
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
     * Displays a single MetodoEnvio model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesMetodosEnvio')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
            return $this->goHome();
        }

    }

    /**
     * Creates a new MetodoEnvio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('adicionarMetodosEnvio')) {
            $model = new MetodoEnvio();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
            return $this->goHome();
        }

    }

    /**
     * Updates an existing MetodoEnvio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarMetodosEnvio')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
            return $this->goHome();
        }

    }

    /**
     * Deletes an existing MetodoEnvio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('removerMetodosEnvio')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
            return $this->goHome();
        }

    }

    /**
     * Finds the MetodoEnvio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MetodoEnvio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MetodoEnvio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
