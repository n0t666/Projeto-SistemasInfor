<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Accordion;
use yii\bootstrap5\Collapse;
use yii\widgets\MaskedInput;

$this->registerCssFile('@web/css/checkout.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);


?>

<div class="container checkout-container" style="padding-top: 50px;">
    <div class="row">
        <div class="col-lg-9">
            <?php $form = ActiveForm::begin(['action' => ['create'],'id' => 'payment-form']); ?>

            <!-- Métodos de Entrega -->
            <div class="mb-3">
                <h5 class="mb-3 section-title">Escolha o método de entrega</h5>
                <div class="btn-group delivery-methods" role="group" aria-label="Entrega options">
                    <?= $form->field($model, 'envio_id')
                    ->radioList( // O widget radiolist espera algo do tipo: ['id' => 'nome', 'id' => 'nome']
                        array_combine( // Criar um array associativo sendo os ids de cada pagamento a chave e o valor o nome do pagamento ( que será exibido como label)
                            array_map(function ($envio) { // Extrair o id do array dos métodos de envio para depois usar como chave
                                return $envio->id;
                            }, $envios),
                            array_map(function ($envio) { // Extrair os nomes do array dos métodos de envio para depois usar como valor
                                return $envio->nome;
                            }, $envios)
                        ),
                        [
                            'separator' => '',
                            'class' => 'd-flex flex-wrap',
                            'inline' => true,
                        ]
                    )->label(false) ?>

                </div>
            </div>


            <h5 class="mb-3 section-title mt-3">Escolha o método de pagamento</h5>
            <!-- Métodos de Pagamento -->
            <?php foreach ($pagamentos as $metodoPagamento): ?>
                <div class="accordion custom-accordion mb-3" id="accordionPayment">
                    <div class="accordion-item mb-3">
                        <h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center custom-accordion-header">
                            <div class="form-check w-100 collapsed" data-bs-toggle="collapse"
                                 data-bs-target="#collapseCC<?= $metodoPagamento->id ?>" aria-expanded="false">
                                <input type="radio" name="Fatura[pagamento_id]" value="<?= $metodoPagamento->id ?>"
                                       id="paymentMethod<?= $metodoPagamento->id ?>" class="form-check-input custom-radio-input" required>
                                <label for="paymentMethod<?= $metodoPagamento->id ?>" class="form-check-label">
                                    <?= $metodoPagamento->nome ?>
                                </label>
                            </div>
                            <span>
                            <img src="<?= Yii::getAlias('@utilsUrl') . '/' . $metodoPagamento->logotipo; ?>"
                         height="64" width="64" alt="" class="img-fluid p-2">
                        </span>
                        </h2>
                        <div id="collapseCC<?= $metodoPagamento->id ?>" class="accordion-collapse collapse"
                             data-bs-parent="#accordionPayment">
                            <div class="accordion-body custom-accordion-body">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Right Column (Summary) -->
        <div class="col-lg-3">
            <div class="card position-sticky top-0 custom-summary-card">
                <div class="p-3 custom-summary">
                    <h6 class="card-title mb-3">Detalhes da compra</h6>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Subtotal</span><span><?= $totalSemDesconto ?>€</span>
                    </div>
                    <?php if ($codigoArray): ?>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Cupão (Código:  <?= $codigoArray['nome']  ?>)</span> <span class="text-danger">-<?= $codigoArray['valor_descontado']?>€</span>
                        </div>
                    <?php endif; ?>
                    <hr class="section-divider">
                    <div class="d-flex justify-content-between mb-4 small">
                        <span>TOTAL (Com IVA)</span> <strong class="total-amount"><?= $total ?>€</strong>
                    </div>
                    <button class="custom-btn-order btn w-100 mt-2" type="submit" form="payment-form">Completar compra</button>
                </div>
            </div>
        </div>

        <?php if ($codigoArray): ?>
            <?= $form->field($model, 'codigo_id')->hiddenInput(['value' => $codigoArray['codigo_id']])->label(false); ?>
        <?php endif ?>
        <?= $form->field($model, 'utilizador_id')->hiddenInput(['value' => $model->utilizador_id])->label(false); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>


