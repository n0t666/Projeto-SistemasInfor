<?php

namespace frontend\controllers;

use common\models\Denuncia;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;

class DenunciaController extends Controller{

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

    public function actionCreate(){
        $userId = Yii::$app->user->id;

        if (!$userId) {
            throw new NotAcceptableHttpException();
        }

        $model = new Denuncia();

        try {
            if (Yii::$app->request->isPost) {
                $model->load(Yii::$app->request->post());

                if($model->denunciado_id == $model->denunciante_id){
                    throw new NotAcceptableHttpException();
                }

                if($model->denunciante->id != $userId){
                    throw new NotAcceptableHttpException();
                }


                if(Denuncia::find()->where(['denunciante_id' => $userId, 'denunciado_id' => $model->denunciado->id])->exists()){
                    Yii::$app->session->setFlash('error', 'Já fez uma denúncia previamente.');
                    return $this->goBack();
                }

                $model->estado = Denuncia::STATUS_PROCESSING;

                if($model->save()){
                    Yii::$app->session->setFlash('sucess', 'Utilizador denunciado com sucesso.');
                    return $this->goBack();
                }else{
                    Yii::$app->session->setFlash('error', 'Ocorreu um erro ao guardar a denúncia.');
                }

            }
        }catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao guardar a denúncia.');
            return $this->goBack();
        }

        return $this->goBack();
    }

}