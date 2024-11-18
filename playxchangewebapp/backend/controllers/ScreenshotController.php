<?php

namespace backend\controllers;

use backend\models\FranquiaSearch;
use backend\models\JogoSearch;
use backend\models\ScreenshotSearch;
use common\models\Jogo;
use common\models\MultiUploadForm;
use common\models\UploadForm;
use Yii;
use common\models\Screenshot;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ScreenshotController implements the CRUD actions for Screenshot model.
 */
class ScreenshotController extends Controller
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
     * Lists all Screenshot models.
     * @return mixed
     */
    public function actionIndex($jogoId)
    {
        $jogo = $this->findGame($jogoId);

        if(Yii::$app->user->can('verTudo')){
            $query = Screenshot::find()->where(['jogo_id'=>$jogoId]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'jogo' => $jogo,

            ]);
        }
    }

    /**
     * Displays a single Screenshot model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesScreenshots')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Creates a new Screenshot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($jogoId)
    {
        $jogo = $this->findGame($jogoId);

        if(Yii::$app->user->can('adicionarScreenshots')){
            $model = new Screenshot();
            $modelUpload = new UploadForm();

            if ($model->load(Yii::$app->request->post())) {
                $modelUpload->imageFile = UploadedFile::getInstance($modelUpload, 'imageFile');
                if ($modelUpload->imageFile) {
                    if ($modelUpload->upload('@screenshotsJogoPath')) {
                            $model->jogo_id = $jogoId;
                            $model->filename = $modelUpload->imageFile->name;

                            if (!$model->save()) {
                                $errors = $model->getErrors();
                                Yii::$app->session->setFlash('error', 'Erro ao guardar a screenshot: ' . $modelUpload->imageFile->name);
                                return $this->redirect(['create']);
                            }
                    } else {
                        Yii::$app->session->setFlash('error', 'Falha ao fazer o upload do arquivo.');
                        return $this->redirect(['create', 'jogoId' => $jogoId]);
                    }
                }

                if ($model->save()) {
                    return $this->redirect(['index', 'jogoId' => $jogo->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Falha ao guardar o modelo.');
                }
            }

            return $this->render('create', [
                'model' => $model,
                'modelUpload' => $modelUpload,
                'jogo' => $jogo,
            ]);
        } else {
            return $this->goHome();
        }
    }


    /**
     * Updates an existing Screenshot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $jogoId)
    {
        $jogo = $this->findGame($jogoId);
        $modelUpload = new UploadForm();

        if(Yii::$app->user->can('editarScreenshots')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'jogo' => $jogo,
                'modelUpload' => $modelUpload,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Deletes an existing Screenshot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('removerScreenshots')){
            $model = $this->findModel($id);
            $jogo = $model->jogo_id;
            $filePath = Yii::getAlias('@screenshotsJogoPath') . '/' . $model->filename;

            if(UtilsController::deleteFile($filePath)){
                $model->delete();
                Yii::$app->session->setFlash('success', 'Screenshot removida com sucesso!.');
                return $this->redirect(['index', 'jogoId' => $jogo]);
            }else{
                Yii::$app->session->setFlash('error', 'Erro ao apagar, não foi possivel remover o arquivo.');
                return $this->redirect(['index', 'jogoId' => $jogo]);
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * Finds the Screenshot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Screenshot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Screenshot::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findGame($id)
    {
        if (($game = Jogo::findOne($id)) !== null) {
            return $game;
        }

        throw new NotFoundHttpException('The requested game does not exist.');
    }
}
