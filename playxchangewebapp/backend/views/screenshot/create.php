<?php

use common\models\Jogo;
use common\models\MultiUploadForm;
use common\models\UploadForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Screenshot */
/* @var $modelUpload UploadForm */
/* @var $jogo Jogo */

$this->title = 'Criar Screenshot';
$this->params['breadcrumbs'][] = ['label' => 'Screenshots', 'url' => ['index','jogoId' => $jogo->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'modelUpload' => $modelUpload,
                        'jogo' => $jogo,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>