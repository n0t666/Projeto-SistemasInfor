<?php

namespace frontend\controllers;

use common\models\Jogo;
use Yii;
use common\models\UtilizadorJogo;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UtilizadorJogoController implements the CRUD actions for UtilizadorJogo model.
 */
class UtilizadorJogoController extends Controller
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
                        'actions' => ['update'],
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


    public function actionUpdate()
    {
        if (Yii::$app->request->isPost) {
            try {
                $idJogo = Yii::$app->request->post('Jogo')['id'];
                $tipo = Yii::$app->request->post('action');

                $jogo = Jogo::findOne($idJogo);

                if ($jogo === null) {
                    throw new NotFoundHttpException('O jogo não existe.');
                }

                $user = Yii::$app->user->identity->id;
                $userJogo = $jogo->getUtilizadoresjogos()->where(['utilizador_id' => $user])->one();

                if (!$userJogo) { // Caso o utilizador não tenha feito qualquer tipo de interação com o jogo, criar uma nova
                    $userJogo = new UtilizadorJogo();
                    $userJogo->utilizador_id = $user;
                    $userJogo->jogo_id = $idJogo;
                }

                // Sempre colocar o oposto, ou seja, se já estiver como favorito, remover dos favoritos
                switch ($tipo) {
                    case '1': // Favorito
                        $userJogo->isFavorito = $userJogo->isFavorito ? 0 : 1;
                        break;
                    case '2': // Jogado
                        $userJogo->isJogado = $userJogo->isJogado ? 0 : 1;
                        break;
                    case '3': // Desejado
                        $userJogo->isDesejado = $userJogo->isDesejado ? 0 : 1;
                        break;
                    default:
                        Yii::$app->session->setFlash('error', 'Ação inválida.');
                        return $this->redirect(['jogo/view', 'id' => $jogo->id]);
                }

                if ($userJogo->save()) {
                    Yii::$app->session->setFlash('success', 'Estado do jogo atualizado com sucesso.');
                } else {
                    throw new \Exception('Falha ao guardar o estado do jogo.');
                }

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao atualizar o estado do jogo.');
            }
        }

        return $this->redirect(['jogo/index']);
    }



}
