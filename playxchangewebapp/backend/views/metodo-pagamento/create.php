<?php

use common\models\UploadForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MetodoPagamento */
/* @var $modelUpload UploadForm */

$this->title = 'Criar Método de Pagamento';
$this->params['breadcrumbs'][] = ['label' => 'Metodo Pagamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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