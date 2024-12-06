<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\Jogo;
use common\models\LinhaCarrinho;
use common\models\User;
use Yii;
use yii\base\ErrorException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class JogoController extends ActiveController
{
    public $modelClass = 'common\models\Jogo';

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
            'except' => ['index', 'view'],
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
        $jogos = Jogo::find()->all();

        $data = [];

        foreach ($jogos as $jogo){
            $data[] = [
                'id' => $jogo->id,
                'nome' => $jogo->nome,
                'dataLancamento' => $jogo->dataLancamento,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. $jogo->imagemCapa,
            ];
        }
        return $data;
    }

    public function actionView($id)
    {
        $user = Yii::$app->user->identity;

        $jogo = Jogo::findOne($id);
        if(!$jogo){
            throw new NotFoundHttpException('Não foi possível encontrar o jogo solicitado');
        }

        $jogoProdutos = $jogo->produtos;
        $produtos = [];


        foreach ($jogoProdutos as $jogoProduto){
            $produtos[] = [
                'id' => $jogoProduto->id,
                'plataformaNome' => $jogoProduto->plataforma->nome,
                'plataformaId' => $jogoProduto->plataforma->id,
                'preco' => $jogoProduto->preco,
                'quantidade' => $jogoProduto->quantidade,
            ];
        }

        $jogoTags = $jogo->tags;
        $tags = [];
        foreach ($jogoTags as $jogoTag){
            $tags = [
                'id' => $jogoTag->id,
                'nome' => $jogoTag->nome,
            ];
        }

        $jogoGeneros = $jogo->generos;
        $generos = [];
        foreach ($jogoGeneros as $jogoGenero){
            $generos[] = [
                'id' => $jogoGenero->id,
                'nome' => $jogoGenero->nome,
            ];
        }

        $jogoScreenshots = $jogo->screenshots;
        $screenshots = [];
        foreach ($jogoScreenshots as $jogoScreenshot){
            $screenshots[] = [
                'id' => $jogoScreenshot->id,
                'path' => Yii::getAlias('@screenshotsJogoUrl') . '/' . $jogoScreenshot->filename
            ];
        }

        $avaliacoes = $jogo->getAvaliacoes()->where(['jogo_id' => $id])->all();


        $numEstrelas = array_map(function($avaliacao) {
            return $avaliacao->numEstrelas;
        }, $avaliacoes);


        $numEstrelas = array_filter($numEstrelas);
        $avg = null;
        if(count($numEstrelas) > 0){
            $avg = array_sum($numEstrelas)/count($numEstrelas);
        }

        $atividade = null;
        $avaliacao = null;
        if ($user) {
            $userActivity = $user->profile->getInteracoes->where(['jogo_id' => $id])->one();
            $userAvaliacao = $user->profile->getAvaliacoes->where(['jogo_id' => $id])->one();
            if($userAvaliacao){
                $avaliacao = $userAvaliacao->attributes;
            }
            if($userActivity){
                $atividade = $userActivity->attributes;
            }
        }


        return [
            'id' => $jogo->id,
            'nome' => $jogo->nome,
            'descricao' => $jogo->descricao,
            'dataLancamento' => $jogo->dataLancamento,
            'capas' => Yii::getAlias('@capasJogoUrl') . '/'. $jogo->imagemCapa,
            'distribuidora' => $jogo->distribuidora->nome,
            'editora' => $jogo->editora->nome,
            'trailer' => $jogo->trailerLink,
            'desejados' => $jogo->getNumDesejados(),
            'jogados' => $jogo->getNumJogados(),
            'media' => $avg,
            'reviews' => count($jogo->comentarios),
            'avaliacao' => $avaliacao,
            'atividade' => $atividade,
            'produtos'=> $produtos,
            'tags' => $tags,
            'generos' => $generos,
            'screenshots' => $screenshots,
        ];

    }

}
