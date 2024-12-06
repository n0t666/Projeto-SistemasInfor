<?php

namespace backend\modules\api\controllers;

use common\models\Avaliacao;
use common\models\CodigoPromocional;
use common\models\Comentario;
use common\models\Jogo;
use common\models\User;
use MongoDB\Driver\Exception\InvalidArgumentException;
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

        $comentarios = Comentario::find()->where(["utilizador_id" => $user->id])->all();

        $response = [];

        foreach ($comentarios as $comentario) {
            $numEstrelas = Avaliacao::find()->where(['utilizador_id' => $user->id,'jogo_id' => $comentario->jogo->id])->one();
            $response[] = [
                'id' => $comentario->id,
                'id_jogo' => $comentario->jogo_id,
                'jogo' => $comentario->jogo->nome,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. $comentario->jogo->imagemCapa,
                'comentario' => $comentario->comentario,
                'numEstrelas' => $numEstrelas == null ? null : $numEstrelas->numEstrelas,
            ];
        }


        return $response;
    }

    public function actionView($id){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }


        $model = Comentario::find()->where(["utilizador_id" => $user->id, "id" => $id])->one();

        if(!$model){
            throw new NotFoundHttpException('Comentario inexistente');
        }
        return $model->attributes;
    }

    public function actionCreate(){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $utilizadorId = $body['utilizador_id'] ?? null;
        $jogoId = $body['jogo_id'] ?? null;
        $comentario = $body['comentario'] ?? null;


        if(!$utilizadorId || !$jogoId || !$comentario){
            throw new Exception('Para fazer um comentário é necessário passar um utilizador,jogo e comentário');
        }

        if($utilizadorId != $user->id){
            throw new UnauthorizedHttpException('Apenas pode fazer comentários na sua própia conta');
        }

        if(!Jogo::find()->where(['id' => $jogoId])->exists()){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        if (!Avaliacao::find()->where(['utilizador_id' => $utilizadorId, 'jogo_id' => $jogoId])->exists()) {
            throw new exception('É necessário de avaliar um jogo antes de comentar.');
        }

        if(Comentario::find()->where(['utilizador_id' => $user->id,'jogo_id' => $jogoId])->exists()){
            throw new Exception('Não pode criar mais do que um comentário para um determinado jogo');
        }



        $model = new Comentario();
        $model->utilizador_id = $utilizadorId;
        $model->jogo_id = $jogoId;
        $model->comentario = $comentario;
        if($model->save()){
            return $model->attributes;
        }else{
            return $model->errors;
        }
        }

    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $utilizadorId = $body['utilizador_id'] ?? null;
        $comentario = $body['comentario'] ?? null;
        $comentarioId = $body['comentario_id'] ?? null;

        if(!$utilizadorId || !$comentario || !$comentarioId){
            throw new InvalidArgumentException('Para editar um comentário é necessário passar um utilizador,jogo e comentário');
        }

        if($utilizadorId != $user->id){
            throw new UnauthorizedHttpException('Apenas pode editar comentários da sua própia conta');
        }

        $model = Comentario::find()->where(["utilizador_id" => $user->id, "id" => $comentarioId])->one();

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
            throw new InvalidArgumentException('É necessário do id para apagar um comentario');
        }

        $model = Comentario::find()->where(["utilizador_id" => $user->id, "id" => $comentarioId])->one();

        if(!$model){
            throw new NotFoundHttpException('Comentario inexistente');
        }

        if($model->delete()){
            Yii::$app->response->statusCode = 200;
            return 'Comentário apagado com sucesso';
        }else{
            return $model->errors;
        }
    }


}
