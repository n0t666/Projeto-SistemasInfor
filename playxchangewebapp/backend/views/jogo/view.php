<?php

use yii\bootstrap4\Carousel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */

$this->title = 'Jogo: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Jogos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
\backend\assets\CustomAsset::register($this );
// $imageUrl = Yii::getAlias('@capasJogo') . '/' . $model->imagemCapa;
$imageUrl = Yii::getAlias('@capasJogoUrl') . '/'. $model->imagemCapa;

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php if ($model->imagemCapa): ?>
                <div class="jogo-capa mb-4 d-flex justify-content-center">
                    <img src="<?= $imageUrl ?>" class="img-fluid rounded shadow" alt="Imagem Capa">
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'nome',
                            [
                                'attribute' => 'dataLancamento',
                                'format' => ['date', 'php:d/m/Y'],
                            ],
                            'descricao:ntext',
                            [
                                'attribute' => 'trailerLink',
                                'value' => function ($model) {
                                    return \Yii::$app->formatter->asUrl($model->trailerLink, ['target' => '_blank']);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'franquia_id',
                                'value' => $model->franquia ? $model->franquia->nome : 'N/A',
                            ],
                            //'imagemCapa',
                            [
                                'attribute' => 'distribuidora_id',
                                'value' => $model->distribuidora->nome,
                                'label' => 'Distribuidora',
                            ],
                            [
                                'attribute' => 'editora_id',
                                'value' => $model->editora->nome,
                                'label' => 'Editora',
                            ],
                        ],
                    ]) ?>

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

                    <div class="mt-4">
                        <h5>Tags</h5>
                        <div class="badge-container">
                            <?php foreach ($model->tags as $tag): ?>
                                <span class="badge badge-primary badge-pill model-details-badge py-3"><?= Html::encode($tag->nome) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Géneros</h5>
                        <div class="badge-container-details">
                            <?php foreach ($model->generos as $genero): ?>
                                <span class="badge badge-danger badge-pill model-details-badge py-3"><?= Html::encode($genero->nome) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
    <div class="mt-4 mb-5">
        <h5>Capturas de Ecrã</h5>
        <?= Carousel::widget([
            'items' => array_map(function ($screenshot) {
                return [
                    'content' => Html::img(Yii::getAlias('@screenshotsJogoUrl') . '/' . $screenshot->filename, ['alt' => 'Screenshot', 'class' => 'd-block w-100 custom-img']),
                    'caption' => '',  // Optional: Add captions if needed
                ];
            }, $model->screenshots),
            'options' => [
                'class' => 'carousel slide custom-carousel',
            ],
            'controls' => ['Anterior', 'Próxima'],
        ]); ?>
    </div>




</div>