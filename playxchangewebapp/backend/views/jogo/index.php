<?php

use common\models\Jogo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Jogos';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="jogo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jogo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'dataLancamento',
            'descricao:ntext',
            'trailerLink',
            //'franquia_id',
            //'imagemCapa',
            //'publicadora_id',
            //'editora_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Jogo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],

    ]); ?>


</div>
