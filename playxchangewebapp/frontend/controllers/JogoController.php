<?php

namespace frontend\controllers;

use Yii;
use common\models\Jogo;
use frontend\models\JogoSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JogoController implements the CRUD actions for Jogo model.
 */
class JogoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Jogo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $jogos = Jogo::find()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Jogo::find(),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jogo model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $jogo = $this->findModel($id);

        $interaction = \common\models\UtilizadorJogo::find()
            ->where(['jogo_id' => $jogo->id, 'utilizador_id' => Yii::$app->user->id])
            ->one();

        $avaliacao = \common\models\Avaliacao::find()
            ->where(['jogo_id' => $jogo->id, 'utilizador_id' => Yii::$app->user->id])
            ->one();

        if(!$avaliacao){
            $avaliacao = new \common\models\Avaliacao();
            $avaliacao->jogo_id = $jogo->id;
            $avaliacao->utilizador_id = Yii::$app->user->id;
        }


        return $this->render('view', [
            'model' => $jogo,
            'interaction' => $interaction,
            'avaliacao' => $avaliacao,
        ]);
    }

    /**
     * Creates a new Jogo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jogo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jogo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Jogo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
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
        if (($model = Jogo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
