<?php
use common\models\Distribuidora;
use common\models\Editora;
use common\models\Franquia;
use common\models\Genero;
use common\models\Tag;
use common\models\UploadForm;

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */

/* @var Franquia[] $franquias */
/* @var Distribuidora[] $distribuidoras */
/* @var Editora[] $editoras */
/* @var Tag[] $tags */
/* @var Genero[] $generos */
/* @var UploadForm $modelUploadCapa */

$this->title = 'Atualizar Jogo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jogos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'modelUploadCapa' => $modelUploadCapa,
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