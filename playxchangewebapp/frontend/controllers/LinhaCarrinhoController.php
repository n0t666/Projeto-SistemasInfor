<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Jogo;
use Yii;
use common\models\LinhaCarrinho;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhaCarrinhoController implements the CRUD actions for LinhaCarrinho model.
 */
class LinhaCarrinhoController extends Controller
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
                        'actions' => ['create','update','delete'],
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

    public function actionCreate()
    {
        if (Yii::$app->user->can('adicionarItensCarrinho')) {
            $model = new LinhaCarrinho();
            $userId = Yii::$app->user->id;
            $carrinho = Carrinho::find()->where(['utilizador_id' => $userId])->one();
            if (!$userId) {
                throw new NotAcceptableHttpException();
            }
            if (!$carrinho) {
                $carrinho = new Carrinho();
                $carrinho->utilizador_id = $userId;
                if (!$carrinho->save()) {
                    Yii::$app->session->setFlash('error', 'Falha ao encontrar o carrinho.');
                    return $this->goBack();
                }
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->load(Yii::$app->request->post())) {
                    $model->carrinhos_id = $carrinho->id;
                    $model->produtos_id = Yii::$app->request->post('LinhaCarrinho')['produtos_id'];
                    $itemExistente = LinhaCarrinho::find()->where(['produtos_id' => $model->produtos_id, 'carrinhos_id' => $model->carrinhos_id])->one();


                    if ($itemExistente) {
                        Yii::$app->session->setFlash('error', 'Este produto já foi adicionado ao carrinho.');
                        return $this->goBack();
                    }

                    if (!$model->validate()) {
                        Yii::$app->session->setFlash('error', 'Falha ao validar os dados.');
                        return $this->goBack();
                    }

                    if ($model->save()) {
                        $total = $carrinho->total + ($model->quantidade * $model->produtos->preco);
                        $carrinho->total = $total;
                        $carrinho->count += $model->quantidade;
                        if ($carrinho->save()) {
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                            throw new \Exception('Falha ao atualizar o carrinho.');
                        }
                        Yii::$app->session->setFlash('success', 'Item adicionado ao carrinho com sucesso!');
                        return $this->redirect(['jogo/view', 'id' => $model->produtos->jogo->id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Falha ao adicionar o item ao carrinho.');
                        return $this->goBack();
                    }
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Ocorreu um erro inexplicado ao adicionar o item ao carrinho.');
                return $this->goBack();
            }
        }else{
            throw new ForbiddenHttpException();
        }
        return $this->goHome();
    }


    public function actionUpdate()
    {
        if (Yii::$app->user->can('editarItensCarrinho')) {
            $user = Yii::$app->user->identity->profile;
            $carrinho =  $user->carrinho;
            $quantidades = Yii::$app->request->post('quantidades');


            if (!$user|| !$carrinho || !$quantidades) {
                throw new NotAcceptableHttpException();
            }

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if($quantidades){
                    foreach ($quantidades as $produtoId => $quantidade) {
                        $linhaCarrinho = LinhaCarrinho::findOne(['produtos_id' => $produtoId, 'carrinhos_id' => $carrinho->id]);
                        if ($linhaCarrinho !== null) {
                            $linhaCarrinho->quantidade = $quantidade;
                            if (!$linhaCarrinho->save()) {
                                Yii::$app->session->setFlash('error', "Falha ao atualizar o item no carrinho");
                            }
                        }
                    }

                    $total = 0;
                    $carrinho->count = 0;
                    foreach ($carrinho->linhascarrinhos as $linha) {
                        $total += $linha->quantidade * $linha->produtos->preco;
                        $carrinho->count += $linha->quantidade;
                    }

                    $carrinho->total = $total;
                    $carrinho->save();

                    $transaction->commit();

                    Yii::$app->session->setFlash('success', 'Carrinho atualizado com sucesso!');
                }else{
                    Yii::$app->session->setFlash('error', 'Falha ao atualizar o carrinho.');
                }
            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o carrinho');
            }
        }else{
            throw new ForbiddenHttpException();
        }


        return $this->redirect(['/carrinho']);
    }

    public function actionDelete($produtoId)
    {
        if (Yii::$app->user->can('removerItensCarrinho')) {
            $user = Yii::$app->user->identity->profile;
            $carrinho =  $user->carrinho;

            if (!$user || !$carrinho) {
                throw new NotAcceptableHttpException();
            }

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $linhaCarrinho = LinhaCarrinho::findOne(['carrinhos_id' => $carrinho->id, 'produtos_id' => $produtoId]);

                if ($linhaCarrinho !== null) {
                    $carrinho->total -= ($linhaCarrinho->quantidade * $linhaCarrinho->produto->preco);
                    $carrinho->count -= $linhaCarrinho->quantidade;
                    $linhaCarrinho->delete();
                    $carrinho->save();
                    Yii::$app->session->setFlash('success', 'Produto removido do carrinho.');
                } else {
                    Yii::$app->session->setFlash('error', 'Produto não encontrado.');
                }

                $transaction->commit();

            }catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Erro ao remover o produto');
            }
        }else{
            throw new ForbiddenHttpException();
        }

        return $this->redirect(['/carrinho']);
    }

}
