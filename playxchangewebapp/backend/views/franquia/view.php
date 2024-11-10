<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Franquia */

$this->title = 'Franquia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Franquias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'nome',
                        ],
                    ]) ?>
                </div>

                <!--.col-md-12-->
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <?= Html::a('Atualizar', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-primary btn-sm btn-block',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm btn-block',
                        'data' => [
                            'confirm' => 'Tem a certeza que deseja apagar?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->

</div>