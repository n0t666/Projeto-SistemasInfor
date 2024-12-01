<?php

namespace frontend\controllers;

use backend\controllers\UserController;
use common\models\Avaliacao;
use common\models\Carrinho;
use common\models\Comentario;
use common\models\LinhaCarrinho;
use common\models\UtilizadorJogo;
use Yii;
use common\models\Jogo;
use frontend\models\JogoSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JogoController implements the CRUD actions for Jogo model.
 */
class JogoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Jogo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $jogos = Jogo::find()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Jogo::find(),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $jogo = $this->findModel($id);
        $produtos = $jogo->produtos;
        $itemCarrinho = new LinhaCarrinho();
        $utilizadorId = Yii::$app->user->id;
        $review = null;

        if($utilizadorId){
            $review = Comentario::find()->where(['jogo_id' => $jogo->id, 'utilizador_id' => $utilizadorId])->one();
            if(!$review){
                $review = new Comentario();
                $review->jogo_id = $jogo->id;
            }
        }


        $reviewsFriends = null;

        $reviewsRecentes = new ActiveDataProvider([
            'query' => ComentarioController::filterQuery($jogo->id,'recent'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        if($utilizadorId){
            $mutuals = UtilizadorController::getMutuals($utilizadorId);
            if(count($mutuals) > 0){
                $reviewsFriends = new ActiveDataProvider([
                    'query' => ComentarioController::filterQuery($jogo->id,'friends'),
                    'pagination' => [
                        'pageSize' => 5,
                    ]
                ]);
            }
        }

        $reviewsPopular = new ActiveDataProvider([
            'query' =>  ComentarioController::filterQuery($jogo->id,'popular'),
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);


        $interaction = UtilizadorJogo::find()
            ->where(['jogo_id' => $jogo->id, 'utilizador_id' => Yii::$app->user->id])
            ->one();

        $avaliacao = Avaliacao::find()
            ->where(['jogo_id' => $jogo->id, 'utilizador_id' => Yii::$app->user->id])
            ->one();


        if(!$avaliacao){
            $avaliacao = new Avaliacao();
            $avaliacao->jogo_id = $jogo->id;
            $avaliacao->utilizador_id = Yii::$app->user->id;
        }

        $avaliacaoInfo =  Avaliacao::find()
            ->select(['numEstrelas', 'COUNT(*) as numPessoas'])
            ->where(['jogo_id' => $jogo->id])
            ->groupBy('numEstrelas') //Agrupar pelo número de estrela ex: 0.5, 1 etc...
            ->orderBy('numEstrelas ASC')
            ->asArray() // Facilitar para depois simplesmente igualar ao array, pois o gráfico espera um tipo de dados do tipo array
            ->all();


        /*
         *  Preparar array para o grafico (eixo x e y)
         */
        $estrelas = []; //Eixo x será o número de estrelas feitas por todos os utilizadores
        $numeroPessoas =[]; //Eixo y será o número de pessoas que deram esse mesmo números de estrelas
        foreach ($avaliacaoInfo as $aval) {
            $estrelas[] = (float)$aval['numEstrelas'];
            $numeroPessoas[] = (int)$aval['numPessoas'];
        }

        return $this->render('view', [
            'model' => $jogo,
            'interaction' => $interaction,
            'avaliacao' => $avaliacao,
            'produtos' => $produtos,
            'itemCarrinho' => $itemCarrinho,
            'review' => $review,
            'estrelas' => $estrelas,
            'numeroPessoas' => $numeroPessoas,
            'reviewsFriends' => $reviewsFriends,
            'reviewsRecentes' => $reviewsRecentes,
            'reviewsPopular' => $reviewsPopular,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Jogo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
