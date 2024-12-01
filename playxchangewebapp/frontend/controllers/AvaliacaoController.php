<?php

namespace frontend\controllers;

use common\models\Comentario;
use common\models\Jogo;
use Yii;
use common\models\Avaliacao;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\throwException;



/**
 * AvaliacaoController implements the CRUD actions for Avaliacao model.
 */
class AvaliacaoController extends Controller
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
                        'actions' => ['avaliar'],
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

    public function actionAvaliar()
    {
        if (Yii::$app->user->can('avaliarJogo')) {
            try {
                $jogoId = Yii::$app->request->post('Avaliacao')['jogo_id'];
                $userId = Yii::$app->user->id;

                if (!$jogoId || !$userId) {
                    throw new NotAcceptableHttpException();
                }



                $jogo = Jogo::findOne($jogoId);
                if (!$jogo) {
                    throw new NotFoundHttpException('Jogo não encontrado.');
                }


                $avaliacao = Avaliacao::findOne([
                    'jogo_id' => $jogoId,
                    'utilizador_id' => $userId
                ]);

                if (Yii::$app->request->isPost) {
                    $numEstrelas = Yii::$app->request->post('Avaliacao')['numEstrelas'];


                    if (!$avaliacao) {
                        if (!$numEstrelas || $numEstrelas < 0.5) {
                            Yii::$app->session->setFlash('error', 'Avaliação não válida. O número de estrelas deve ser maior ou igual a 0.5.');
                            return $this->goBack();
                        }

                        $avaliacao = new Avaliacao();
                        $avaliacao->jogo_id = $jogoId;
                        $avaliacao->utilizador_id = $userId;
                        $avaliacao->numEstrelas = $numEstrelas;

                        if ($avaliacao->save()) {
                            Yii::$app->session->setFlash('success', 'Avaliação criada com sucesso!');
                        } else {
                            throw new \Exception('Falha ao criar avaliação.');
                        }
                    } else {
                        if ($numEstrelas > 0) {
                            if ($numEstrelas != $avaliacao->numEstrelas) {
                                $avaliacao->numEstrelas = $numEstrelas;
                                if ($avaliacao->save()) {
                                    Yii::$app->session->setFlash('success', 'Avaliação atualizada com sucesso!');
                                } else {
                                    throw new \Exception('Falha ao atualizar a avaliação.');
                                }
                            } else {
                                Yii::$app->session->setFlash('info', 'A avaliação já estava com o mesmo valor.');
                            }
                        } elseif ($numEstrelas == '') {
                            if(Comentario::find()->where(['jogo_id' => $jogoId, 'utilizador_id' => $userId])->exists()){
                                Yii::$app->session->setFlash('error', 'Não é possível remover estrelas em jogos que existam atividade.');
                                return $this->redirect(['jogo/view', 'id' => $jogo->id]);
                            }
                            if ($avaliacao->delete()) {
                                Yii::$app->session->setFlash('success', 'Avaliação removida com sucesso!');
                            } else {
                                throw new \Exception('Falha ao remover a avaliação.');
                            }
                        }
                    }

                    return $this->redirect(['jogo/view', 'id' => $jogoId]);
                }

            } catch (\Exception $e) {
                var_dump($e->getMessage());
                exit();
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao processar a avaliação.');
                return $this->goBack();
            }
        }

        return $this->goHome();
    }




    /**
     * Finds the Avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $utilizador_id Utilizador
     * @param int $jogo_id Jogo
     * @return Avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($utilizador_id, $jogo_id)
    {
        if (($model = Avaliacao::findOne(['utilizador_id' => $utilizador_id, 'jogo_id' => $jogo_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
