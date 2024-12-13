<?php

namespace frontend\controllers;

use backend\controllers\UserController;
use common\models\Avaliacao;
use common\models\GostoComentario;
use common\models\Jogo;
use Yii;
use common\models\Comentario;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * ComentarioController implements the CRUD actions for Comentario model.
 */
class ComentarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'update','delete','index'],
                        'allow' => true,
                        'roles' => ['cliente'],
                    ],
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

    public function actionIndex($jogoId, $filtro='')
    {
        $jogo = Jogo::findOne($jogoId);

        if(!$jogo){
            throw new NotFoundHttpException();
        }

        $reviews = new ActiveDataProvider([
            'query' => self::filterQuery($jogo->id,$filtro),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);



        return $this->render('index', [
            'reviews' => $reviews,
            'jogo' => $jogo,
        ]);

    }

    /**
     * Creates a new Comentario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comentario();
        $userId = Yii::$app->user->id;

        if (!$userId) {
            throw new NotAcceptableHttpException();
        }
        try{
            if (Yii::$app->request->isPost) {
                if ($model->load(Yii::$app->request->post())) {
                    $jogo = Yii::$app->request->post('Comentario')['jogo_id'];
                    if (Jogo::find()->where(['id' => $jogo])->exists()) {
                        if (Comentario::find()->where(['jogo_id' => $jogo, 'utilizador_id' => $userId])->exists()) {
                            Yii::$app->session->setFlash('error', 'Já foi efetuada uma avaliação para este jogo');
                            return $this->redirect(['jogo/view', 'id' => $model->jogo_id]);
                        }
                        if (!Avaliacao::find()->where(['utilizador_id' => $userId, 'jogo_id' => $jogo])->exists()) {
                            Yii::$app->session->setFlash('error', 'É necessário de avaliar um jogo antes de comentar.');
                            return $this->redirect(['jogo/view', 'id' => $model->jogo_id]);
                        }
                            $model->utilizador_id = $userId;
                            if($model->save()){
                                $gosto = new GostoComentario();
                                $gosto->utilizador_id = $userId;
                                $gosto->comentario_id = $model->id;
                                $gosto->save();
                                return $this->redirect(['jogo/view', 'id' => $model->jogo_id]);
                            }
                    } else {
                        Yii::$app->session->setFlash('error', 'Não foi possível encontrar o jogo especificado');
                        return $this->goBack();
                    }
                }
            } else {
                throw new ServerErrorHttpException();
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao guardar o comentário');
            return $this->goBack();
        }
        return $this->goBack();
    }

    /**
     * Updates an existing Comentario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(yii::$app->user->id != $model->utilizador_id){
            throw new NotAcceptableHttpException();
        }

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['jogo/view', 'id' => $model->jogo_id]);
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao tentar editar o comentário.');
            return $this->redirect(['jogo/view', 'id' => $model->jogo_id]);
        }

        return $this->redirect(['jogo/index']);
    }

    /**
     * Deletes an existing Comentario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model && $model->utilizador_id == Yii::$app->user->id) {
            try {
                $jogo = $model->jogo_id;
                $model->delete();
            }catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao tentar apagar o comentario.');
                return $this->redirect(['jogo/view', 'id' => $jogo]);
            }
            return $this->redirect(['jogo/view', 'id' => $jogo]);
        }

        return $this->redirect(['jogo/index']);
    }

    public static function filterQuery($jogoId,$filtro)
    {
        $query = null;
        $utilizadorId = Yii::$app->user->id;
        $jogo = Jogo::findOne($jogoId);

        if(!$jogo){
            throw new NotFoundHttpException();
        }

        switch ($filtro) {
            case 'recent':
                $query = $jogo->getComentarios()->orderBy(['dataComentario' => SORT_DESC]);
                break;
            case 'friends':
                if($utilizadorId){
                    $mutuals = UtilizadorController::getMutuals($utilizadorId);
                    $query = Comentario::find()
                        ->where(['jogo_id' => $jogoId])
                        ->andWhere(['utilizador_id' => $mutuals])
                        ->orderBy(['dataComentario' => SORT_DESC]);
                }
                break;
            case 'popular':
                $query = Comentario::find()
                    ->joinWith('gostoscomentarios')
                    ->where(['comentarios.jogo_id' => $jogoId])
                    ->groupBy('comentarios.id')
                    ->orderBy(['COUNT(gostoscomentarios.comentario_id)' => SORT_DESC]);
                break;
            default:
                $query = $jogo->getComentarios();
        }

        return $query;
    }

    public static function isLikedByCurrentUser($id)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return GostoComentario::find()
            ->where(['utilizador_id' => Yii::$app->user->id, 'comentario_id' => $id])
            ->exists();
    }


    /**
     * Finds the Comentario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comentario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
