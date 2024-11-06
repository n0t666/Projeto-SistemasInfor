<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Editora $model */

$this->title = 'Create Editora';
$this->params['breadcrumbs'][] = ['label' => 'Editoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
