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
use function PHPUnit\Framework\exactly;

class JogoController extends ActiveController
{
    public $modelClass = 'common\models\Jogo';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['index', 'view','group'],
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
        $jogos = Jogo::find()->all();

        $data = [];

        foreach ($jogos as $jogo) {
            $data[] = [
                'id' => $jogo->id,
                'nome' => $jogo->nome,
                'dataLancamento' => $jogo->dataLancamento,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa,
            ];
        }
        return $data;
    }

    public function actionView($id)
    {
        $user = null;

        if(Yii::$app->request->get('access-token') != null){
            $user = User::findIdentityByAccessToken(Yii::$app->request->get('access-token'));
            if(!$user){
                throw new UnauthorizedHttpException('Não foi possível fazer a autenticação');
            }
        }

        $jogo = Jogo::findOne($id);



        if (!$jogo) {
            throw new NotFoundHttpException('Não foi possível encontrar o jogo solicitado');
        }

        $jogoProdutos = $jogo->produtos;
        $produtos = [];


        foreach ($jogoProdutos as $jogoProduto) {
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
        foreach ($jogoTags as $jogoTag) {
            $tags [] = [
                'id' => $jogoTag->id,
                'nome' => $jogoTag->nome,
            ];
        }

        $jogoGeneros = $jogo->generos;
        $generos = [];
        foreach ($jogoGeneros as $jogoGenero) {
            $generos[] = [
                'id' => $jogoGenero->id,
                'nome' => $jogoGenero->nome,
            ];
        }

        $jogoScreenshots = $jogo->screenshots;
        $screenshots = [];
        foreach ($jogoScreenshots as $jogoScreenshot) {
            $screenshots[] =  Yii::getAlias('@mobileIp')  . Yii::getAlias('@screenshotsJogoUrl') . '/' . $jogoScreenshot->filename;
        }

        $avaliacoes = $jogo->getAvaliacoes()->where(['jogo_id' => $id])->all();


        $numEstrelas = array_map(function ($avaliacao) {
            return $avaliacao->numEstrelas;
        }, $avaliacoes);


        $numEstrelas = array_filter($numEstrelas);
        $avg = null;
        if (count($numEstrelas) > 0) {
            $avg = array_sum($numEstrelas) / count($numEstrelas);
        }

        $atividade = null;
        $avaliacao = null;
        if ($user) {
            $userActivity = $user->profile->getInteracoes()->where(['jogo_id' => $id])->one();
            $userAvaliacao = $user->profile->getAvaliacoes()->where(['utilizador_id' => $user->id, 'jogo_id' => $id])->one();
            if ($userAvaliacao) {
                $avaliacao = $userAvaliacao->attributes;
            }
            if ($userActivity) {
                $atividade = $userActivity->attributes;
            }
        }


        return [
            'id' => $jogo->id,
            'nome' => $jogo->nome,
            'descricao' => $jogo->descricao,
            'dataLancamento' => $jogo->dataLancamento,
            'capa' => Yii::getAlias('@mobileIp') . Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa,
            'distribuidora' => $jogo->distribuidora->nome,
            'franquia' => $jogo->franquia ? $jogo->franquia->nome : null,
            'editora' => $jogo->editora->nome,
            'trailer' => $jogo->trailerLink,
            'desejados' => $jogo->getNumDesejados(),
            'jogados' => $jogo->getNumJogados(),
            'media' => $avg,
            'reviews' => count($jogo->comentarios),
            'avaliacao' => $avaliacao,
            'atividade' => $atividade,
            'produtos' => $produtos,
            'tags' => $tags,
            'generos' => $generos,
            'screenshots' => $screenshots,
        ];
    }

    public function actionGroup($type)
    {
        $jogos = null;
        switch ($type) {
            case 'populares':
                $jogos = Jogo::find()
                    ->joinWith('utilizadoresjogos u')
                    ->groupBy('jogos.id')
                    ->orderBy([
                        'COUNT(CASE WHEN u.isJogado = 1 THEN 1 END)' => SORT_DESC,
                        'COUNT(CASE WHEN u.isFavorito = 1 THEN 1 END)' => SORT_DESC,
                    ])
                    ->limit(8)->all();
                break;
            case 'recentes':
                $jogos = Jogo::find()
                    ->orderBy([
                        'dataLancamento' => SORT_DESC,
                    ])->limit(8)->all();
                break;
                default:
                    throw new BadRequestHttpException('Tipo de grupo inválido');
        }

        if(!$jogos){
            throw new BadRequestHttpException('Tipo de grupo inválido');
        }


        $response = [];

        foreach ($jogos as $jogo) {
            $response[] = [
                'id' => $jogo->id,
                'nome' => $jogo->nome,
                'dataLancamento' => $jogo->dataLancamento,
                'capa' => Yii::getAlias('@mobileIp') . Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa,
            ];
        }

        return $response;
    }


}
