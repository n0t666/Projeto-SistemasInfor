<?php

namespace frontend\controllers;

use common\models\Avaliacao;
use common\models\Carrinho;
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



        return $this->render('view', [
            'model' => $jogo,
            'interaction' => $interaction,
            'avaliacao' => $avaliacao,
            'produtos' => $produtos,
            'itemCarrinho' => $itemCarrinho
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
