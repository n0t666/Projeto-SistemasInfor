<?php

namespace frontend\controllers;

use common\models\Chave;
use common\models\Denuncia;
use common\models\Produto;
use common\models\UploadForm;
use common\models\User;
use common\models\Userdata;
use common\models\UtilizadorJogo;
use frontend\models\UpdateForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;
use function PHPUnit\Framework\exactly;

class UtilizadorController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['block', 'unblock', 'follow', 'unfollow', 'update','delete'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
                    [
                        'actions' => ['profile', 'followers', 'following', 'jogados', 'desejados', 'favoritos'],
                        'allow' => true,
                        'roles' => ['cliente', '?'],
                        'matchCallback' => function ($rule, $action) {
                            $username = Yii::$app->request->get('username');
                            if (!$username) {
                                return false;
                            }

                            $user = User::find()->where(['username' => $username])->one();
                            if (!$user) {
                                return false;
                            }

                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $user->id) {
                                return true;
                            }

                            if (!Yii::$app->user->isGuest) {
                                $isBlockedByCurrentUser = $user->profile
                                    ->find()
                                    ->joinWith(['utilizadorBloqueados b'])
                                    ->andWhere(['b.id' => Yii::$app->user->identity->id])
                                    ->exists();
                                if ($isBlockedByCurrentUser) {
                                    return false;
                                }

                            }

                            $cAction = $action->id;
                            switch ($cAction) {
                                case 'followers':
                                case 'following':
                                    $status = $user->profile->privacidadeSeguidores;
                                    break;
                                case 'jogados':
                                case 'desejados':
                                case 'favoritos':
                                    $status = $user->profile->privacidadeJogos;
                                    break;
                                case 'profile':
                                    $status = $user->profile->privacidadePerfil;
                                    break;
                                default:
                                    throw new NotFoundHttpException();
                            }

                            switch ($status) {
                                case Userdata::STATUS_PUBLIC:
                                    return true;
                                case Userdata::STATUS_MUTUAL:
                                    if (!Yii::$app->user->isGuest && $this->isMutualFollow($user->id, Yii::$app->user->identity->id)) {
                                        return true;
                                    }
                                    return false;
                                default:
                                    return false;
                            }


                        }
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

            $isFollowing = $user->profile->getSeguidores()
                ->andWhere(['id' => Yii::$app->user->identity->id])
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

        // definir alias se n dá erro
        $followU2 = Userdata::find()
            ->alias('u1')
            ->joinWith('seguidos s1')
            ->where(['u1.id' => $userId1, 's1.id' => $userId2])
            ->exists();

        $followU1 = Userdata::find()
            ->alias('u2')
            ->joinWith('seguidos s2')
            ->where(['u2.id' => $userId2, 's2.id' => $userId1])
            ->exists();


        // Retorna true se ambos os utilizadores se seguirem
        return $followU2 && $followU1;
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

                return $this->goBack(Yii::$app->request->referrer);

            }

        } catch (\Exception  $e) {
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

            return $this->goBack(Yii::$app->request->referrer);


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
            $followExistente = $target->profile->getSeguidores()
                ->andWhere(['id' => Yii::$app->user->identity->id])
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
            if ($target->id == Yii::$app->user->identity->id) {
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
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao deixar de seguir o utilizador');
                return $this->goBack(Yii::$app->request->referrer);
            }
        } catch (\Exception  $e) {

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
        $model->privacidadePerfil = $profile->privacidadePerfil;
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

        $followingStatus = [];
        if (!Yii::$app->user->isGuest) {
            $loggedInUser = Yii::$app->user->identity->profile;

            $followers = $user->profile->getSeguidores()
                ->where(['!=', 'id', Yii::$app->user->identity->id])
                ->all();

            foreach ($followers as $follower) {
                $followingStatus[$follower->id] = $loggedInUser->getSeguidos()->where(['id' => $follower->id])->exists();
            }
        } else {
            $followers = $user->profile->getSeguidores()
                ->all();
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


        $followingStatus = [];

        if (!Yii::$app->user->isGuest) {
            $loggedInUser = Yii::$app->user->identity->profile;
            $followings = $user->profile->getSeguidos()
                ->where(['!=', 'id', Yii::$app->user->identity->id]) // Excluir o própio utilizador
                ->all();
            foreach ($followings as $following) {
                $followingStatus[$following->id] = $loggedInUser->getSeguidos()->where(['id' => $following->id])->exists();
            }
        } else {
            $followings = $user->profile->getSeguidos()->all();

        }

        return $this->render('following', [
            'followings' => $followings,
            'user' => $user,
            'followingStatus' => $followingStatus,
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException();
        }

        $userId = Yii::$app->user->identity->id;


        try {
            $user = User::findOne($userId);
            if (!$user) {
                throw new NotFoundHttpException();
            }
            $user->status = User::STATUS_DELETED;
            $user->save();
            Yii::$app->user->logout(true);
            Yii::$app->session->setFlash('success', 'Conta apagada com sucesso!');
            return $this->goHome();
        } catch (\Exception $e) {
            throw new ServerErrorHttpException('Ocorreu um erro inesperado');
        }
    }

    public static function getNumFavoritos($userId)
    {
        $user = User::findOne($userId);

        if (!$user) {
            return 0;
        }

        return UtilizadorJogo::find()->where(['utilizador_id' => $userId, 'isFavorito' => 1])->count();
    }

    public static function getNumJogados($userId)
    {
        $user = User::findOne($userId);
        if (!$user) {
            return 0;
        }

        return UtilizadorJogo::find()->where(['utilizador_id' => $userId, 'isJogado' => 1])->count();
    }

    public static function getNumDesejados($userId)
    {
        $user = User::findOne($userId);
        if (!$user) {
            return 0;
        }

        return UtilizadorJogo::find()->where(['utilizador_id' => $userId, 'isDesejado' => 1])->count();
    }

    public function actionJogados($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new NotFoundHttpException();
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UtilizadorJogo::find()
                ->where(['utilizador_id' => $user->id, 'isJogado' => 1])
                ->with('jogo'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('played', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDesejados($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new NotFoundHttpException();
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UtilizadorJogo::find()
                ->where(['utilizador_id' => $user->id, 'isDesejado' => 1])
                ->with('jogo'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('wishlisted', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFavoritos($username)
    {
        $user = User::find()->where(['username' => $username])->one();
        if (!$user) {
            throw new NotFoundHttpException();
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => UtilizadorJogo::find()
                ->where(['utilizador_id' => $user->id, 'isFavorito' => 1])
                ->with('jogo'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('favorites', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

}