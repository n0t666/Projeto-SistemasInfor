<?php

namespace frontend\controllers;

use common\models\Chave;
use common\models\CodigoPromocional;
use common\models\Fatura;
use common\models\Jogo;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\MetodoEnvio;
use common\models\MetodoPagamento;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use function PHPUnit\Framework\exactly;

class FaturaController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','checkout','create','view'],
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

    public function actionIndex()
    {
        $user = Yii::$app->user->identity->profile;

        if(!$user){
            throw new NotFoundHttpException();
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $user->getFaturas(),
            'pagination' => [
                'pageSize' =>5,
            ],
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionCheckout()
    {
        try {
            $user = Yii::$app->user->identity->profile;
            $carrinho = $user->carrinho;


            if (!$carrinho || empty($carrinho->linhascarrinhos)) {
                throw new \Exception('O carrinho está vazio.');
            }
            $codigo = Yii::$app->request->post('codigo');
            $codigoModel = null;

            if ($codigo != null && $codigo != '') {
                $codigoModel = CodigoPromocional::find()->where(['codigo' => $codigo, 'isAtivo' => CodigoPromocional::STATUS_ACTIVATED])->one();

                if (!$codigoModel) {
                    Yii::$app->session->setFlash('error', 'Não é possível utilizar o código promocional inserido.');
                    return $this->redirect(['/carrinho']);
                }


                /*
                $isCodigoUsed = !empty(array_filter($user->codigos, function($codigo) use ($codigoModel) {
                    return $codigo->id == $codigoModel->id;
                }));
                */

                $isCodigoUsed = $user->getCodigos()
                    ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id']) // Fazer join com a tabela pivot
                    ->andWhere(['codigosPromocionais.id' => $codigoModel->id])
                    ->exists(); // Devolve true or false dependendo se o utilizador já utilizou o código promocional

                if ($isCodigoUsed) {
                    Yii::$app->session->setFlash('error', 'Já utilizou este código promocional.');
                    return $this->redirect(['/carrinho']);
                }
            }
            $total = 0;
            foreach ($carrinho->linhascarrinhos as $linhaCarrinho) {
                $produto = $linhaCarrinho->produtos;
                $subtotal = $linhaCarrinho->quantidade * $linhaCarrinho->produtos->preco;
                $total += $subtotal;
            }

            $totalSemDesconto = $total;
            $valorDescontado = null;
            $codigoArray = null;

            if ($codigoModel) {
                $desconto = $codigoModel->desconto;
                $valorDescontado = ($total * ($desconto / 100));
                if ($valorDescontado > $total) {
                    $valorDescontado = $total;
                }
                $total -= $valorDescontado;
                $codigoArray = [
                    'codigo_id' => $codigoModel->id,
                    'valor_descontado' => $valorDescontado,
                    'nome' => $codigoModel->codigo,
                ];
            }


            $model = new Fatura();
            $model->utilizador_id = $user->id;
            if ($codigoModel) {
                $model->codigo_id = $codigoModel->id;
            }
            $pagamentos = MetodoPagamento::find()->all();
            $envios = MetodoEnvio::find()->all();


            return $this->render('checkout', [
                'model' => $model,
                'total' => $total,
                'totalSemDesconto' => $totalSemDesconto,
                'pagamentos' => $pagamentos,
                'envios' => $envios,
                'codigoArray' => $codigoArray,
            ]);

        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Erro ao processar a sua compra.');
            return $this->redirect(['/carrinho']);
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->request->post()) {
            try {
                $pagamentoId = Yii::$app->request->post('Fatura')['pagamento_id'] ?? null;
                $envioId = Yii::$app->request->post('Fatura')['envio_id'] ?? null;
                $codigoId = Yii::$app->request->post('Fatura')['codigo_id'] ?? null;
                $user = Yii::$app->user->identity->profile;

                if (!$user) {
                    return $this->goHome();
                }

                $carrinho = $user->carrinho;

                if ($pagamentoId) {
                    $pagamento = MetodoPagamento::findOne($pagamentoId);
                    if (!$pagamento) {
                        Yii::$app->session->setFlash('error', 'Método de pagamento inválido.');
                        return $this->redirect(['/carrinho']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Método de pagamento inválido.');
                    return $this->redirect(['/carrinho']);
                }

                if ($envioId) {
                    $envio = MetodoEnvio::findOne($envioId);
                    if (!$envio) {
                        Yii::$app->session->setFlash('error', 'Método de envio inválido.');
                        return $this->redirect(['/carrinho']);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Método de envio inválido.');
                    return $this->redirect(['/carrinho']);
                }

                if(empty($carrinho) || empty($carrinho->linhascarrinhos)){
                    Yii::$app->session->setFlash('error', 'Não existe nenhum item no carrinho.');
                    return $this->goHome();
                }

                $codigo = null;
                $isCodigoUsed = true;
                if ($codigoId) {
                    $codigo = CodigoPromocional::find()->where(['id' => $codigoId, 'isAtivo' => CodigoPromocional::STATUS_ACTIVATED])->one();
                    if (!$codigo) {
                        Yii::$app->session->setFlash('error', 'Não é possível utilizar o código promocional inserido.');
                        return $this->redirect(['/carrinho']);
                    }
                    $isCodigoUsed = $user->getCodigos()
                        ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id'])
                        ->andWhere(['codigosPromocionais.id' => $codigo->id])
                        ->exists();
                    if ($isCodigoUsed) {
                        Yii::$app->session->setFlash('error', 'Já utilizou este código promocional.');
                        return $this->redirect(['/carrinho']);
                    }
                }

                $transaction = Yii::$app->db->beginTransaction();
                $total = 0;


                $model = new Fatura();
                $model->utilizador_id = $user->id;
                $model->pagamento_id = $pagamentoId;
                $model->envio_id = $envioId;
                $model->total = $total;
                if ($codigo != null && !$isCodigoUsed) {
                    $model->codigo_id = $codigoId;
                    $user->link('codigos', $codigo);
                }
                $model->estado = Fatura::ESTADO_PAID;

                if (!$model->save()) {
                    throw new \Exception('Erro ao criar a fatura.');
                }

                if($model->envio != null){
                    if(strtolower($model->envio->nome) == 'entrega online'){
                        foreach ($carrinho->linhascarrinhos as $linhaCarrinho) {
                            $produto = $linhaCarrinho->produtos;
                            $chavesDisponiveis = $produto->getChaves()->where(['isUsada' => 0])->count();
                            if ($chavesDisponiveis < $linhaCarrinho->quantidade) {
                                Yii::$app->session->setFlash('error', 'Não há chaves suficientes para o produto: ' . $produto->jogo->nome);
                                return $this->redirect(['/carrinho']);
                            }
                            $chavesReservar = $produto->getChaves()
                                ->where(['isUsada' => 0])
                                ->limit($linhaCarrinho->quantidade)
                                ->all();
                            $subtotal = $linhaCarrinho->quantidade * $produto->preco;
                            $total += $subtotal;
                            foreach ($chavesReservar as $chave) {
                                $chave->isUsada = 1;
                                if (!$chave->save()) {
                                    throw new \Exception('Erro ao finalizar o pedido.');
                                }
                                $linhaFatura = new LinhaFatura();
                                $linhaFatura->fatura_id = $model->id;
                                $linhaFatura->chave_id = $chave->id;
                                $linhaFatura->produto_id = $produto->id;
                                $linhaFatura->precoUnitario = $produto->preco;

                                if (!$linhaFatura->save()) {
                                    throw new \Exception('Erro ao guardar as linhas da fatura.');
                                }
                            }
                        }
                    }elseif (strtolower($model->envio->nome) == 'entrega em loja'){
                        foreach ($carrinho->linhascarrinhos as $linhaCarrinho) {
                            $produto = $linhaCarrinho->produtos;
                            $produtosDisponiveis = $produto->quantidade;

                            if ($produtosDisponiveis < $linhaCarrinho->quantidade) {
                                Yii::$app->session->setFlash('error', 'Não há stock suficiente para o produto: ' . $produto->jogo->nome);
                                return $this->redirect(['/carrinho']);
                            }

                            for ($i = 0; $i < $linhaCarrinho->quantidade; $i++) {
                                $produto->quantidade -= 1;
                                if (!$produto->save()) {
                                    throw new \Exception('Erro ao atualizar o stock do produto.');
                                }
                                $linhaFatura = new LinhaFatura();
                                $linhaFatura->fatura_id = $model->id;
                                $linhaFatura->produto_id = $produto->id;
                                $linhaFatura->precoUnitario = $produto->preco;
                                $linhaFatura->chave_id = null;

                                if (!$produto->save()) {
                                    throw new \Exception('Erro ao atualizar o stock do produto.');
                                }

                                if (!$linhaFatura->save()) {
                                    Yii::$app->session->setFlash('error', 'Erro ao guardar as linhas da fatura para o produto: ' . $produto->jogo->nome);
                                    return $this->redirect(['/carrinho']);
                                }

                                $total += $produto->preco;

                            }
                        }
                    }else{
                        Yii::$app->session->setFlash('error', 'Ocorreu um erro inesperaado ao processar o pedido.');
                        throw new \Exception('Erro ao processar o pedido.');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'Ocorreu um erro inesperaado ao processar o pedido.');
                    throw new \Exception('Erro ao processar o pedido.');
                }

                if ($codigo != null && !$isCodigoUsed) {
                    $desconto = $codigo->desconto;
                    $valorDescontado = ($total * ($desconto / 100));
                    $total -= $valorDescontado;
                    if ($total < 0) {
                        $total = 0;
                    }
                }

                $model->total = $total;
                if (!$model->save()) {
                    throw new \Exception('Erro ao atualizar o total da fatura.');
                }

                $transaction->commit();
                $carrinho->linhascarrinhos();
                LinhaCarrinho::deleteAll(['carrinhos_id' => $carrinho->id]);
                $carrinho->total = 0;
                $carrinho->count = 0;
                $carrinho->save();

                Yii::$app->session->setFlash('success', 'Fatura criada com sucesso.');
                return $this->redirect(['/site']);
            } catch (\Exception $e) {
                if(isset($transaction)){
                    $transaction->rollBack();
                }
                Yii::$app->session->setFlash('error', 'Erro ao processar a fatura.');
                return $this->redirect(['/carrinho']);
            }
        }else{
            Yii::$app->session->setFlash('error', 'Não foi possível encontrar a página solicitada.');
            return $this->goHome();
        }
    }

    public function actionView($id){
        $fatura = $this->findModel($id);
        $user = Yii::$app->user->identity->profile;

        if(!$fatura || !$user || Yii::$app->user->isGuest){
            throw new NotFoundHttpException();
        }

        if($fatura->utilizador_id != $user->id){ // Garantir que cada cliente apenas tenho acesso ás suas faturas
           throw new NotFoundHttpException();
        }

        $linhasFatura = [];
        $totalSemDesconto = 0;

        foreach ($fatura->linhasfaturas as $linha){
            $produto = $linha->produto_id;
            if (!isset($linhasFatura[$produto])) {
                $linhasFatura[$produto] = [
                    'produto' => $linha->produto,
                    'precoUnitario' => $linha->precoUnitario,
                    'quantidade' => 0,
                    'subtotal' => 0,
                    'chaves' => []
                ];
            }

            $linhasFatura[$produto]['quantidade'] += 1;
            $linhasFatura[$produto]['subtotal'] += $linha->precoUnitario;
            if($linha->chave != null){
                $linhasFatura[$produto]['chaves'][] = $linha->chave;
            }


            $totalSemDesconto += $linha->precoUnitario;
        }

        $quantidadeDesconto = 0;

        if ($fatura->codigo) {
            $desconto = $fatura->codigo->desconto;
            $quantidadeDesconto = ($totalSemDesconto * $desconto) / 100;
        }


        return $this->render('view', [
            'fatura' => $fatura,
            'linhasFatura' => $linhasFatura,
            'totalSemDesconto' => $totalSemDesconto,
            'totalQuantidade' => $quantidadeDesconto,
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Fatura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}