<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Collapse;
use yii\widgets\MaskedInput;

?>

<div class="container">
    <h1 class="h3 mb-5">Payment</h1>
    <div class="row">
        <!-- Left -->
        <div class="col-lg-9">
            <?php $form = ActiveForm::begin(['id' => 'payment-form']); ?>
            <div class="accordion" id="accordionPayment">
                <!-- Credit card -->
                <div class="accordion-item mb-3">
                    <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
                        <div class="form-check w-100 collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCC" aria-expanded="false">
                            <?= $form->field($model, 'payment_method')->radioList([
                                'credit_card' => 'Credit Card'
                            ], ['itemOptions' => ['class' => 'form-check-input']])->label(false) ?>
                        </div>
                        <span>
                            <svg width="34" height="25" xmlns="http://www.w3.org/2000/svg"></svg>
                        </span>
                    </h2>
                    <div id="collapseCC" class="accordion-collapse collapse show" data-bs-parent="#accordionPayment" style="">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <?= $form->field($model, 'card_number')->textInput(['placeholder' => 'Card Number']) ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <?= $form->field($model, 'name_on_card')->textInput(['placeholder' => 'Name on card']) ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <?= $form->field($model, 'expiry_date')->textInput(['placeholder' => 'MM/YY']) ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <?= $form->field($model, 'cvv_code')->passwordInput() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PayPal -->
                <div class="accordion-item mb-3 border">
                    <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
                        <div class="form-check w-100 collapsed" data-bs-toggle="collapse" data-bs-target="#collapsePP" aria-expanded="false">
                            <?= $form->field($model, 'payment_method')->radioList([
                                'paypal' => 'PayPal'
                            ], ['itemOptions' => ['class' => 'form-check-input']])->label(false) ?>
                        </div>
                        <span>
                            <svg width="103" height="25" xmlns="http://www.w3.org/2000/svg"></svg>
                        </span>
                    </h2>
                    <div id="collapsePP" class="accordion-collapse collapse" data-bs-parent="#accordionPayment" style="">
                        <div class="accordion-body">
                            <div class="px-2 col-lg-6 mb-3">
                                <?= $form->field($model, 'paypal_email')->textInput(['type' => 'email']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <!-- Right -->
        <div class="col-lg-3">
            <div class="card position-sticky top-0">
                <div class="p-3 bg-light bg-opacity-10">
                    <h6 class="card-title mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Subtotal</span> <span>$214.50</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Shipping</span> <span>$20.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Coupon (Code: NEWYEAR)</span> <span class="text-danger">-$10.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 small">
                        <span>TOTAL</span> <strong class="text-dark">$224.50</strong>
                    </div>
                    <div class="form-check mb-1 small">
                        <?= $form->field($model, 'terms_agree')->checkbox(['label' => 'I agree to the <a href="#">terms and conditions</a>']) ?>
                    </div>
                    <div class="form-check mb-3 small">
                        <?= $form->field($model, 'subscribe')->checkbox(['label' => 'Get emails about product updates and events. If you change your mind, you can unsubscribe at any time. <a href="#">Privacy Policy</a>']) ?>
                    </div>
                    <button class="btn btn-primary w-100 mt-2">Place order</button>
                </div>
            </div>
        </div>
    </div>
</div>
