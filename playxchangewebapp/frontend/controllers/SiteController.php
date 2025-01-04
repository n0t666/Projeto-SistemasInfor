<?php

namespace frontend\controllers;

use common\models\Faq;
use common\models\Jogo;
use common\models\User;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'layout' => 'main_without_footer'
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Jogo::find()
            ->joinWith('utilizadoresjogos u')
            ->groupBy('jogos.id')
            ->orderBy([
                'dataLancamento' => SORT_DESC,
                'COUNT(u.id)' => SORT_DESC,
            ])
            ->limit(4);

        $jogosRecentes = $query->all();

        $query = Jogo::find()
            ->joinWith('utilizadoresjogos u')
            ->groupBy('jogos.id')
            ->orderBy([
                'COUNT(CASE WHEN u.isJogado = 1 THEN 1 END)' => SORT_DESC,
                'COUNT(CASE WHEN u.isFavorito = 1 THEN 1 END)' => SORT_DESC,
            ])
            ->limit(4);

        $jogosPopulares = $query->all();


        return $this->render('index',[
            'jogosRecentes' => $jogosRecentes,
            'jogosPopulares' => $jogosPopulares,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'main_without_footer';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'main_without_footer';

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionFaq(){
        $faqs = Faq::find()->all();

        return $this->render('faq',[
            'faqs' => $faqs,
        ]);
    }


    // Não utilizei o modelo padrão de pesquisa porque os modelos não são relacionados entre e si e também para permitir a pesquisa em mais do que um modelo simultaneamnete
    public function actionSearch($category,$query)
    {

        $resultados = [];
        $dataProvider = null;

        if($query == ''){
            Yii::$app->session->setFlash('error', 'Não é possível fazer pesquisas vazias.');
            return $this->goBack();
        }

        if(strlen($query) > 200){
            Yii::$app->session->setFlash('error', 'A pesquisa não pode exceder os 200 caracteres.');
            return $this->goBack();
        }

        $authManager = Yii::$app->authManager;
        $permission = 'acederBackend';
        $backendUsers = User::getBackendUsers();


        // Colocar os dados num ActiveDataProvider para facilitar a paginação
        switch ($category) {
            case 'games':
                $dataProvider = new ActiveDataProvider([
                    'query' => Jogo::find()->where(['like', 'nome', $query]),
                    'pagination' => ['pageSize' => 10],
                ]);
                break;
            case 'users':
                $dataProvider = new ActiveDataProvider([
                    'query' => User::find()->where(['like', 'username', $query])->andWhere(['status' => 10])->andWhere(['not in', 'id', $backendUsers]),
                    'pagination' => ['pageSize' => 10],
                ]);
                break;

            case 'all':
                $jogos = Jogo::find()->where(['like', 'nome', $query])->all();
                $users = User::find()->where(['like', 'username', $query])
                    ->andWhere(['status' => 10])
                    ->andWhere(['not in', 'id', $backendUsers])
                    ->all();


                // Visto que são dois modelos distintos é preciso juntar em dois arrays para depois permitir Utilizar o arrayDataProvider visto que o activedataprovider só permite 1 modelo
                // Os dados resultantes conterão tanto jogos quanto utilizadores que correspondem ao termo de pesquisa
                $resultados = array_merge($jogos, $users);

                $dataProvider = new ArrayDataProvider([
                    'allModels' => $resultados,
                    'pagination' => ['pageSize' => 5],
                ]);
                break;
        }

        return $this->render('search_result', [
            'dataProvider' => $dataProvider,
            'category' => $category,
            'searchQuery' => $query,
        ]);
        }
}
