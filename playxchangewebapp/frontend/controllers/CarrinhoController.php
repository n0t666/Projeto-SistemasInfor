<?php

namespace frontend\controllers;

use Yii;
use common\models\Carrinho;
use frontend\models\CarrinhoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller
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
                        'actions' => ['create','index','update'],
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


    public function actionIndex()
    {
        if (Yii::$app->user->can('visualizarItensCarrinho')) {
            try {
                $user = Yii::$app->user->identity->profile;
                $model = $user->carrinho;

                if (!$model) {
                    $model = new Carrinho();
                    $model->utilizador_id = $user->id;

                    if (!$model->save()) {
                        throw new \Exception('Erro ao criar um novo carrinho.');
                    }
                }

                return $this->render('index', [
                    'model' => $model,
                ]);

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao processar o seu carrinho.');
                return $this->goHome();
            }
        } else {
            return $this->goHome();
        }

    }


    /**
     * Finds the Carrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinho::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
