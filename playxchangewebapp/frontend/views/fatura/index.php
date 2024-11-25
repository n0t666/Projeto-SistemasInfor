<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Accordion;
use yii\widgets\MaskedInput;

$this->title = 'Faturas';

$this->registerCssFile('@web/css/faturas.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);


?>
<style>


</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="order-list p-4 rounded-3 shadow-lg">
                <h2 class="text-center mb-4">Lista de encomendas</h2>
                <ul class="list-unstyled">
                    <?php foreach ($faturas as $fatura) : ?>
                    <li class="order-item d-flex justify-content-between align-items-start mb-3 p-3 rounded-2">
                        <div class="order-details d-flex align-items-center">
                            <?php $primProduto = $fatura->linhasfaturas[0]->produto->jogo ?>
                            <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $primProduto->imagemCapa  ?>" alt="Game Poster" class="order-poster rounded-2 me-3" />
                            <div>
                                <h5>Encomenda #<?= $fatura->id ?></h5>
                                <p><strong>Total de Itens:</strong> <?= count($fatura->linhasfaturas) ?></p>
                                <p><strong>Data:</strong> <?= $fatura->dataEncomenda ?></p>
                                <p><strong>Custo total:</strong><?= $fatura->total ?>€</p>
                                <p><strong>Estado:</strong> <span class="badge bg-success"><?= $fatura->getEstadoLabel() ?></span></p>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-2">Ver detalhes</button>
                    </li>
                    <?php endforeach?>
                </ul>
            </div>
        </div>
    </div>
</div>

