<?php

namespace backend\controllers;

use common\models\Distribuidora;
use common\models\Editora;
use common\models\Franquia;
use common\models\Genero;
use common\models\Jogo;
use common\models\Tag;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

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
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Jogo models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Jogo::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jogo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Jogo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Jogo();
        $franquias = Franquia::find()->all();
        $distribuidoras = Distribuidora::find()->all();
        $editoras = Editora::find()->all();
        $tags = Tag::find()->all();
        $generos  = Genero::find()->all();

        if ($this->request->isPost) {
            try {
                if ($model->load($this->request->post()) && $model->save()) {
                    $tagsSelected = Yii::$app->request->post('Jogo')['tags'];
                    $generosSelected = Yii::$app->request->post('Jogo')['generos'];
                    if ($tagsSelected) {
                        foreach ($tagsSelected as $tag) {
                            $tag = Tag::findOne($tag);
                            if ($tag) {
                                $model->link('tags', $tag);
                            }
                        }
                    }
                    if($generosSelected){
                        foreach ($generosSelected as $genero) {
                            $genero = Genero::findOne($genero);
                            if ($genero) {
                                $model->link('generos', $genero);
                            }
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\yii\base\InvalidArgumentException $e){
                throw new InvalidArgumentException($e->getMessage());
            }
            catch (\Exception  $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('create', [
            'model' => $model,
            'franquias' => $franquias,
            'distribuidoras' => $distribuidoras,
            'editoras' => $editoras,
            'tags' => $tags,
            'generos' => $generos,
        ]);
    }

    /**
     * Updates an existing Jogo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model) {
            throw new NotFoundHttpException("Não foi possível encontrar o jogo  solicitado.");
        }

        $franquias = Franquia::find()->all();
        $distribuidoras = Distribuidora::find()->all();
        $editoras = Editora::find()->all();
        $tags = Tag::find()->all();
        $generos = Genero::find()->all();

        try
        {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $tagsSelected = [];// Caso o utilizador não selecione todas as tags é necessário inicializar porque senão irá dar erro
                $generosSelected = [];

                if(Yii::$app->request->post('Jogo')['tags']){
                    $tagsSelected = Yii::$app->request->post('Jogo')['tags'];
                }
                $model->unlinkAll('tags', true);

                foreach ($tagsSelected as $tagId) {
                    $tag = Tag::findOne($tagId);
                    if ($tag) {
                        $model->link('tags', $tag);
                    }
                }

                if(Yii::$app->request->post('Jogo')['generos']){
                    $generosSelected = Yii::$app->request->post('Jogo')['generos'];
                }

                $model->unlinkAll('generos', true);

                foreach ($generosSelected as $generoId) {
                    $genero = Genero::findOne($generoId);
                    if ($genero) {
                        $model->link('generos', $genero);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        catch (\yii\base\InvalidArgumentException $e){
            throw new InvalidArgumentException($e->getMessage());
        }
        catch (\Exception  $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }


        return $this->render('update', [
            'model' => $model,
            'franquias' => $franquias,
            'distribuidoras' => $distribuidoras,
            'editoras' => $editoras,
            'tags' => $tags,
            'generos' => $generos,
        ]);
    }

    /**
     * Deletes an existing Jogo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jogo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Jogo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jogo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
