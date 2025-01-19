<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\CodigoPromocional;
use common\models\Fatura;
use common\models\Jogo;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\MetodoEnvio;
use common\models\MetodoPagamento;
use common\models\User;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidValueException;
use yii\db\Exception;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function actions(){
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => [],
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

        public function actionIndex()
        {
            $user = Yii::$app->user->identity;

            if(!$user){
                throw new UnauthorizedHttpException('Access token inválido.');
            }

            $faturas = $user->profile->faturas;
            $response = null;
            $imagensJogos = [];
            $idsJogos = [];


            // Utilizar para obter uma preview da foto de capa de 4 jogos distintos
            foreach ($faturas as $fatura) {
                $imagensJogos = [];
                $idsJogos = [];
               foreach ($fatura->linhasfaturas as $linha){
                   $produto = $linha->produto;
                   $jogo = $produto->jogo;
                   if (!in_array($jogo->id, $idsJogos)) { // Verificar se o jogo já foi adicionado anteriormente, se não, adicionar a esse mesmo
                       if(count($imagensJogos) < 4){ // Garantir que não passa o limite definid de 4 imagens de jogos diferentes
                           $imagensJogos[] = Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa;
                           $idsJogos[] = $jogo->id;
                       }
                   }
               }
                $response [] = [
                    'id' => $fatura->id,
                    'estado' => $fatura->estado,
                    'total' => $fatura->total,
                    'dataEncomenda' => $fatura->dataEncomenda,
                    'quantidade' => count($fatura->linhasfaturas),
                    'imagensJogos' => $imagensJogos,
                ];
            }



        return $response;
    }

    public function actionView($id)
    {
        $user = Yii::$app->user->identity;

        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $fatura = Fatura::findOne($id);

        if(!$fatura){
            throw new NotFoundHttpException('Não foi possível encontrar o fatura');
        }

        if ($fatura->utilizador_id != $user->id) {
            throw new NotFoundHttpException('Não foi possível encontrar a fatura.');
        }


        $faturaResponse = [];
        $linhasFatura = [];


        $faturaResponse = [
            'id' => $fatura->id,
            'estado' => $fatura->estado,
            'total' => round($fatura->total, 2),
            'dataEncomenda' => $fatura->dataEncomenda,
            'pagamento' => $fatura->pagamento->nome,
            'envio' => $fatura->envio->nome,
            'codigo' => $fatura->getCodigo()->count() > 0 ? $fatura->codigo->codigo : null,
        ];

        foreach ($fatura->linhasfaturas as $linha){
            $produto = $linha->produto;
            if (!isset($linhasFatura[$produto->id])) {
                $linhasFatura[$produto->id] = [
                    'capa' => Yii::getAlias('@capasJogoUrl') . '/' . $produto->jogo->imagemCapa,
                    'produtoId' => $produto->id,
                    'jogoId' => $produto->jogo->id,
                    'produtoNome' => $produto->jogo->nome,
                    'precoUnitario' => round($linha->precoUnitario, 2),
                    'quantidade' => 0,
                    'subtotal' => 0,
                    'chaves' => []
                ];
            }

            $linhasFatura[$produto->id]['quantidade'] += 1;
            $linhasFatura[$produto->id]['subtotal'] += round($linha->precoUnitario, 2);
            if($linha->chave != null){
                $linhasFatura[$produto->id]['chaves'][] = $linha->chave->chave;
            }
        }

        $faturaResponse['totalSemDesconto'] = round($fatura->getTotalSemDesconto(), 2);
        $quantidadeDesconto = $faturaResponse['totalSemDesconto'] - $fatura->total;
        $faturaResponse['quantidadeDesconto'] = round($quantidadeDesconto, 2);

        return [
            'fatura' => $faturaResponse,
            'linhasFatura' => array_values($linhasFatura), // (bug android) com as chaves do array não consigo obter as linahas
        ];
    }

    public function actionCreate(){
        $user = Yii::$app->user->identity;
        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        try{
            $pagamentoId = $body['pagamento_id'] ?? null;
            $envioId = $body['envio_id'] ?? null;
            $codigoId = $body['codigo_id'] ?? null;
            $user = Yii::$app->user->identity->profile;

            if (!$user) {
                return $this->goHome();
            }

            $carrinho = $user->carrinho;

            if ($pagamentoId) {
                $pagamento = MetodoPagamento::findOne($pagamentoId);
                if (!$pagamento) {
                   throw new NotFoundHttpException('Não foi possível encontrar o método de pagamento solicitado');
                }
            } else {
                throw new NotFoundHttpException('Não foi possível encontrar o método de pagamento solicitado');
            }

            if ($envioId) {
                $envio = MetodoEnvio::findOne($envioId);
                if (!$envio) {
                    throw new NotFoundHttpException('Não foi possível encontrar o método de envio solicitado');
                }
            } else {
                throw new NotFoundHttpException('Não foi possível encontrar o método de envio solicitado');
            }

            if(empty($carrinho) || empty($carrinho->linhascarrinhos)){
                throw new InvalidValueException('Não existe nenhum item no carrinho');
            }

            $codigo = null;
            $isCodigoUsed = true;
            if ($codigoId) {
                $codigo = CodigoPromocional::find()->where(['id' => $codigoId, 'isAtivo' => CodigoPromocional::STATUS_ACTIVATED])->one();
                if(codigo){
                    $isCodigoUsed = $codigo->isUsedByUser($user);
                    if ($isCodigoUsed) {
                        throw new Exception('O código já foi utilizado previamente');
                    }
                }

            }
            $transaction = Yii::$app->db->beginTransaction();
            $carrinho->refresh();
            $carrinho->recalculateTotal();
            $total = $carrinho->total;
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
                        if (!$produto->hasSuficienteChaves($linhaCarrinho->quantidade)) {
                            throw new \Exception('Não há chaves suficientes para o produto: ' . $produto->jogo->nome);
                        }
                        $chavesReservar = $produto->reservarChaves($linhaCarrinho->quantidade);
                        foreach ($chavesReservar as $chave) {
                            $chave->isUsada = 1;
                            if (!$chave->save()) {
                                throw new \Exception('Erro ao finalizar o pedido.');
                            }
                            $model->adicionarLinhaFatura($produto,$chave->id);
                        }
                    }
                }elseif (strtolower($model->envio->nome) == 'entrega em loja'){
                    foreach ($carrinho->linhascarrinhos as $linhaCarrinho) {
                        $produto = $linhaCarrinho->produtos;
                        if (!$produto->hasSuficienteQuantidade($linhaCarrinho->quantidade)) {
                           throw new \Exception('Não há stock suficiente para o produto: ' . $produto->jogo->nome);
                        }

                        for ($i = 0; $i < $linhaCarrinho->quantidade; $i++) {
                            $produto->quantidade -= 1;
                            if (!$produto->save()) {
                                throw new \Exception('Erro ao atualizar o stock do produto.');
                            }
                            $model->adicionarLinhaFatura($produto);
                        }
                    }
                }else{
                    throw new NotFoundHttpException('Não foi possível encontrar o tipo de envio especificado.');
                }

            }else{
                throw new \Exception('Erro ao processar o pedido.');
            }

            if ($codigo != null && !$isCodigoUsed) {
                $total =  $total - $codigo->aplicarDesconto($total);
            }

            $model->total = $total;
            if (!$model->save()) {
                throw new \Exception('Erro ao atualizar o total da fatura.');
            }

            $transaction->commit();
            $carrinho->limpar();

            return [
                'message' => 'Fatura criadas com sucesso.',
            ];

        } catch (\Exception $e) {
            if(isset($transaction)){
                $transaction->rollBack();
            }
            throw new \Exception($e->getMessage());

        }
    }

    public function actionCheckout(){
        $user = Yii::$app->user->identity;
        if(!$user){
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $carrinho = $user->profile->carrinho;

        if (!$carrinho || empty($carrinho->linhascarrinhos)) {
            throw new \Exception('O carrinho está vazio.');
        }

        $body = Yii::$app->getRequest()->getBodyParams();

        $codigo = $body['codigo'] ?? null;



        $carrinho->refresh();
        $carrinho->recalculateTotal();
        $total = $carrinho->total;
        $totalSemDesconto = $total;
        $valorDescontado = null;
        $codigoArray = null;

        if($codigo != null && $codigo != -1){
            $codigoPromocional = CodigoPromocional::find()->where(['id' => $codigo, 'isAtivo' => CodigoPromocional::STATUS_ACTIVATED])->one();
            if(!$codigoPromocional){
                throw new \Exception('O código promocional não é válido.' . $codigo);
            }
            $isCodigoUsed = $user->profile->getCodigos()
                ->viaTable('utilizacaocodigos', ['utilizador_id' => 'id']) // Fazer join com a tabela pivot
                ->andWhere(['codigosPromocionais.id' => $codigoPromocional->id])
                ->exists(); // Devolve true or false dependendo se o utilizador já utilizou o código promocional

            if($isCodigoUsed){
                throw new \Exception('O código promocional já foi utilizado.');
            }
            $desconto = $codigoPromocional->desconto;
            $valorDescontado = round($total * ($desconto / 100), 2);
            $total = round($total - $valorDescontado, 2);
            $codigoArray = [
                'id' => $codigoPromocional->id,
                'codigo' => $codigoPromocional->codigo,
                'desconto' => $codigoPromocional->desconto,
            ];
        }

        $metodosPagamento = [];

        foreach (MetodoPagamento::find()->all() as $metodoPagamento) {
            $metodosPagamento[] = [
                'id' => $metodoPagamento->id,
                'nome' => $metodoPagamento->nome,
                'logotipo' => Yii::getAlias('@utilsUrl') . '/' . $metodoPagamento->logotipo,
            ];
        }

        $metodosEnvio = [];

        foreach (MetodoEnvio::find()->all() as $metodoEnvio) {
            $metodosEnvio[] = [
                'id' => $metodoEnvio->id,
                'nome' => $metodoEnvio->nome,
            ];
        }

        return [
            'total' => round($total ?? 0, 2),
            'totalSemDesconto' => round($totalSemDesconto ?? 0, 2),
            'valorDescontado' => round($valorDescontado ?? 0, 2),
            'codigo' => $codigoArray,
            'metodosPagamento' => $metodosPagamento,
            'metodosEnvio' => $metodosEnvio,
        ];
    }



}
