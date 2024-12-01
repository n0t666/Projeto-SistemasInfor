<?php

namespace frontend\controllers;

use common\models\Chave;
use common\models\Produto;
use common\models\User;
use common\models\Userdata;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UtilizadorController extends Controller
{
    public function actionProfile($username){
        $user = User::find()->where(['username' => $username])->one();
        $isBlockedByCurrentUser = false;
        $isCurrentUserBlocked = false;


        if(!Yii::$app->user->isGuest){

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

            if($isBlockedByCurrentUser){
               throw new NotFoundHttpException();
           }
        }


        if(!$user){
            throw new NotFoundHttpException();
        }

        return $this->render('profile', [
            'user' => $user,
            'isBlocked' => $isCurrentUserBlocked,
        ]);
    }



    public static function getMutuals($userId)
    {
        $user = Userdata::findOne($userId);

        if(!$user){
            return [];
        }

        $mutuals = Userdata::find()
            ->joinWith(['seguidores f', 'seguidos s'])
            ->where(['f.id' => $userId])
            ->andWhere(['s.id' => $userId])
            ->all();


        return $mutuals;
    }

    public static function isMutualFollow($userId1,$userId2)
    {
        $user2 =Userdata::find()
            ->where(['id' => $userId1])
            ->andWhere(['exists' => Userdata::find()->where(['seguidor_id' => $userId1, 'seguido_id' => $userId2])])
            ->exists();
        $user1 =  Userdata::find()
            ->where(['id' => $userId2])
            ->andWhere(['exists' => Userdata::find()->where(['seguidor_id' => $userId2, 'seguido_id' => $userId1])])
            ->exists(); // Para devolvoer boolean

        return $user2 && $user1; // Devolver valor lógico ou seja só será true se as duas queries acima encontrarem algo
    }

    public function actionBlock()
    {
        try {

            if (Yii::$app->request->isPost) {

                $target= Yii::$app->request->post('userId');
                if(!$target){
                    throw new NotFoundHttpException();
                }
                $target = User::findOne($target);

                if(!$target){
                    throw new NotFoundHttpException();
                }

                if(Yii::$app->user->isGuest){
                    throw new NotFoundHttpException();
                }

                $blockExistente = $target->profile
                    ->find()
                    ->joinWith(['utilizadorBloqueios b'])
                    ->andWhere(['b.id' => Yii::$app->user->identity->id])
                    ->exists();

                if(!$blockExistente){
                    Yii::$app->user->identity->profile->link('utilizadorBloqueados', $target);
                    Yii::$app->session->setFlash('success', 'Utilizador bloqueado com sucesso');
                }else{
                    Yii::$app->session->setFlash('error', 'Erro ao bloquear o utilizador');
                }

                return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));

            }

        }catch (\Exception  $e) {
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

            $target= Yii::$app->request->post('userId');
            if(!$target){
                throw new NotFoundHttpException();
            }
            $target = User::findOne($target);

            if(!$target){
                throw new NotFoundHttpException();
            }

            if(Yii::$app->user->isGuest){
                throw new NotFoundHttpException();
            }

            $blockExistente = $target->profile
                ->find()
                ->joinWith(['utilizadorBloqueios b'])
                ->andWhere(['b.id' => Yii::$app->user->identity->id])
                ->exists();

            if($blockExistente){
                Yii::$app->user->identity->profile->unlink('utilizadorBloqueados', $target,true);
                Yii::$app->session->setFlash('success', 'Utilizador desbloqueado com sucesso');
            }else{
                Yii::$app->session->setFlash('error', 'Erro ao desbloquear o utilizador');
            }

            return $this->redirect(Url::to(['profile', 'username' => Yii::$app->user->identity->username]));


        }catch (\Exception  $e) {
            var_dump($e->getMessage());
            exit();
            throw new ServerErrorHttpException($e->getMessage());
        }

        return $this->goHome();

    }

}