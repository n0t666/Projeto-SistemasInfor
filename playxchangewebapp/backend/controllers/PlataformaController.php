<?php

namespace backend\controllers;

use common\models\UploadForm;
use Yii;
use common\models\Plataforma;
use backend\models\PlataformaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PlataformaController implements the CRUD actions for Plataforma model.
 */
class PlataformaController extends Controller
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
     * Lists all Plataforma models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new PlataformaSearch();
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
     * Displays a single Plataforma model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesPlataformas')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Creates a new Plataforma model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('adicionarPlataformas')){
            $model = new Plataforma();
            $modelUpload = new UploadForm();

            if ($model->load(Yii::$app->request->post())) {
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
                if ($modelUpload->imageFile) {
                    if ($modelUpload->upload('@utilsPath')) {
                        $model->logotipo = $modelUpload->imageFile->name;
                        $model->save();
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao fazer o upload do logo.');
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
                'modelUpload' => $modelUpload,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Updates an existing Plataforma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarPlataformas')){
            $model = $this->findModel($id);
            $modelUpload = new UploadForm();

            if ($model->load(Yii::$app->request->post())) {
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
                if ($modelUpload->imageFile) {
                    if ($modelUpload->upload('@utilsPath')) {
                        $model->logotipo = $modelUpload->imageFile->name;
                        $model->save();
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao fazer o upload do logo.');
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'modelUpload' => $modelUpload,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Deletes an existing Plataforma model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('removerPlataformas')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Finds the Plataforma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Plataforma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plataforma::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
