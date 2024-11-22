<?php

namespace frontend\controllers;

use common\models\Jogo;
use Yii;
use common\models\Avaliacao;
use yii\data\ActiveDataProvider;
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAvaliar()
    {
        $jogoId = Yii::$app->request->post('Avaliacao')['jogo_id'];
        $userId = Yii::$app->user->id;

        $jogo = Jogo::findOne($jogoId);

        if(!$jogoId || !$userId){
            throw  new NotAcceptableHttpException();
        }

        $avaliacao = Avaliacao::findOne([
            'jogo_id' => $jogoId,
            'utilizador_id' => $userId
        ]);




        if (Yii::$app->request->isPost) {
            $numEstrelas = Yii::$app->request->post('Avaliacao')['numEstrelas'];
            if (!$avaliacao) {
                if (!$numEstrelas || $numEstrelas < 0.5) {

                    Yii::$app->session->setFlash('error', 'Avaliação não válida. O número de estrelas deve ser maior ou igual a 0.5');
                    return $this->goBack();
                }
                $avaliacao = new Avaliacao();
                $avaliacao->jogo_id = $jogoId;
                $avaliacao->utilizador_id = Yii::$app->user->id;
                $avaliacao->numEstrelas = $numEstrelas;

                if ($avaliacao->save()) {
                    Yii::$app->session->setFlash('success', 'Avaliação criada com sucesso!');
                } else {
                    Yii::error($avaliacao->errors);  // Log errors for debugging
                    // Optionally, print errors in your view for better visibility
                    var_dump($avaliacao->errors);
                    die();
                }
            }else{
                if($numEstrelas > 0){
                    if($numEstrelas != $avaliacao->numEstrelas){
                        $avaliacao->numEstrelas = $numEstrelas;
                        if($avaliacao->save()){
                            Yii::$app->session->setFlash('success', 'Avaliação atualizada com sucesso!');
                        }else{
                            Yii::$app->session->setFlash('error', 'Falha ao atualizar a avaliação.');
                        }
                    }else{
                        Yii::$app->session->setFlash('success', 'Avaliação atualizada com sucesso!');
                    }
                }elseif ($numEstrelas == ''){
                    if ($avaliacao->delete()) {
                        Yii::$app->session->setFlash('success', 'Avaliação removida com sucesso!');
                    } else {
                        Yii::$app->session->setFlash('error', 'Falha ao remover a avaliação.');
                    }
                }
            }
            return $this->redirect(['jogo/view', 'id' => $jogoId]);
        }

        return $this->redirect(['jogo/index']);
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
