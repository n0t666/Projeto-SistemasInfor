<?php

/* @var $this yii\web\View */
/* @var $model common\models\Produto */

/* @var Jogo[] $jogos */
/* @var Plataforma[] $plataformas */

use common\models\Jogo;
use common\models\Plataforma;

$this->title = 'Atualizar Produto: ' . $model->jogo->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->jogo->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'jogos' => $jogos,
                        'plataformas' => $plataformas,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>