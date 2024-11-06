<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Publicadora $model */

$this->title = 'Update Publicadora: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Publicadoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publicadora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
