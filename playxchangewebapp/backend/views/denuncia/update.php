<?php

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */

$this->title = 'Update Denuncia: ' . $model->denunciante_id;
$this->params['breadcrumbs'][] = ['label' => 'Denuncias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->denunciante_id, 'url' => ['view', 'denunciante_id' => $model->denunciante_id, 'denunciado_id' => $model->denunciado_id]];
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