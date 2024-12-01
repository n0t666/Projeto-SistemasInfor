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

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>'denunciante_id',
                                'value'=>function($model){
                                    return $model->denunciante->user->username;
                                }
                            ],
                            [
                                'attribute'=>'denunciado_id',
                                'content'=>function($model){
                                    return $model->denunciado->user->username;
                                }
                            ],
                            'motivo:ntext',
                            'dataDenuncia',
                            [
                                'attribute'=>'estado',
                                'value'=>function($model){
                                    return $model->getStatusLabel();
                                }
                            ],
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->

            </div>
            <?php if($model->estado == \common\models\Denuncia::STATUS_PROCESSING): ?>
            <div class="row mt-4">
                <div class="col-md-6">
                    <?= Html::a('Aprovar', ['aprovar-denuncia', 'denunciante_id' => $model->denunciante->id, 'denunciado_id' => $model->denunciado->id, 'aprovado' => true], [
                        'class' => 'btn btn-danger btn-sm btn-block',
                        'data' => [
                            'confirm' => 'Tem a certeza que deseja banir o utilizador?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= Html::a('Recusar', ['aprovar-denuncia', 'denunciante_id' => $model->denunciante->id, 'denunciado_id' => $model->denunciado->id, 'aprovado' => false], [
                        'class' => 'btn btn-primary btn-sm btn-block',
                    ]) ?>
                </div>
            </div>
            <?php endif; ?>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>