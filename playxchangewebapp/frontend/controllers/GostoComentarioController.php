<?php

namespace frontend\controllers;

use backend\controllers\UserController;
use common\models\CodigoPromocional;
use common\models\GostoComentario;
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
class GostoComentarioController extends Controller
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
                        'actions' => ['create'],
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




    public function actionCreate()
    {
        if (Yii::$app->user->can('gostarComentario')) {
            $model = new GostoComentario();
            $jogo = null;
            $user = Yii::$app->user->identity->id;


            if (!$user) {
                throw new NotAcceptableHttpException();
            }

            try {
                if ($model->load(Yii::$app->request->post())) {
                    if ($model->utilizador_id == $user) {
                        $jogo = $model->comentario->jogo_id;

                        $existe = GostoComentario::find()->where([
                            'utilizador_id' => $user,
                            'comentario_id' => $model->comentario_id
                        ])->one();

                        if ($existe ) {
                            if ($existe->delete()) {
                                Yii::$app->session->setFlash('success', 'Gosto removido com sucesso');
                            } else {
                                throw new ServerErrorHttpException('Erro ao remover o gosto');
                            }
                        } else {
                            $model->utilizador_id = $user;
                            if ($model->save()) {
                                Yii::$app->session->setFlash('success', 'Gosto adicionado com sucesso');
                            } else {
                                throw new ServerErrorHttpException('Erro ao adicionar o gosto');
                            }
                        }
                    } else {
                        throw new NotAcceptableHttpException();
                    }

                    return $this->redirect(['jogo/view', 'id' => $jogo]);

                }
            } catch (\Exception $e) {
                throw new ServerErrorHttpException($e->getMessage());
            }
        }
        return $this->goHome();
    }



    protected function findModel($id)
    {
        if (($model = GostoComentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
