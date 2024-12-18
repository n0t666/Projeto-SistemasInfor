<?php
/* @var $model common\models\Fatura */

use yii\helpers\Url;

$primProduto = $model->linhasfaturas[0]->produto->jogo;
?>

<li class="order-item d-flex justify-content-between align-items-start mb-3 p-3 rounded-2">
    <div class="order-details d-flex align-items-center">
        <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $primProduto->imagemCapa ?>" alt="Game Poster" class="order-poster rounded-2 me-3" />
        <div>
            <h5>Encomenda #<?= $model->id ?></h5>
            <p><strong>Total de Itens:</strong> <?= count($model->linhasfaturas) ?></p>
            <p><strong>Data:</strong> <?= $model->getDataEncomenda() ?></p>
            <p><strong>Custo total:</strong> <?= $model->total ?>€</p>
            <p><strong>Estado:</strong> <span class="badge bg-success"><?= $model->getEstadoLabel() ?></span></p>
        </div>
    </div>
    <a class="btn btn-outline-primary mt-2" href="<?= Url::to(['view', 'id' => $model->id]) ?>">Ver detalhes</a>
</li>