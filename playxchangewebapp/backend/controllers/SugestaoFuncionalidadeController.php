<?php

namespace backend\controllers;

use backend\models\JogoSearch;
use backend\models\SugestaoFuncionalidadeSearch;
use Yii;
use common\models\SugestaoFuncionalidade;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SugestaoFuncionalidadeController implements the CRUD actions for SugestaoFuncionalidade model.
 */
class SugestaoFuncionalidadeController extends Controller
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
     * Lists all SugestaoFuncionalidade models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new SugestaoFuncionalidadeSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    }

    /**
     * Displays a single SugestaoFuncionalidade model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesSugestao')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            $this->goHome();
        }

    }

    /**
     * Creates a new SugestaoFuncionalidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('criarSugestao')){
            $model = new SugestaoFuncionalidade();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
            $this->goHome();
        }

    }

    /**
     * Updates an existing SugestaoFuncionalidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarSugestao')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            $this->goHome();
        }

    }

    /**
     * Deletes an existing SugestaoFuncionalidade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('apagarSugestao')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            $this->goHome();
        }

    }

    /**
     * Finds the SugestaoFuncionalidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SugestaoFuncionalidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SugestaoFuncionalidade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
