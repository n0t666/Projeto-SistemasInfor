<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\LinhaCarrinho;
use common\models\User;
use Yii;
use yii\base\ErrorException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['index'], $actions['view']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
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

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $carrinho = Carrinho::find()->where(['utilizador_id' => $user->id])->one();

        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->utilizador_id = $user->id;
            if (!$carrinho->save()) {
                throw new BadRequestHttpException('Falha ao criar o carrinho');
            }
        }
        $itensCarrinho = null;

        if ($carrinho->linhascarrinhos) {
            $itensCarrinho = [];
            foreach ($carrinho->linhascarrinhos as $linha) {
                $produto = $linha->produtos;
                $itensCarrinho[] = [
                    'produto_id' => $linha->produtos_id,
                    'produto_nome' => $produto->jogo->nome,
                    'plataforma_id' => $produto->plataforma_id,
                    'plataforma_nome' => $produto->plataforma->nome,
                    'quantidade' => $linha->quantidade,
                    'preco' => $produto->preco,
                    'total' => $linha->quantidade * $produto->preco,
                    'capa' => Yii::getAlias('@mobileIp') . Yii::getAlias('@capasJogoUrl') . '/' . $produto->jogo->imagemCapa,
                ];
            }
        }
        return [
            'carrinho' => $carrinho->attributes,
            'itensCarrinho' => $itensCarrinho,

        ];
    }

    public function actionCreate()
    {
        $body = Yii::$app->request->getBodyParams();

        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $carrinho = new Carrinho();
        $carrinho->utilizador_id = $user->id;
        if (!$carrinho->save()) {
            throw new BadRequestHttpException('Falha ao criar o carrinho');
        }

        return $carrinho->attributes;
    }

    public function actionAddProduto()
    {
        $body = Yii::$app->request->getBodyParams();
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $carrinho = $user->profile->carrinho;

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }


        if (!isset($body['produto_id']) || !isset($body['quantidade'])) {
            throw new BadRequestHttpException('Dados incompletos');
        }

        $linhaCarrinho = $carrinho->getLinhasCarrinhos()->where(['produtos_id' => $body['produto_id']])->one();

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += $body['quantidade'];
            if (!$linhaCarrinho->save()) {
                throw new BadRequestHttpException('Falha ao atualizar o item no carrinho');
            }
        } else {
            $linhaCarrinho = new LinhaCarrinho();
            $linhaCarrinho->carrinhos_id = $carrinho->id;
            $linhaCarrinho->produtos_id = $body['produto_id'];
            $linhaCarrinho->quantidade = $body['quantidade'];

            if (!$linhaCarrinho->save()) {
                throw new BadRequestHttpException('Falha ao adicionar item ao carrinho');
            }
        }

        $carrinho->recalculateTotal();

        return [
            'carrinho' => $carrinho->attributes,
        ];
    }


    public function actionAlterarQuantidade($idproduto)
    {
        $user = Yii::$app->user->identity;
        $body = Yii::$app->request->getBodyParams();

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }


        $carrinho = $user->profile->carrinho;

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        if (!$carrinho->linhascarrinhos) {
            throw new NotFoundHttpException('O seu carrinho está vazio');
        }

        if (!isset($body['quantidade']) || !isset($body['tipo'])) {
            throw new BadRequestHttpException('Dados incompletos');
        }

        $produto_id = $idproduto;
        $quantidade = $body['quantidade'];
        $tipo = $body['tipo'];

        if ($quantidade != null && $quantidade < 0) {
            throw new BadRequestHttpException('Não são aceitadas quantidades abaixo de 0');
        }

        //$linhaCarrinho = LinhaCarrinho::find()->where(['carrinhos_id' => $carrinho->id,'produtos_id' => $produto_id])->one();
        $linhaCarrinho = $carrinho->getLinhasCarrinhos()->where(['produtos_id' => $produto_id])->one();

        if (!$linhaCarrinho) {
            throw new NotFoundHttpException('Não foi possível encontrar a linha especificada');
        }

        switch ($tipo) {
            case '+':
                $linhaCarrinho->quantidade += $quantidade;
                break;
            case '-':
                if ($linhaCarrinho->quantidade > $quantidade  ) {
                    $linhaCarrinho->quantidade -= $quantidade;
                } elseif ($linhaCarrinho->quantidade == $quantidade) {
                    $linhaCarrinho->delete();
                    return 'Linha do carrinho removida com sucesso';
                } else {
                    throw new BadRequestHttpException('O valor da quantidade não é válido.');
                }
                break;
            default:
                throw new NotFoundHttpException('Não foi possível encontrar ação da linha especificada');
        }



        if (!$linhaCarrinho->save()) {
            throw new \Exception('Ocorreu um problema ao guardar a alteração do carrinho');
        }
        
        $carrinho->refresh();
        $carrinho->recalculateTotal();

        return [
            'message' => 'Linha do carrinho alteradas com sucesso',
        ];

    }

    public function actionClear()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        $carrinho = $user->profile->carrinho;

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        if (!$carrinho->linhascarrinhos) {
            throw new NotFoundHttpException('O seu carrinho está vazio');
        }

        $linhas = LinhaCarrinho::deleteAll(['carrinhos_id' => $carrinho->id]);

        $carrinho->total = null;
        $carrinho->count = 0;
        $carrinho->save();
    }

    public function actionApagarLinha($idproduto)
    {
        $user = Yii::$app->user->identity;


        if (!$user) {
            throw new UnauthorizedHttpException('Access token inválido.');
        }

        //$carrinho = Carrinho::find()->where(['utilizador_id' => $user->id])->one();
        $carrinho = $user->profile->carrinho;
        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        if (!$carrinho->linhascarrinhos) {
            throw new NotFoundHttpException('O seu carrinho está vazio');
        }

        if (!$idproduto) {
            throw new BadRequestHttpException('Dados incompletos');
        }


        //$linha = LinhaCarrinho::find()->where(['carrinhos_id' => $carrinho->id,'produtos_id' => $produto_id])->one();
        $linha = $carrinho->getLinhascarrinhos()->where(['produtos_id' => $idproduto])->one();
        if (!$linha) {
            throw new NotFoundHttpException('Não foi possivel encontrar a linha especificada');
        }

        $linha->delete();

        $carrinho->recalculateTotal();

        $itensCarrinho = null;

        return [
            'message' => 'Linha carrinho apagado com sucesso.',
        ];

    }


}
