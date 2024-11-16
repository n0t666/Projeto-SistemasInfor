<?php

/* @var $this yii\web\View */
/* @var $model common\models\MetodoEnvio */

$this->title = 'Atualizar Método de Envio: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Métdos de Envio', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>