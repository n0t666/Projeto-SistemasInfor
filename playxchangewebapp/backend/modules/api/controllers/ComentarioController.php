<?php

namespace backend\modules\api\controllers;

use common\models\Avaliacao;
use common\models\CodigoPromocional;
use common\models\Comentario;
use common\models\Jogo;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ComentarioController extends ActiveController
{
    public $modelClass = 'common\models\Comentario';

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

    public function actionIndex(){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $comentarios = $user->profile->comentarios;

        $response = [];


        foreach ($comentarios as $comentario) {
            $numEstrelas = $user->profile->getAvaliacoes()->where(['jogo_id' => $comentario->jogo->id])->one();
            $response[] = [
                'Comentario' => [
                    'id' => $comentario->id,
                    'comentario' => $comentario->comentario,
                    'numEstrelas' => $numEstrelas ? $numEstrelas->numEstrelas : null, // Se não existir avaliação, não devolve nada
                ],
                'Jogo' => [
                    'id' => $comentario->jogo->id,
                    'nome' => $comentario->jogo->nome,
                    'dataLancamento' => $comentario->jogo->dataLancamento,
                    'imagem' => Yii::getAlias('@capasJogoUrl') . '/' . $comentario->jogo->imagemCapa,
                ]
            ];
        }


        return $response;
    }

    public function actionView($id){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }


        $model = $user->profile->getComentarios()->where(['id' => $id])->one();

        if(!$model){
            throw new NotFoundHttpException('Comentario inexistente');
        }
        $numEstrelas = $user->profile->getAvaliacoes()->where(['jogo_id' => $model->jogo->id])->one();
        return [
            'id' => $model->id,
            'comentario' => $model->comentario,
            'numEstrelas' => $numEstrelas ? $numEstrelas->numEstrelas : null,
            'jogo' => [
                'id' => $model->jogo->id,
                'nome' => $model->jogo->nome,
                'dataLancamento' => $model->jogo->dataLancamento,
                'imagem' => Yii::getAlias('@capasJogoUrl') . '/' . $model->jogo->imagemCapa,
            ]
        ];
    }

    public function actionCreate(){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $jogoId = $body['jogo_id'] ?? null;
        $comentario = $body['comentario'] ?? null;


        if(!$jogoId || !$comentario){
            throw new \Exception('Para fazer um comentário é necessário passar um jogo e comentário');
        }

        if(!Jogo::find()->where(['id' => $jogoId])->exists()){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        if (!$user->profile->getAvaliacaos()->where(['id' => $jogoId])->exists()) {
            throw new \Exception('É necessário de avaliar um jogo antes de comentar.');
        }

        if($user->profile->getComentarios()->where(['jogo_id' => $jogoId])->exists()){
            throw new \Exception('Não pode criar mais do que um comentário para um determinado jogo');
        }



        $model = new Comentario();
        $model->utilizador_id = $user->id;
        $model->jogo_id = $jogoId;
        $model->comentario = $comentario;
        if($model->save()){
            return $model->attributes;
        }else{
            return $model->errors;
        }
        }

    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $comentario = $body['comentario'] ?? null;
        $comentarioId = $id ?? null;

        if(!$comentario || !$comentarioId){
            throw new \Exception('Para editar um comentário é necessário passar um jogo e um comentário');
        }

        $model = $user->profile->getComentarios()->where(['id' => $comentarioId])->one();

        if(!$model){
            throw new NotFoundHttpException('Comentario inexistente');
        }

        $model->comentario = $comentario;
        if($model->save()){
            return $model->attributes;
        }else {
            return $model->errors;
        }
    }

    public function actionDelete($id){
        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $comentarioId = $id ?? null;

        if(!$comentarioId){
            throw new \Exception('É necessário do id para apagar um comentario');
        }

        $model = $user->profile->getComentarios()->where(['id' => $comentarioId])->one();

        if(!$model){
            throw new NotFoundHttpException('Comentario inexistente');
        }

        if($model->delete()){
            Yii::$app->response->statusCode = 200;
            return ['message' => 'Comentario apagado com sucesso'];
        }else{
            return $model->errors;
        }
    }


}
