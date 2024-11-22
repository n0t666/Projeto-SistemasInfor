<?php

/* @var $this yii\web\View */
/* @var $model common\models\Avaliacao */

$this->title = 'Update Avaliacao: ' . $model->utilizador_id;
$this->params['breadcrumbs'][] = ['label' => 'Avaliacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->utilizador_id, 'url' => ['view', 'utilizador_id' => $model->utilizador_id, 'jogo_id' => $model->jogo_id]];
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