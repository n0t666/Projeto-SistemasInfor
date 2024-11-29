<?php

namespace frontend\controllers;

use common\models\Jogo;
use Yii;
use common\models\Comentario;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller
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
                        'actions' => ['create','update'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
                ],
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
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comentario();
        $userId = Yii::$app->user->id;

        if (!$userId) {
            throw new NotAcceptableHttpException();
        }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $jogo = Yii::$app->request->post('Comentario')['jogo_id'];
                if(Jogo::find()->where(['id' => $jogo])->exists()){
                    if(Comentario::find()->where(['jogo_id' => $jogo,'utilizador_id' => $userId])->exists()){
                        Yii::$app->session->setFlash('error', 'Já foi efetuada uma avaliação para este jogo');
                        return $this->goBack();
                    }else{
                        $model->utilizador_id = $userId;
                        $model->save();
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Não foi possível encontrar o jogo especificado');
                    return $this->goBack();
                }
                return $this->redirect(['jogo/view', 'id' => $model->id]);
            }
        }else{
            throw new ServerErrorHttpException();
        }

    }

    /**
     * Updates an existing Comentario model.
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
     * Deletes an existing Comentario model.
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
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
