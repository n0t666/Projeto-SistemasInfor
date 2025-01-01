<?php

namespace backend\controllers;

use backend\models\JogoSearch;
use backend\models\SignupForm;
use backend\models\UserSearch;
use common\models\Userdata;
use PhpParser\Node\Stmt\Foreach_;
use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['update','delete','view'],
                        'allow' => true,
                        'roles' => ['moderador'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('verTudo')){
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('verDetalhesUtilizadores')){
            return $this->render('view', [
                'model' => $this->findModel($id),
                'userData' => Userdata::findOne($id),
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Registration successful. Please check your email for verification.');
            return $this->redirect(['index']);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->can('editarDetalhesUtilizadores')){
            $user = $this->findModel($id);
            $model = new SignupForm();
            $model->username = $user->username;
            $model->email = $user->email;
            $model->nif = $user->profile->nif;
            $model->nome = $user->profile->nome;
            $model->status = $user->status;
            $auth = Yii::$app->authManager;

            $roles = $auth->getRolesByUser($user->id); // Obter em formato de array

            if($roles){ //Necessário de obter de facto o nome do role do utilizador
                $role = reset($roles); // Obter a primeira role, visto que neste caso o sistem só permite 1 role por utilizador
                $model->role = $role->name;
            }


            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try{

                    if ($model->password) {
                        $user->setPassword($model->password);
                    }

                    if ($model->username !== $user->username) {
                        if (User::findOne(['username' => $model->username])) {
                            $model->addError('username', 'Este username já foi usado.');
                            return false;
                        }
                        $user->username = $model->username;
                    }

                    if ($model->email !== $user->email) {
                        if (User::findOne(['email' => $model->email])) {
                            $model->addError('email', 'Este email já foi usado.');
                            return false;
                        }
                        $user->email = $model->email;
                    }

                    if($model->status !== $user->status){
                        $user->status = $model->status;
                    }

                    $user->save(false);

                    if (!empty($model->role)) {
                        $auth->revokeAll($user->id);
                        $role = $auth->getRole($model->role);
                        $auth->assign($role, $user->id);
                    }

                    $profile = $user->profile;
                    $profile->nome = $model->nome;

                    if ($profile->nif !== $model->nif) {
                        if (Userdata::findOne(['nif' => $model->nif])) {
                            $model->addError('email', 'Este NIF já foi usado.');
                            return false;
                        }
                        $profile->nif = $model->nif;
                    }

                    $profile->save(false);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Utilizador atualizado com sucesso!.');
                    return $this->redirect(['index']);
                }catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Falha ao atualizar dados!.');
                }
            }

            return $this->render('update', [
                'model' => $model,
                'userId' => $user->id,
            ]);
        }else{
            return $this->goHome();
        }

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('banirUtilizador')){
            $user = $this->findModel($id);
            if($user) {
                if($user->status == User::STATUS_DELETED){
                    Yii::$app->session->setFlash('error', 'Utilizador já se encontra apagado.');
                    return $this->goBack(Yii::$app->request->referrer);
                }
                $user->status = User::STATUS_DELETED;
                $user->save(false);
                Yii::$app->session->setFlash('success', 'Utilizador apagado com sucesso.');
            }
            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
