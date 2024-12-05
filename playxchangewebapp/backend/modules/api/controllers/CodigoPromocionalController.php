<?php

namespace backend\modules\api\controllers;

use common\models\CodigoPromocional;
use common\models\User;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class CodigoPromocionalController extends ActiveController
{
    public $modelClass = 'common\models\CodigoPromocional';

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
            'except' => [''],
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

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

       $codigos = CodigoPromocional::find()->all();

       if(empty($codigos)){
           throw new NotFoundHttpException('Não existem promoções ativas');
       }

       $response = [];

       foreach($codigos as $codigo){
           $usado = $user->profile->getCodigos()
               ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id'])
               ->andWhere(['codigosPromocionais.id' => $codigo->id])
               ->exists();
           $response[] = [
               'id' => $codigo->id,
               'codigo' => $codigo->codigo,
               'desconto' => $codigo->desconto,
               'usado' => $usado ? 1 : 0,
           ];
       }

       return $response;
    }

    public function actionView($id){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $codigo = CodigoPromocional::find()->where(['id' => $id])->one();

        if(!$codigo){
            throw new NotFoundHttpException('Não foi possível encontrar o código promocional especificado');
        }

        $usado = $user->profile->getCodigos()
            ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id'])
            ->andWhere(['codigosPromocionais.id' => $id])
            ->exists();

        return[
            'id' => $codigo->id,
            'codigo' => $codigo->codigo,
            'desconto' => $codigo->desconto,
            'usado' => $usado ? 1 : 0,
        ];
    }





}
