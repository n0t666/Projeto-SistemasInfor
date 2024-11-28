<?php

use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Accordion;
use yii\widgets\ListView;
use yii\widgets\MaskedInput;

$this->title = 'Faturas';

$this->registerCssFile('@web/css/faturas.css', ['depends' => [BootstrapAsset::className()]]);


?>

<div class="container my-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="order-list p-4 rounded-3 shadow-lg">
                <h2 class="text-center mb-4">Lista de encomendas</h2>

                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_fatura',
                    'layout' => "{items}",
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-3">
    <?php
    echo \yii\bootstrap5\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);
    ?>
</div>
