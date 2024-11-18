<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Denuncia */

$this->title = $model->denunciante_id;
$this->params['breadcrumbs'][] = ['label' => 'Denuncias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'denunciante_id' => $model->denunciante_id, 'denunciado_id' => $model->denunciado_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'denunciante_id' => $model->denunciante_id, 'denunciado_id' => $model->denunciado_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'denunciante_id',
                            'denunciado_id',
                            'motivo:ntext',
                            'dataDenuncia',
                            'estado',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>