<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use common\models\Denuncia;
use backend\models\DenunciaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DenunciaController implements the CRUD actions for Denuncia model.
 */
class DenunciaController extends Controller
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
                        'actions' => ['update','delete','view','aprovar-denuncia'],
                        'allow' => true,
                        'roles' => ['admin','moderador'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin','funcionario','moderador'],
                    ],
                ],
                'denyCallback' => function () {
                    \Yii::$app->session->setFlash('error', 'Não possui permissões suficientes para executar esta ação!');
                    $this->goHome();
                }
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Denuncia models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new DenunciaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
        }

    }

    public function actionView($denunciante_id, $denunciado_id)
    {
        if(Yii::$app->user->can('verDetalhesDenuncias')) {
            return $this->render('view', [
                'model' => $this->findModel($denunciante_id, $denunciado_id),
            ]);
        }else{
            return $this->goHome();
        }
    }


    /**
     * Updates an existing Denuncia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $denunciante_id Denunciante ID
     * @param int $denunciado_id Denunciado ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($denunciante_id, $denunciado_id)
    {
        if (Yii::$app->user->can('editarDenuncias')) {
            $model = $this->findModel($denunciante_id, $denunciado_id);

            if(!$model->estado == Denuncia::STATUS_PROCESSING){
                \Yii::$app->session->setFlash('error', 'O processamento desta denúncia já foi efetuado!');
                return $this->redirect(['index']);
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'denunciante_id' => $model->denunciante_id, 'denunciado_id' => $model->denunciado_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }
    }

    public function actionAprovarDenuncia($denunciante_id, $denunciado_id, $aprovado)
    {

        if (Yii::$app->user->can('alterarEstadoDenuncia')) {
            $model = $this->findModel($denunciante_id, $denunciado_id);

            if(!$model->estado == Denuncia::STATUS_PROCESSING){
                \Yii::$app->session->setFlash('error', 'O processamento desta denúncia já foi efetuado!');
                return $this->redirect(['index']);
            }

            try {
                if($aprovado == 1){
                    $model->estado = Denuncia::STATUS_BANNED;
                    $user = User::findOne($denunciado_id);
                    if($user){
                        $user->status = User::STATUS_DELETED;
                    }

                    if($model->save() && $user->save()){
                        \Yii::$app->session->setFlash('sucess', 'Utilizador banido com sucesso!');
                    }
                    else{
                        \Yii::$app->session->setFlash('error', 'Erro ao banir utilizador!');
                        return $this->redirect(['index']);
                    }

                    return $this->redirect(['index']);
                }elseif($aprovado == 0){
                    $model->estado = Denuncia::STATUS_REFUSED;
                    if($model->save()){
                        \Yii::$app->session->setFlash('sucess', 'Denuncia removida com sucesso!');
                    }else{
                        \Yii::$app->session->setFlash('error', 'Erro ao remover denuncia!');
                    }
                }else{
                    \Yii::$app->session->setFlash('error', 'Erro ao aprovar denuncia!');
                    return $this->redirect(['index']);
                }
            }catch (\Exception $e) {
                \Yii::$app->session->setFlash('error', 'Erro ao aprovar denuncia!');
            }


            return $this->redirect(['index']);
        }else{


        }
    }

    /**
     * Deletes an existing Denuncia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $denunciante_id Denunciante ID
     * @param int $denunciado_id Denunciado ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($denunciante_id, $denunciado_id)
    {
        try {
            if (Yii::$app->user->can('apagarDenuncias')) {

                $this->findModel($denunciante_id, $denunciado_id)->delete();

                return $this->redirect(['index']);
            }else{
                return $this->goHome();
            }
        }catch (\Exception $e) {
            \Yii::$app->session->setFlash('error', 'Erro ao apagar denuncia!');
        }


    }

    /**
     * Finds the Denuncia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $denunciante_id Denunciante ID
     * @param int $denunciado_id Denunciado ID
     * @return Denuncia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($denunciante_id, $denunciado_id)
    {
        if (($model = Denuncia::findOne(['denunciante_id' => $denunciante_id, 'denunciado_id' => $denunciado_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
