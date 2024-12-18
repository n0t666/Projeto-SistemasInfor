<?php

use yii\bootstrap5\BootstrapAsset;

/* @var $fatura common\models\Fatura */

$this->registerCssFile('@web/css/faturas.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = 'Detalhes da encomenda';

?>


<div class="container-fluid">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="h5 mb-0">Encomenda #<?= $fatura->id ?></h2>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <div>
                                <span class="me-3"><?= $fatura->getDataEncomenda() ?></span>
                                <span class="badge rounded-pill bg-info"><?= $fatura->getEstadoLabel() ?></span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Chaves</th>
                                    <th>Quantidade</th>
                                    <th class="text-end">Preço</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($linhasFatura as $linha): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex mb-2">
                                                <div class="flex-shrink-0">
                                                    <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $linha['produto']->jogo->imagemCapa ?>"
                                                         alt="" width="35" class="img-fluid">
                                                </div>
                                                <div class="ms-3" style="max-width: calc(100% - 45px);">
                                                    <h6 class="small mb-0 text-truncate"
                                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        <a href="#"
                                                           class="text-reset"><?= $linha['produto']->jogo->nome ?></a>
                                                    </h6>
                                                    <span class="small text-truncate"
                                                          style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Plataforma: <?= $linha['produto']->plataforma->nome ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (count(array_filter($linha['chaves'])) > 0): ?>
                                            <div class="d-flex flex-column gap-2">
                                                    <?php foreach ($linha['chaves'] as $chave): ?>
                                                        <?php if ($chave !== null && isset($chave->chave)): ?>
                                                            <span class="badge bg-primary text-wrap"><?= $chave->chave ?></span>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $linha['quantidade'] ?></td>
                                        <td class="text-end"><?= $linha['precoUnitario'] ?>€</td>
                                        <td class="text-end"><?= $linha['subtotal'] ?>€</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end">Subtotal</td>
                                    <td class="text-end"><?= Yii::$app->formatter->asCurrency($totalSemDesconto) ?></td>
                                </tr>
                                <?php if ($fatura->codigo): ?>
                                <tr>
                                    <td colspan="5" class="text-end">Desconto (Código: <?= $fatura->codigo->codigo ?>)
                                    </td>
                                    <td class="text-danger text-end">
                                        -<?= Yii::$app->formatter->asCurrency($totalQuantidade) ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr class="fw-bold">
                                    <td colspan="5" class="text-end">TOTAL</td>
                                    <td class="text-end"><?= Yii::$app->formatter->asCurrency($fatura->total) ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-3">
                            <div class="mb-3 mb-sm-0">
                                <h5>Método de pagamento:</h5>
                                <p><?= $fatura->pagamento->nome ?></p>
                            </div>
                            <div class="text-sm-end">
                                <h5>Método de envio</h5>
                                <p><?= $fatura->envio->nome ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





