<?php

use common\models\Plataforma;
use common\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Distribuidora;
use common\models\Editora;
use common\models\Franquia;

$this->registerCssFile('@web/css/jogoSearch.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);

?>

<div class="mb-4 jogo-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form',
        'options' => ['class' => 'row g-3'],
    ]); ?>

    <div class="col-md-12">
        <?= $form->field($searchModel, 'order')->dropDownList(
            ArrayHelper::map([
                ['id' => 'preco_asc', 'nome' => 'Preço (Menor para Maior)'],
                ['id' => 'preco_desc', 'nome' => 'Preço (Maior para Menor)'],
                ['id' => 'data_lancamento_asc', 'nome' => 'Data de Lançamento (Mais Antigo)'],
                ['id' => 'data_lancamento_desc', 'nome' => 'Data de Lançamento (Mais Recente)'],
                ['id' => 'nome_asc', 'nome' => 'Nome (A-Z)'],
                ['id' => 'nome_desc', 'nome' => 'Nome (Z-A)'],
                ['id' => 'popular_asc', 'nome' => 'Popularidade (Do Menos Popular ao Mais Popular)'],
                ['id' => 'popular_desc', 'nome' => 'Popularidade (Do Mais Popular ao Menos Popular)'],
            ], 'id', 'nome'),
            ['prompt' => 'Ordenar por', 'class' => 'form-select']
        )->label(false) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($searchModel, 'distribuidora_id')->dropDownList(
            ArrayHelper::map(Distribuidora::find()->all(), 'id', 'nome'),
            ['prompt' => 'Distribuidora', 'class' => 'form-select']
        )->label(false) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($searchModel, 'editora_id')->dropDownList(
            ArrayHelper::map(Editora::find()->all(), 'id', 'nome'),
            ['prompt' => 'Editora', 'class' => 'form-select']
        )->label(false) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($searchModel, 'franquia_id')->dropDownList(
            ArrayHelper::map(Franquia::find()->all(), 'id', 'nome'),
            ['prompt' => 'Franquia', 'class' => 'form-select']
        )->label(false) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($searchModel, 'plataforma_id')->dropDownList(
            ArrayHelper::map(Plataforma::find()->all(), 'id', 'nome'),
            ['prompt' => 'Plataforma', 'class' => 'form-select']
        )->label(false) ?>
    </div>


    <div class="col-md-12">
        <?= $form->field($searchModel, 'plataforma_id')->dropDownList(
            ArrayHelper::map(Plataforma::find()->all(), 'id', 'nome'),
            ['prompt' => 'Plataforma', 'class' => 'form-select']
        )->label(false) ?>
    </div>

    <div class="col-md-12 d-grid">
        <?= Html::submitButton('<i class="fas fa-search"></i> Filtrar', ['class' => 'btn btn-outline-primary btn-block']) ?>
    </div>

    <div class="col-md-12 d-grid">
        <?= Html::resetButton('<i class="fas fa-times"></i> Limpar', ['class' => 'btn btn-outline-danger btn-block','onclick' => 'resetForm()']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
