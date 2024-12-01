<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="d-flex align-items-center justify-content-center py-100 mt-5">
        <div class="text-center">
            <h1 class="display-1 fw-bold"><?= Html::encode($exception->statusCode) ?></h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Erro na página</p>
            <p class="lead">
                Ocorreu um problema ao processar o seu pedido
            </p>
            <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary w-100 text-uppercase']) ?>
        </div>
    </div>
</div>
