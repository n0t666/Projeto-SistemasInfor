<?php

namespace backend\controllers;

use backend\models\ChaveSearch;
use backend\models\JogoSearch;
use common\models\Franquia;
use common\models\Jogo;
use common\models\Produto;
use Yii;
use common\models\Chave;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * ChaveController implements the CRUD actions for Chave model.
 */
class ChaveController extends Controller
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
     * Lists all Chave models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new ChaveSearch();
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
     * Displays a single Chave model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesChaves')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Creates a new Chave model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('criarChaves')){
            try {
            $model = new Chave();
            $produtos = Produto::find()->all();

            if ($model->load(Yii::$app->request->post())) {
                $model->plataforma_id = $model->produto->plataforma_id;
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    return $this->redirect(['create']);
                }

            }

            return $this->render('create', [
                'model' => $model,
                'produtos' => $produtos,
            ]);} catch (\Exception  $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }
        }else{
            return $this->goHome();
        }

    }

    /**
     * Updates an existing Chave model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarChaves')) {
            $model = $this->findModel($id);
            $produtos = Produto::find()->all();


            if (!$model) {
                throw new NotFoundHttpException("Não foi possível encontrar a chave solicitada.");
            }

            if($model->isUsada){
                \Yii::$app->session->setFlash('error', 'Não pode modificar chaves que já foram usadas!');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            try{
                if ($model->load(Yii::$app->request->post())) {
                    $model->plataforma_id = $model->produto->plataforma_id;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }

                return $this->render('update', [
                    'model' => $model,
                    'produtos' => $produtos,
                ]);
            }   catch (\Exception  $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }
        }
        else {
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Chave model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('apagarChaves')) {
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
     * Finds the Chave model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Chave the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chave::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
