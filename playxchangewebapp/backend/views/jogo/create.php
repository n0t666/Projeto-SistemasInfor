<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Jogo $model */
/** @var \common\models\Tag[] $tags  */

$this->title = 'Create Jogo';
$this->params['breadcrumbs'][] = ['label' => 'Jogos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="jogo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'tags' => $tags
    ]) ?>

</div>
