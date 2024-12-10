<?php

use common\models\Jogo;
use common\models\Plataforma;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Produto */

/* @var Jogo[] $jogos */
/* @var Plataforma[] $plataformas */

$this->title = 'Criar Produto para o Jogo: ' . $model->jogo->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'plataformas' => $plataformas,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>