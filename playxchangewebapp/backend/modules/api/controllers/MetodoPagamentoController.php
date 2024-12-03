<?php

namespace backend\modules\api\controllers;

use common\models\MetodoPagamento;
use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class MetodoPagamentoController extends ActiveController
{
    public $modelClass = 'common\models\MetodoPagamento';

    public function actions(){
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['index','view'],
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    public  function actionIndex()
    {
        $metodosPagamento = MetodoPagamento::find()->where(['isAtivo' => 1])->all();

        if (empty($metodosPagamento)) {
            throw new NotFoundHttpException('Não foi possível encontrar métodos de pagamento ativos');
        }


        $response = [];
        foreach ($metodosPagamento as $metodo) {
            $response[] = [
                'id' => $metodo->id,
                'nome' => $metodo->nome,
                'logotipo' => Yii::getAlias('@utilsUrl/') . $metodo->logotipo,
            ];
        }

        return $response;
    }

    public function actionView($id)
    {
        $metodoPagamento = MetodoPagamento::find()
            ->where(['isAtivo' => 1, 'id' => $id])
            ->one();

        if(!$metodoPagamento){
            throw new NotFoundHttpException('Não foi possível encontrar o método de pagamento especificado');
        }

        return[
            'id' => $metodoPagamento->id,
            'nome' => $metodoPagamento->nome,
            'logotipo' => Yii::getAlias('@utilsUrl/') . $metodoPagamento->logotipo,
        ];
    }


}
