<?php

namespace backend\modules\api\controllers;

use backend\controllers\UtilsController;
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
            'class' => QueryParamAuth::className(),
            'except' => ['login'],
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

    public function actionLogin()
    {
        $login = new LoginForm();
        $login->load(Yii::$app->request->post(), '');
        if($login->username){
            $user = User::findByUsername($login->username);
            if($user && $user->validatePassword($login->password))
            {
                $auth = Yii::$app->authManager;

                if ($auth->checkAccess($user->id, 'cliente')) {
                    return [
                        'id' => $user->id,
                        'username' => $user->username,
                        'token' => $user->auth_key
                    ];
                }else{
                    throw new ForbiddenHttpException('Não possui permissões suficientes para fazer o login');
                }
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

                if (strpos($base64ImageCapa, 'base64,') !== false) {
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
            $response[] = [
                'capa' => Yii::getAlias('@capasJogoUrl') . '/'. $desejado->jogo->imagemCapa,
                'jogo_id' => $desejado->jogo->id,
            ];
        }

        $response['count'] = count($desejados);

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
                'jogo_id' => $jogado->jogo->id,
            ];
        }

        $response['count'] = count($jogados);

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
                'jogo_id' => $favorito->jogo->id,
            ];
        }

        $response['count'] = count($favoritos);

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
            return 'Interação registrada com sucesso';
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
        $numReviews = count($profile->getAvaliacoes()->all());
        $numJogos = count($profile->getInteracoes()->where(['isJogado' => 1])->all());
        $numFavoritos = count($profile->getInteracoes()->where(['isFavorito' => 1])->all());
        $numDesejados = count($profile->getInteracoes()->where(['isDesejado' => 1])->all());
        $numSeguidores = count($profile->getSeguidores()->all());
        $numSeguir = count($profile->getSeguidos()->all());

        // Devido á sobrecraga de trabalho não será possível implementar a funcionaldade realmente por ordem de recentes

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
                'capa' => Yii::getAlias('@mobileIp') . Yii::getAlias('@capasJogoUrl') . '/'. Jogo::findOne($idJogo)->imagemCapa
            ];
        }



        return[
            'username' => $user->username,
            'email' => $user->email,
            'nome' => $profile->nome,
            'dataNascimento' => $profile->dataNascimento,
            'biografia' => $profile->biografia,
            'fotoCapa' => Yii::getAlias('@mobileIp') . $profile->getFotoCapa(),
            'fotoPerfil' => Yii::getAlias('@mobileIp') . $profile->getFotoPerfil(),
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
