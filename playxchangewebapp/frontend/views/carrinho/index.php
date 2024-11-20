<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CarrinhoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carrinho de compras';
?>

<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
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
                        <tr>
                            <td class="product__cart__item">
                                <div class="product__cart__item__pic">
                                    <img src="https://m.media-amazon.com/images/I/91vIToID-lL.jpg" height="100px" width="100px" alt="" class="img-fluid">
                                </div>
                                <div class="product__cart__item__text">
                                    <h6>T-shirt Contrast Pocket</h6>
                                    <h5>$98.49</h5>
                                </div>
                            </td>
                            <td class="quantity__item">
                                <div class="quantity">
                                    <div class="pro-qty-2">
                                        <span class="fa fa-angle-left dec qtybtn"></span>
                                        <input type="text" value="1">
                                        <span class="fa fa-angle-right dec qtybtn"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="cart__price">$ 30.00</td>
                            <td class="cart__plataforma">
                            </td>
                            <td class="cart__close"><i class="fas fa-times"></i></td>
                        </tr>
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
                            <a href="#" class="text-decoration-none"><i class="fa fa-spinner"></i>Atualizar carrinho</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__discount">
                    <h6>Desconto</h6>
                    <form action="#">
                        <input type="text" placeholder="Código promocional">
                        <button type="submit">Aplicar</button>
                    </form>
                </div>
                <div class="cart__total">
                    <h6>Total</h6>
                    <ul>
                        <li>Subtotal <span>$ 169.50</span></li>
                        <li>Total <span>$ 169.50</span></li>
                    </ul>
                    <a href="#" class="primary-btn text-decoration-none">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>