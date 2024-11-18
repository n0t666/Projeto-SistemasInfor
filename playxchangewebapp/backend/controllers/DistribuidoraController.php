<?php

namespace backend\controllers;

use backend\models\DistribuidoraSearch;
use backend\models\MetodoEnvioSearch;
use Yii;
use common\models\Distribuidora;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * DistribuidoraController implements the CRUD actions for Distribuidora model.
 */
class DistribuidoraController extends Controller
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
     * Lists all Distribuidora models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')) {
            $searchModel = new DistribuidoraSearch();
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
     * Displays a single Distribuidora model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesDistribuidoras')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Creates a new Distribuidora model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('adicionarDistribuidoras')) {
            try {
                $model = new Distribuidora();
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('create', [
                    'model' => $model,
                ]);
            } catch (Exception $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * Updates an existing Distribuidora model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarDistribuidoras')) {
            $model = $this->findModel($id);

            if (!$model) {
                throw new NotFoundHttpException("Não foi possível encontrar a distribuidora solicitada.");
            }

            try {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Deletes an existing Distribuidora model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('removerDistribuidoras')) {
            try {
                $this->findModel($id)->delete();
                return $this->redirect(['index']);
            } catch (NotFoundHttpException $e) {
                throw new NotFoundHttpException('O item solicitado não existe.');
            } catch (\yii\db\IntegrityException $e) {
                throw new ServerErrorHttpException('Não é possível eliminar este item porque está associado a outro registro.');
            } catch (\Exception $e) {
                throw new ServerErrorHttpException('Ocorreu um erro inesperado: ' . $e->getMessage());
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * Finds the Distribuidora model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Distribuidora the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Distribuidora::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
