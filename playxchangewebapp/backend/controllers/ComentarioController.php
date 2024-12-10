<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use common\models\Comentario;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                        'actions' => ['index','view','delete'],
                        'allow' => true,
                        'roles' => ['admin','moderador'],
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
     * Lists all Comentario models.
     * @return mixed
     */
    public function actionIndex($userId)
    {
        $user = User::findOne($userId);

        if(!$user){
            return $this->goHome();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $user->profile->getComentarios(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    /**
     * Displays a single Comentario model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        if (Yii::$app->user->can('apagarComentario')) {
            try {
                $this->findModel($id)->delete();
            } catch (\Exception $e) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }
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
