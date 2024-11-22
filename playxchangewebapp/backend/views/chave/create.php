<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Chave */

$this->title = 'Criar Chave';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'produtos' => $produtos,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>