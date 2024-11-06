<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Publicadora $model */

$this->title = 'Create Publicadora';
$this->params['breadcrumbs'][] = ['label' => 'Publicadoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publicadora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
