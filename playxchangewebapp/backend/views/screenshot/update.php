<?php

use common\models\Jogo;
use common\models\UploadForm;

/* @var $this yii\web\View */
/* @var $model common\models\Screenshot */
/* @var $jogo Jogo */
/* @var $modelUpload UploadForm */

$this->title = 'Atualizar Screenshot: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Screenshots', 'url' => ['index']];
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
                        'modelUpload' => $modelUpload,
                        'jogo' => $jogo
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>