<?php

namespace backend\controllers;

use backend\models\JogoSearch;
use common\models\Distribuidora;
use common\models\Editora;
use common\models\Franquia;
use common\models\Genero;
use common\models\Jogo;
use common\models\MultiUploadForm;
use common\models\Screenshot;
use common\models\Tag;
use common\models\UploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * JogoController implements the CRUD actions for Jogo model.
 */
class JogoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin', 'funcionario', 'moderador'],
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
     * Lists all Jogo models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('verTudo')) {
            $searchModel = new JogoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->goHome();
        }

    }

    /**
     * Displays a single Jogo model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('verDetalhesJogos')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->goHome();
        }

    }

    /**
     * Creates a new Jogo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('adicionarJogos')) {
            $model = new Jogo();
            $modelUploadCapa = new UploadForm();
            $modelUploadScreenshots = new MultiUploadForm();
            $franquias = Franquia::find()->all();
            $distribuidoras = Distribuidora::find()->all();
            $editoras = Editora::find()->all();
            $tags = Tag::find()->all();
            $generos = Genero::find()->all();

            if ($this->request->isPost) {
                try {
                    if ($model->load($this->request->post()) && $model->save()) {
                        $modelUploadCapa->imageFile = UploadedFile::getInstance($modelUploadCapa, 'imageFile');
                        $modelUploadScreenshots->imageFiles = UploadedFile::getInstances($modelUploadScreenshots, 'imageFiles');
                        if ($modelUploadCapa->imageFile) {
                            if ($modelUploadCapa->upload('@capasJogoPath')) {
                                $model->imagemCapa = $modelUploadCapa->imageFile->name;
                                $model->save(false);
                            }
                        }
                        if ($modelUploadScreenshots->imageFiles) {
                            if ($modelUploadScreenshots->upload('@screenshotsJogoPath')) {
                                foreach ($modelUploadScreenshots->imageFiles as $file) {
                                    $screenshot = new Screenshot();
                                    $screenshot->jogo_id = $model->id;
                                    $screenshot->filename=$file->name;;

                                    if ($screenshot->validate() && $screenshot->save()) {
                                    } else {
                                        $errors = $screenshot->getErrors();
                                        Yii::$app->session->setFlash('error', 'Erro ao guardar a screenshot: ' . implode(', ', $errors));
                                        return $this->redirect(['create']);
                                    }

                                }
                            }
                        }
                    }
                    $tagsSelected = Yii::$app->request->post('Jogo')['tags'];
                    if ($tagsSelected) {
                        foreach ($tagsSelected as $tag) {
                            $tag = Tag::findOne($tag);
                            if ($tag) {
                                $model->link('tags', $tag);
                            }
                        }
                    }
                    $generosSelected = Yii::$app->request->post('Jogo')['generos'];
                    if ($generosSelected) {
                        foreach ($generosSelected as $genero) {
                            $genero = Genero::findOne($genero);
                            if ($genero) {
                                $model->link('generos', $genero);
                            }
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', 'Um erro ocorreu ao guardar o jogo: ' . $e->getMessage());
                    return $this->redirect(['create']);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'modelUploadCapa' => $modelUploadCapa,
                'modelUploadScreenshots' => $modelUploadScreenshots,
                'franquias' => $franquias,
                'distribuidoras' => $distribuidoras,
                'editoras' => $editoras,
                'tags' => $tags,
                'generos' => $generos,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Sem permissões para efetuar a ação!.');
            return $this->goHome();
        }
    }


    /**
 * Updates an existing Jogo model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param int $id ID
 * @return string|\yii\web\Response
 * @throws NotFoundHttpException if the model cannot be found
 */
public
function actionUpdate($id)
{
    if (Yii::$app->user->can('editarJogos')) {
        $model = $this->findModel($id);

        if (!$model) {
            throw new NotFoundHttpException("Não foi possível encontrar o jogo  solicitado.");
        }

        $franquias = Franquia::find()->all();
        $distribuidoras = Distribuidora::find()->all();
        $editoras = Editora::find()->all();
        $tags = Tag::find()->all();
        $generos = Genero::find()->all();
        $modelUploadCapa = new UploadForm();
        $modelUploadScreenshots = new MultiUploadForm();

        try {
            if ($this->request->isPost && $model->load($this->request->post())) {
                $tagsSelected = [];// Caso o utilizador não selecione todas as tags é necessário inicializar porque senão irá dar erro
                $generosSelected = [];

                $modelUploadCapa->imageFile = UploadedFile::getInstance($modelUploadCapa, 'imageFile');
                $modelUploadScreenshots->imageFiles = UploadedFile::getInstances($modelUploadScreenshots, 'imageFiles');
                if ($modelUploadCapa->imageFile && $modelUploadCapa->imageFile!='') {
                    if ($modelUploadCapa->upload('@capasJogoPath')) {
                            $model->imagemCapa = $modelUploadCapa->imageFile->name;
                            $model->save();
                    }
                }
                if ($modelUploadScreenshots->imageFiles && $modelUploadScreenshots->imageFiles!='') {
                    if ($modelUploadScreenshots->upload('@screenshotsJogoPath')) {
                        foreach ($modelUploadScreenshots->imageFiles as $file) {
                            $screenshot = new Screenshot();
                            $screenshot->jogo_id = $model->id;
                            $screenshot->filename=$file->name;;

                            if ($screenshot->validate() && $screenshot->save()) {
                            } else {
                                $errors = $screenshot->getErrors();
                                Yii::$app->session->setFlash('error', 'Erro ao guardar a screenshot: ' . implode(', ', $errors));
                                return $this->redirect(['update', 'id' => $model->id]);
                            }

                        }
                    }
                }

                if (Yii::$app->request->post('Jogo')['tags']) {
                    $tagsSelected = Yii::$app->request->post('Jogo')['tags'];
                }
                $model->unlinkAll('tags', true);

                foreach ($tagsSelected as $tagId) {
                    $tag = Tag::findOne($tagId);
                    if ($tag) {
                        $model->link('tags', $tag);
                    }
                }

                if (Yii::$app->request->post('Jogo')['generos']) {
                    $generosSelected = Yii::$app->request->post('Jogo')['generos'];
                }

                $model->unlinkAll('generos', true);

                foreach ($generosSelected as $generoId) {
                    $genero = Genero::findOne($generoId);
                    if ($genero) {
                        $model->link('generos', $genero);
                    }
                }

                $model->save();


                return $this->redirect(['view', 'id' => $model->id]);
            }

        } catch (\Exception  $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }


        return $this->render('update', [
            'model' => $model,
            'modelUploadCapa' => $modelUploadCapa,
            'modelUploadScreenshots' => $modelUploadScreenshots,
            'franquias' => $franquias,
            'distribuidoras' => $distribuidoras,
            'editoras' => $editoras,
            'tags' => $tags,
            'generos' => $generos,
        ]);
    } else {
        return $this->goHome();
    }

}

/**
 * Deletes an existing Jogo model.
 * If deletion is successful, the browser will be redirected to the 'index' page.
 * @param int $id ID
 * @return \yii\web\Response
 * @throws NotFoundHttpException if the model cannot be found
 */
public
function actionDelete($id)
{

    if (Yii::$app->user->can('removerJogos')) {
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
    } else {
        return $this->goHome();
    }

}

/**
 * Finds the Jogo model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param int $id ID
 * @return Jogo the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
protected
function findModel($id)
{
    if (($model = Jogo::findOne(['id' => $id])) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}
}
