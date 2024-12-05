<?php

namespace frontend\controllers;

use common\models\Chave;
use common\models\Denuncia;
use common\models\Produto;
use common\models\UploadForm;
use common\models\User;
use common\models\Userdata;
use frontend\models\UpdateForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use function PHPUnit\Framework\exactly;

class UtilizadorController extends Controller
{
    public function actionProfile($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        $isBlockedByCurrentUser = false;
        $isCurrentUserBlocked = false;

        $denuncia = null;
        $isFollowing = false;


        if (!Yii::$app->user->isGuest) {

            if (Denuncia::find()->where(['denunciante_id' => Yii::$app->user->identity->id, 'denunciado_id' => $user->id])->exists()) {
                $denuncia = Denuncia::find()->where(['denunciante_id' => Yii::$app->user->identity->id, 'denunciado_id' => $user->id])->one();
            } else {
                $denuncia = new Denuncia();
                $denuncia->denunciante_id = Yii::$app->user->identity->id;
                $denuncia->denunciado_id = $user->id;
            }

            $isCurrentUserBlocked = $user->profile
                ->find()
                ->joinWith(['utilizadorBloqueios  b'])
                ->andWhere(['b.id' => Yii::$app->user->identity->id])
                ->exists();

            $isBlockedByCurrentUser = $user->profile
                ->find()
                ->joinWith(['utilizadorBloqueados b'])
                ->andWhere(['b.id' => Yii::$app->user->identity->id])
                ->exists();

            if ($isBlockedByCurrentUser) {
                throw new NotFoundHttpException();
            }

            $isFollowing = $user->profile
                ->find()
                ->joinWith(['seguidores s'])
                ->andWhere(['s.id' => Yii::$app->user->identity->id])
                ->exists();
        }


        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $this->render('profile', [
            'user' => $user,
            'isBlocked' => $isCurrentUserBlocked,
            'denuncia' => $denuncia,
            'isFollowing' => $isFollowing,
        ]);
    }


    public static function getMutuals($userId)
    {
        $user = Userdata::findOne($userId);

        if (!$user) {
            return [];
        }

        $mutuals = Userdata::find()
            ->joinWith(['seguidores f', 'seguidos s'])
            ->where(['f.id' => $userId])
            ->andWhere(['s.id' => $userId])
            ->all();


        return $mutuals;
    }

    public static function isMutualFollow($userId1, $userId2)
    {
        $user2 = Userdata::find()
            ->where(['id' => $userId1])
            ->andWhere(['exists' => Userdata::find()->where(['seguidor_id' => $userId1, 'seguido_id' => $userId2])])
            ->exists();
        $user1 = Userdata::find()
            ->where(['id' => $userId2])
            ->andWhere(['exists' => Userdata::find()->where(['seguidor_id' => $userId2, 'seguido_id' => $userId1])])
            ->exists(); // Para devolvoer boolean

        return $user2 && $user1; // Devolver valor lógico ou seja só será true se as duas queries acima encontrarem algo
    }

    public function actionBlock()
    {
        try {

            if (Yii::$app->request->isPost) {

                $target = Yii::$app->request->post('userId');
                if (!$target) {
                    throw new NotFoundHttpException();
                }
                $target = User::findOne($target);

                if (!$target) {
                    throw new NotFoundHttpException();
                }

                if (Yii::$app->user->isGuest) {
                    throw new NotFoundHttpException();
                }

                if ($target->id == Yii::$app->user->identity->id) {
                    throw new NotFoundHttpException();
                }

                $blockExistente = $target->profile
                    ->find()
                    ->joinWith(['utilizadorBloqueios b'])
                    ->andWhere(['b.id' => Yii::$app->user->identity->id])
                    ->exists();

                if (!$blockExistente) {
                    Yii::$app->user->identity->profile->link('utilizadorBloqueados', $target);
                    Yii::$app->session->setFlash('success', 'Utilizador bloqueado com sucesso');
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao bloquear o utilizador');
                }

                return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));

            }

        } catch (\Exception  $e) {
            var_dump($e->getMessage());
            exit();
            Yii::$app->session->setFlash('error', 'Erro ao bloquear o utilizador');
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->goHome();

    }

    public function actionUnblock()
    {
        try {

            $target = Yii::$app->request->post('userId');
            if (!$target) {
                throw new NotFoundHttpException();
            }
            $target = User::findOne($target);

            if (!$target) {
                throw new NotFoundHttpException();
            }

            if (Yii::$app->user->isGuest) {
                throw new NotFoundHttpException();
            }

            if ($target->id == Yii::$app->user->identity->id) {
                throw new NotFoundHttpException();
            }

            $blockExistente = $target->profile
                ->find()
                ->joinWith(['utilizadorBloqueios b'])
                ->andWhere(['b.id' => Yii::$app->user->identity->id])
                ->exists();

            if ($blockExistente) {
                Yii::$app->user->identity->profile->unlink('utilizadorBloqueados', $target, true);
                Yii::$app->session->setFlash('success', 'Utilizador desbloqueado com sucesso');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao desbloquear o utilizador');
            }

            return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));


        } catch (\Exception  $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }

    }

    public function actionFollow()
    {
        try {
            $target = Yii::$app->request->post('userId');
            if (!$target) {
                throw new NotFoundHttpException();
            }
            $target = User::findOne($target);
            if (!$target) {
                throw new NotFoundHttpException();
            }
            if (Yii::$app->user->isGuest) {
                throw new NotFoundHttpException();
            }
            if ($target->id == Yii::$app->user->identity->id) {
                throw new NotFoundHttpException();
            }
            $followExistente = $target->profile
                ->find()
                ->joinWith(['seguidores s'])
                ->andWhere(['s.id' => Yii::$app->user->identity->id])
                ->exists();

            if (!$followExistente) {
                Yii::$app->user->identity->profile->link('seguidos', $target);
                Yii::$app->session->setFlash('success', 'Utilizador seguido com sucesso');
                return $this->goBack(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao seguir o utilizador');
                return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));
            }
        } catch (\Exception  $e) {
            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    public function actionUnfollow()
    {
        try {
            $target = Yii::$app->request->post('userId');
            if (!$target) {
                throw new NotFoundHttpException();
            }
            $target = User::findOne($target);
            if (!$target) {
                throw new NotFoundHttpException();
            }
            if (Yii::$app->user->isGuest) {
                throw new NotFoundHttpException();
            }
            if ($target->id == Yii::$app->user->identity->id){
                throw new NotFoundHttpException();
            }

            $followExistente = $target->profile
                ->find()
                ->joinWith(['seguidores s'])
                ->andWhere(['s.id' => Yii::$app->user->identity->id])
                ->exists();
            if ($followExistente) {
                Yii::$app->user->identity->profile->unlink('seguidos', $target, true);
                Yii::$app->session->setFlash('success', 'Utilizador deixado de seguir com sucesso');
                return $this->goBack(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('error', 'Erro ao deixar de seguir o utilizador');
                return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));
            }
        }catch (\Exception  $e) {

            throw new ServerErrorHttpException($e->getMessage());
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }

        $user = Yii::$app->user->identity;
        $profile = $user->profile;

        $model = new UpdateForm();

        $model->id = $user->id;
        $model->username = $user->username;
        $model->email = $user->email;
        $model->nif = $profile->nif;
        $model->nome = $profile->nome;
        $model->dataNascimento = $profile->dataNascimento;
        $model->biografia = $profile->biografia;
        $model->privacidadeSeguidores = $profile->privacidadeSeguidores;
        $model->privacidadeFavoritos = $profile->privacidadeFavoritos;
        $model->privacidadeJogos = $profile->privacidadeJogos;

        if ($model->load(Yii::$app->request->post())) {
            $model->profileImageFile = UploadedFile::getInstance($model, 'profileImageFile');
            $model->bannerImageFile = UploadedFile::getInstance($model, 'bannerImageFile');
            if ($model->edit()) {
                Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso!');
                return $this->redirect(['utilizador/update']);
            }
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionFollowers($username)
    {
        $user = User::find()->where(['username' => $username])->one();

        if (!$user) {
            throw new NotFoundHttpException();
        }
        $followers = $user->profile->getSeguidores()
            ->where(['!=', 'id', Yii::$app->user->identity->id])
            ->all();
        $followingStatus = [];

        if (!Yii::$app->user->isGuest) {
            $loggedInUser = Yii::$app->user->identity->profile;

            foreach ($followers as $follower) {
                $followingStatus[$follower->id] = $loggedInUser->getSeguidos()->where(['id' => $follower->id])->exists();
            }
        }

        return $this->render('followers', [
            'followers' => $followers,
            'user' => $user,
            'followingStatus' => $followingStatus,

        ]);


    }

    public function actionFollowing($username)
    {
        $user = User::find()->where(['username' => $username])->one();

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $followings = $user->profile->getSeguidos()
            ->where(['!=', 'id', Yii::$app->user->identity->id]) // Excluir o própio utilizador
            ->all();
        $followingStatus = [];

        if (!Yii::$app->user->isGuest) {
            $loggedInUser = Yii::$app->user->identity->profile;

            foreach ($followings as $following) {
                $followingStatus[$following->id] = $loggedInUser->getSeguidos()->where(['id' => $following->id])->exists();
            }
        }

        return $this->render('following', [
            'followings' => $followings,
            'user' => $user,
            'followingStatus' => $followingStatus,
        ]);
    }

}