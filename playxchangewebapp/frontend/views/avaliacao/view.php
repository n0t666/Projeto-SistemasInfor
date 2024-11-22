<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Avaliacao */

$this->title = $model->utilizador_id;
$this->params['breadcrumbs'][] = ['label' => 'Avaliacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'utilizador_id' => $model->utilizador_id, 'jogo_id' => $model->jogo_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'utilizador_id' => $model->utilizador_id, 'jogo_id' => $model->jogo_id], [
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
                            'utilizador_id',
                            'jogo_id',
                            'numEstrelas',
                            'dataAvaliacao',
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