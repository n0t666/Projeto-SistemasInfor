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

        $faturas = $user->faturas;


        return $this->render('index', [
            'faturas' => $faturas,

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
                    $isCodigoUsed = $isCodigoUsed = $user->getCodigos()
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
                if ($codigo != null && !$isCodigoUsed) {
                    $model->codigo_id = $codigoId;
                    $user->link('codigos', $codigo);
                }
                $model->estado = Fatura::ESTADO_PAID;

                if (!$model->save()) {
                    throw new \Exception('Erro ao salvar fatura.');
                }

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

                if ($codigo != null && !$isCodigoUsed) {
                    $desconto = $codigo->desconto;
                    $valorDescontado = ($total * ($desconto / 100));
                    $total -= $valorDescontado;
                }

                $model->total = $total;
                if (!$model->save()) {
                    throw new \Exception('Erro ao atualizar o total da fatura.');
                }

                $transaction->commit();
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
                var_dump($e->getMessage());
                exit();
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

        return $this->render('view', [
            'fatura' => $fatura,
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