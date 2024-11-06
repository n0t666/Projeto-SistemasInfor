<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Editora $model */

$this->title = 'Update Editora: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Editoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="editora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
