<?php

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */

/* @var Franquia[] $franquias */
/* @var Distribuidora[] $distribuidoras */
/* @var Editora[] $editoras */
/* @var Tag[] $tags */
/* @var Genero[] $generos */

$this->title = 'Atualizar Jogo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'franquias' => $franquias,
                        'distribuidoras'=>$distribuidoras,
                        'editoras'=>$editoras,
                        'tags'=>$tags,
                        'generos' => $generos,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>