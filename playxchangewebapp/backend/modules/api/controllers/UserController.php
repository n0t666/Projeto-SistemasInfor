<?php

namespace backend\modules\api\controllers;

use backend\controllers\UtilsController;
use backend\modules\api\components\CustomAuth;
use common\models\Avaliacao;
use common\models\Jogo;
use common\models\LoginForm;
use common\models\UploadForm;
use common\models\User;
use common\models\UtilizadorJogo;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function actions(){
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'auth' => [$this, 'authCustom'],
            'except' => ['login'],
        ];
        return $behaviors;
    }

    public function authCustom($token)
    {
        $user_ = User::findIdentityByAccessToken($token);
        if ($user_) {
            $this->user = $user_;
            Yii::$app->user->login($user_);
            return $user_;
        }
        throw new ForbiddenHttpException('No authentication');
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        switch ($action) {
            case 'public-profile':
                $backendUsers = User::getBackendUsers();

                $targetProfile = User::find()
                    ->where(['username' => $params['username']])
                    ->andWhere(['not in', 'id', $backendUsers])
                    ->one();

                if(!$targetProfile){
                    throw new NotFoundHttpException('Perfil não encontrado');
                }


                if($targetProfile->id === $this->user->id){
                    throw new ForbiddenHttpException('Não pode aceder ao seu próprio perfil através desta rota');
                }

                if($targetProfile->profile->privacidadePerfil === 1){
                    throw new ForbiddenHttpException('Perfil privado');
                }

                $isBlockedByCurrentUser = $targetProfile
                    ->profile
                    ->find()
                    ->joinWith(['utilizadorBloqueados b'])
                    ->andWhere(['b.id' => $this->user->id])
                    ->exists();

                if($isBlockedByCurrentUser){
                    throw new NotFoundHttpException('Perfil não encontrado');
                }
                break;
            default:
                break;
        }
    }

    public function actionLogin()
    {
        $login = new LoginForm();
        $login->load(Yii::$app->request->post(), '');
        if($login->username){
            $user = User::findByUsername($login->username);
            if($user && $user->validatePassword($login->password))
            {
                    return [
                        'id' => $user->id,
                        'username' => $user->username,
                        'token' => $user->auth_key
                    ];
            }else{
                throw new UnauthorizedHttpException('Não foi possível verificar as credenciais');
            }
        }
        throw new BadRequestHttpException('Dados incompletos');
    }

    public function actionAtualizar()
    {
        $body = Yii::$app->request->getBodyParams();
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        if (isset($body['user'])) {
            $userData = $body['user'];

            if (isset($userData['password']) && $userData['password'] != null) {
                $user->setPassword($userData['password']);
            }

            if (isset($userData['username'] )) {
                $existingUser = User::find()->where(['username' => $userData['username']])->andWhere(['<>', 'id', $user->id])->one();
                if ($existingUser) {
                    throw new BadRequestHttpException('O username já está em uso.');
                }
                $user->username = $userData['username'];
            }

            if (isset($userData['email'])) {
                $existingUser = User::find()->where(['email' => $userData['email']])->andWhere(['<>', 'id', $user->id])->one();
                if ($existingUser) {
                    throw new BadRequestHttpException('O email já está em uso.');
                }
                $user->email = $userData['email'];
            }

            if (!$user->validate()) {
                throw new BadRequestHttpException('A validação do user falhou: ' . json_encode($user->errors));
            }
        }

        if (isset($body['profile'])) {
            $profileData = $body['profile'];
            $profile = $user->profile;

            if(isset($profileData["imagemCapa"]) &&  $profileData["imagemCapa"]){

                $base64ImageCapa = $profileData["imagemCapa"];

                if (strpos($base64ImageCapa, 'base64,') !== false) { // Remover a primeira parte caso
                    $base64ImageCapa = explode('base64,', $base64ImageCapa)[1];
                }

                $imgCapa = UtilsController::uploadBase64(Yii::getAlias('@perfilPath'),$base64ImageCapa);
                if($imgCapa){
                    $profile->fotoCapa = $imgCapa;
                }else{
                    throw new BadRequestHttpException('Ocorreu um erro ao fazer o upload da foto de capa');
                }
            }

            if(isset($profileData["imagemPerfil"]) &&  $profileData["imagemPerfil"]){

                $base64ImagePerfil = $profileData["imagemPerfil"];

                if (strpos($base64ImagePerfil, 'base64,') !== false) {
                    $base64ImagePerfil = explode('base64,', $base64ImagePerfil)[1];
                }

                $imgPerfil = UtilsController::uploadBase64(Yii::getAlias('@perfilPath'),$base64ImagePerfil);
                if($imgPerfil){
                    $profile->fotoPerfil = $imgPerfil;
                }else{
                    throw new BadRequestHttpException('Ocorreu um erro ao fazer o upload da foto de perfil');
                }
            }

            $profile->load($profileData, '');
            if (!$profile->validate()) {
                throw new BadRequestHttpException('A validação do perfil falhou: ' . json_encode($profile->errors));
            }

            if (!$profile->save()) {
                throw new BadRequestHttpException('Falha ao guardar os dados do perfil.');
            }
        }

        if (!$user->save()) {
            throw new BadRequestHttpException('Falha ao guardar os dados do user.');
        }

        return [
            'profile' => $user->profile->attributes,
        ];
    }

    public function actionDesejados()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $desejados = $user->profile->getInteracoes()->where(['isDesejado' => 1])->all();
        $response = [];

        foreach ($desejados as $desejado) {
            $jogo = $desejado->jogo;
            $produtos = [];
            foreach ($jogo->produtos as $produto) {
                $produtos[] = [
                    'id' => $produto->id,
                    'plataformaNome' => $produto->plataforma->nome,
                    'plataformaId' => $produto->plataforma->id,
                    'preco' => $produto->preco,
                    'quantidade' => $produto->quantidade,
                ];
            }
            $tags = [];
            foreach ($jogo->tags as $tag) {
                $tags[] = [
                    'id' => $tag->id,
                    'nome' => $tag->nome,
                ];
            }
            $generos = [];
            foreach ($jogo->generos as $genero) {
                $generos[] = [
                    'id' => $genero->id,
                    'nome' => $genero->nome,
                ];
            }
            $screenshots = [];
            foreach ($jogo->screenshots as $screenshot) {
                $screenshots[] = Yii::getAlias('@screenshotsJogoUrl') . '/' . $screenshot->filename;
            }
            $response[] = [
                'id' => $jogo->id,
                'nome' => $jogo->nome,
                'descricao' => $jogo->descricao,
                'dataLancamento' => $jogo->dataLancamento,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa,
                'distribuidora' => $jogo->distribuidora->nome,
                'franquia' => $jogo->franquia ? $jogo->franquia->nome : null,
                'editora' => $jogo->editora->nome,
                'trailer' => $jogo->trailerLink,
                'desejados' => $jogo->getNumDesejados(),
                'jogados' => $jogo->getNumJogados(),
                'favoritos' => $jogo->getNumFavoritos(),
                'media' => $jogo->getMediaEstrelas(),
                'reviews' => count($jogo->comentarios),
                'produtos' => $produtos,
                'tags' => $tags,
                'generos' => $generos,
                'screenshots' => $screenshots,
            ];
        }


        return $response;
    }

    public function actionJogados(){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $jogados = $user->profile->getInteracoes()->where(['isJogado' => 1])->all();
        $response = [];

        foreach ($jogados as $jogado) {
            $response[] = [
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. $jogado->jogo->imagemCapa,
                'id' => $jogado->jogo->id,
            ];
        }


        return $response;
    }

    public function actionFavoritos()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $favoritos = $user->profile->getInteracoes()->where(['isFavorito' => 1])->all();


        $response = [];

        foreach ($favoritos as $favorito) {
            $response[] = [
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. $favorito->jogo->imagemCapa,
                'id' => $favorito->jogo->id,
            ];
        }


        return $response;
    }

    /*
     *
     *  1 - Jogado , 2 - Desejado , 3 - Favorito
     *
     */

    public function actionInteragir(){
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $body = Yii::$app->request->getBodyParams();

        $jogoId = $body['jogo_id'] ?? null;
        $tipo = $body['tipo'] ?? null;

        if(!$jogoId){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        if(!Jogo::find()->where(['id' => $jogoId])->exists()){
            throw new NotFoundHttpException('Jogo inexistente');
        }

        if(!$tipo){
            throw new NotFoundHttpException('Tipo de interação inexistente');
        }


        $userJogo = $user->profile->getInteracoes()->where(['jogo_id' => $jogoId])->one();

        if (!$userJogo) {
            $userJogo = new UtilizadorJogo();
            $userJogo->utilizador_id = $user->id;
            $userJogo->jogo_id = $jogoId;
        }

        switch ($tipo) {
            case '1': // Jogado
                $userJogo->isJogado = $userJogo->isJogado ? 0 : 1;
                break;
            case '2': // Favorito
                $userJogo->isFavorito = $userJogo->isFavorito ? 0 : 1;
                break;
            case '3': // Desejado
                $userJogo->isDesejado = $userJogo->isDesejado ? 0 : 1;
                break;
            default:
                throw new \Exception('Tipo de interação inesperado');
        }

        if ($userJogo->save()) {
            return ["message" => "Interação registrada com sucesso'"];
        } else {
            throw new \Exception('Falha ao Guardar o estado do jogo.');
        }
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Token inválido');
        }

        $profile = $user->profile;
        $numReviews = count($profile->getComentarios()->all());
        $numJogos = count($profile->getInteracoes()->where(['isJogado' => 1])->all());
        $numFavoritos = count($profile->getInteracoes()->where(['isFavorito' => 1])->all());
        $numDesejados = count($profile->getInteracoes()->where(['isDesejado' => 1])->all());
        $numSeguidores = count($profile->getSeguidores()->all());
        $numSeguir = count($profile->getSeguidos()->all());

        // Devido á sobrecarga de trabalho não será possível implementar a funcionalidade realmente por ordem de recentes

        $previewFavoritos = $profile
            ->getInteracoes()
            ->where(['isFavorito' => 1])
            ->orderBy(new Expression('rand()'))
            ->limit(4)
            ->all();

        $imgsFavoritos = [];

        foreach ($previewFavoritos as $favorito) {
            $idJogo = $favorito->jogo->id;
            $imgsFavoritos[] =  [
                'id' => $idJogo,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. Jogo::findOne($idJogo)->imagemCapa
            ];
        }



        return[
            'username' => $user->username,
            'email' => $user->email,
            'nome' => $profile->nome,
            'dataNascimento' => $profile->dataNascimento,
            'biografia' => $profile->biografia,
            'fotoCapa' => $profile->getFotoCapa(),
            'fotoPerfil' =>  $profile->getFotoPerfil(),
            'nif' => $profile->nif,
            'privacidadeSeguidores' => $profile->privacidadeSeguidores,
            'privacidadePerfil' => $profile->privacidadePerfil,
            'privacidadeJogos' =>  $profile->privacidadeJogos,
            'numReviews' => $numReviews,
            'numJogados' => $numJogos,
            'numFavoritos' => $numFavoritos,
            'numDesejados' => $numDesejados,
            'numSeguidores' => $numSeguidores,
            'numSeguir' => $numSeguir,
            'previewFavoritos' => $imgsFavoritos
        ];
    }

    public function actionPublicProfile($username){

        $user = User::findByUsername($username);

        $this->checkAccess('public-profile', null, ['username' => $username]);

        if(!$user){
            throw new NotFoundHttpException('Perfil não encontrado');
        }

        $profile = $user->profile;
        $numReviews = count($profile->getComentarios()->all());
        $numJogos = count($profile->getInteracoes()->where(['isJogado' => 1])->all());
        $numFavoritos = count($profile->getInteracoes()->where(['isFavorito' => 1])->all());
        $numDesejados = count($profile->getInteracoes()->where(['isDesejado' => 1])->all());
        $numSeguidores = count($profile->getSeguidores()->all());
        $numSeguir = count($profile->getSeguidos()->all());

        $previewFavoritos = $profile
            ->getInteracoes()
            ->where(['isFavorito' => 1])
            ->orderBy(new Expression('rand()'))
            ->limit(4)
            ->all();

        $imgsFavoritos = [];

        foreach ($previewFavoritos as $favorito) {
            $idJogo = $favorito->jogo->id;
            $imgsFavoritos[] =  [
                'id' => $idJogo,
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. Jogo::findOne($idJogo)->imagemCapa
            ];
        }

        return[
            'username' => $user->username,
            'nome' => $profile->nome,
            'dataNascimento' => $profile->dataNascimento,
            'biografia' => $profile->biografia,
            'fotoCapa' => $profile->getFotoCapa(),
            'fotoPerfil' =>  $profile->getFotoPerfil(),
            'nif' => $profile->nif,
            'privacidadeSeguidores' => $profile->privacidadeSeguidores,
            'privacidadePerfil' => $profile->privacidadePerfil,
            'privacidadeJogos' =>  $profile->privacidadeJogos,
            'numReviews' => $numReviews,
            'numJogados' => $numJogos,
            'numFavoritos' => $numFavoritos,
            'numDesejados' => $numDesejados,
            'numSeguidores' => $numSeguidores,
            'numSeguir' => $numSeguir,
            'previewFavoritos' => $imgsFavoritos
        ];



    }


}
