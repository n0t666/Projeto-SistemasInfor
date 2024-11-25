<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $carrinho common\models\Carrinho */

$this->title = 'Carrinho de compras';

$this->registerJsFile(
    '@web/js/carrinhoIndex.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);



?>

<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <?php $form = ActiveForm::begin([
                        'action' => ['linha-carrinho/update'],
                        'id' => 'carrinho',
                    ]); ?>
                    <table>
                        <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Plataforma</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->linhascarrinhos as $linha): ?>
                            <tr>
                                <td class="product__cart__item">
                                    <div class="product__cart__item__pic">
                                        <img src="<?=  Yii::getAlias('@capasJogoUrl') . '/'. $linha->produtos->jogo->imagemCapa; ?>" height="100px" width="100px" alt="" class="img-fluid">
                                    </div>
                                    <div class="product__cart__item__text">
                                        <h6><?= Html::encode($linha->produtos->jogo->nome) ?></h6>
                                        <h5><?= number_format($linha->produtos->preco, 2) ?>€</h5>
                                    </div>
                                </td>
                                <td class="quantity__item">
                                    <div class="quantity">
                                        <div class="pro-qty-2">
                                            <span class="fa fa-angle-left dec qtybtn"></span>
                                            <?= Html::input('text', "quantidades[{$linha->produtos->id}]", $linha->quantidade, [
                                                'inputmode' => 'numeric',
                                                'oninput' => 'this.value = this.value.replace(/\D+/g, "")',
                                                'class' => 'quantity-input',
                                                'required' => true,
                                                'min' => 1,
                                                'max' => 5,
                                            ]) ?>
                                            <span class="fa fa-angle-right inc qtybtn"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="cart__price"><?= number_format($linha->produtos->preco * $linha->quantidade, 2) ?>€</td>
                                <td class="cart__plataforma"><?= Html::encode($linha->produtos->plataforma->nome) ?></td>
                                <td class="cart__close">
                                    <?= Html::a('<i class="fas fa-times"></i>', [
                                        'linha-carrinho/delete',
                                        'produtoId' => $linha->produtos_id,
                                    ], [
                                        'data' => [
                                            'confirm' => 'Tem certeza que deseja remover este produto?',
                                            'method' => 'post',
                                        ],
                                        'class' => 'text-danger',
                                    ]) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="#" class="text-decoration-none">Continuar a comprar</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn update__btn">
                            <a href="#" class="text-decoration-none" id="quantitySub"><i class="fa fa-spinner" ></i>Atualizar carrinho</a>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-4">
                <div class="cart__discount">
                    <h6>Desconto</h6>
                    <?php $form = ActiveForm::begin([
                        'action' => ['fatura/checkout'],
                        'id' => 'checkout-form',
                    ]); ?>
                        <input type="text" name="codigo" placeholder="Código promocional">
                        <button type="button">Aplicar</button>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="cart__total">
                    <?php if ($model->total != null && $model->total > 0): ?>
                    <h6>Total</h6>
                    <ul>
                        <li>Total <span><?= number_format($model->total, 2) ?></span></li>
                    </ul>
                    <?php endif;?>
                    <button type="submit" class="primary-btn text-decoration-none btn" form="checkout-form">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>
