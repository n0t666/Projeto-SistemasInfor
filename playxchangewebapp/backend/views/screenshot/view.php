<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Screenshot */

$this->title = 'Screenshot: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Screenshots', 'url' => ['index', 'jogoId' => $model->jogo_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <!-- Display the screenshot image outside the DetailView -->
                    <?= Html::img(Yii::getAlias('@screenshotsJogoUrl' . '/' . $model->filename), [
                        'alt' => $model->filename,
                         'class' => 'img-fluid',
                         'style' => 'max-width: 80%; max-height: 400px; height: auto;'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            [
                                'label' => 'Jogo',
                                'attribute' => 'jogo_id',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->jogo->nome;

                                },
                            ],
                            [
                                'attribute' => 'filename',
                                'label' => 'Nome Ficheiro',
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <?= Html::a('Atualizar', ['update', 'id' => $model->id,'jogoId' => $model->jogo_id], [
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