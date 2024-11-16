<?php

/* @var $this yii\web\View */
/* @var $model common\models\MetodoPagamento */
/* @var $modelUpload UploadForm */

use common\models\UploadForm;

$this->title = 'Atualizar Método de Pagamento: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Metodo Pagamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'modelUpload' => $modelUpload
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>