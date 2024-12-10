<?php

namespace backend\modules\api\controllers;

use common\models\Avaliacao;
use common\models\CodigoPromocional;
use common\models\Jogo;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';

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

    public function actionView($jogoId){
        $user = Yii::$app->user->identity;

        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

       $avaliacao = $user->profile->getAvaliacoes()->where(['jogo_id' => $jogoId])->one();

        if($avaliacao){
            throw new NotFoundHttpException('Não existe nenhuma avaliação para o jogo especificado.');
        }

        return $avaliacao->attributes;
    }

    public function actionCreate(){
        $user = Yii::$app->user->identity;
        $body = Yii::$app->getRequest()->getBodyParams();


        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $jogoId = $body['jogo_id'] ?? null;
        $numEstrelas = $body['num_estrelas'] ?? null;

        if(!$jogoId || !$numEstrelas){
            throw new BadRequestHttpException('É necessário o número de estrelas e o jogo que deseja fazer a avaliação');
        }

        $jogo = Jogo::findOne($jogoId);

        if(!$jogo){
            throw new NotFoundHttpException('Jogo inexistente');
        }

       $avaliacao = $user->profile->getAvaliacoes()->where(['jogo_id' => $jogoId])->one();

        if($avaliacao){
            throw new Exception('Não é possível fazer mais do que uma avaliação para cada jogo');
        }

        if (!$numEstrelas || $numEstrelas < 0.5) {
            throw new Exception('O número de estrelas não é valido');
        }

        $avaliacao = new Avaliacao();
        $avaliacao->jogo_id = $jogoId;
        $avaliacao->utilizador_id = $user->id;
        $avaliacao->numEstrelas = $numEstrelas;

        if($avaliacao->save()){
            return $avaliacao;
        }else{
            return $avaliacao->errors;
        }
    }

    public function actionUpdate(){
        $user = Yii::$app->user->identity;
        $body = Yii::$app->getRequest()->getBodyParams();

        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $jogoId = $body['jogo_id'] ?? null;
        $numEstrelas = $body['num_estrelas'] ?? null;

        if(!$jogoId || !$numEstrelas){
            throw new BadRequestHttpException('É necessário o número de estrelas e o jogo que deseja fazer a avaliação');
        }

        $jogo = Jogo::findOne($jogoId);

        if(!$jogo){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        $avaliacao = $user->profile->getAvaliacoes()->where(['jogo_id' => $jogoId])->one();

        if(!$avaliacao){
            throw new Exception('Não é possível encontrar a avaliação solicitada');
        }

        if (!$numEstrelas || $numEstrelas < 0.5) {
            throw new Exception('O número de estrelas não é valido');
        }

        $avaliacao->numEstrelas = $numEstrelas;
        if($avaliacao->save()){
            return $avaliacao;
        }else{
            return $avaliacao->errors;
        }
    }

    public function actionDelete(){
        $user = Yii::$app->user->identity;
        $body = Yii::$app->getRequest()->getBodyParams();

        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $jogoId = $body['jogo_id'] ?? null;

        if(!$jogoId){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        $avaliacao = $user->profile->getAvaliacoes()->where(['jogo_id' => $jogoId])->one();

        if(!$avaliacao){
            throw new NotFoundHttpException('Não foi possível encontrar a avaliação solicitada');
        }

        if($avaliacao->delete()){
            Yii::$app->response->statusCode = 200;
            return 'Avaliação removida com sucesso';
        }else{
            return $avaliacao->errors;
        }


    }

}
