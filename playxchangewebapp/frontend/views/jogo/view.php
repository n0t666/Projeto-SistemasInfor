<?php

use backend\assets\ChartJsAsset;
use kartik\rating\StarRating;
use practically\chartjs\widgets\Chart;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */

$this->registerJsFile(
    '@web/js/jogoview.js',
    ['depends' => [JqueryAsset::class]]
);


$this->title = $model->nome;

?>

<div class="container my-5 view-game">
    <div class="row">
        <div class="col-md-4 d-flex flex-column align-items-center">

            <div class="product-poster mb-2">
                <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $model->imagemCapa; ?>" alt="Game Poster"
                     class="img-fluid">
            </div>

            <div class="mb-2">
                <span class="h3" id="product-price"></span>
            </div>
            <?php if (Yii::$app->user->can('adicionarItensCarrinho')): ?>
                <div class="platform-dropdown mb-3 w-100">
                    <?php $form = ActiveForm::begin(['id' => 'jogo-carrinho', 'action' => ['linha-carrinho/create']]); ?>
                    <?= $form->field($itemCarrinho, 'produtos_id')->dropDownList(
                        ArrayHelper::map($produtos, 'id', function ($produto) {
                            return $produto->plataforma->nome;
                        }),
                        [
                            'prompt' => 'Selecione a plataforma',
                            'class' => 'form-select',
                            'required' => true,
                            'id' => 'plataforma-dropdown',
                            'options' => array_reduce($produtos, function ($result, $produto) { //Obter o preço para cada produto dependendo da plataforma (através do array_reduce transformar um array num único valor)
                                $result[$produto->plataforma_id] = ['data-preco' => $produto->preco]; //Adicionar um atributo no html para aceder depois no java
                                return $result;
                            }, [])
                        ]
                    )->label(false) ?>
                </div>
                <div class="quantity-controls mb-3 w-100 d-flex justify-content-between align-items-center">
                    <button class="btn btn-outline-primary" id="decrement" type="button"
                            style="width: 40px; height: 40px; font-size: 20px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-minus"></i>
                    </button>

                    <?= $form->field($itemCarrinho, 'quantidade')->input('number', [
                        'class' => 'form-control text-center mx-2',
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                        'value' => 1,
                        'aria-label' => 'Quantidade',
                        'style' => 'flex-grow: 1; height: 40px; font-size: 18px; border-radius: 0;',
                        'inputmode' => 'numeric',
                        'oninput' => 'this.value = this.value.replace(/\D+/g, "")',
                        'required' => true,
                    ])->label(false) ?>

                    <button class="btn btn-outline-primary" id="increment" type="button"
                            style="width: 40px; height: 40px; font-size: 20px; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="mb-3 w-100">
                    <button class="cart-button w-100">
                        <span class="add-to-cart">Adicionar ao carrinho</span>
                        <span class="added">Adicionado</span>
                        <i class="fas fa-shopping-cart"></i>
                        <i class="fas fa-box"></i>
                    </button>
                </div>
                <?php ActiveForm::end(); ?>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <h2 class="game-name mb-3"><?= $model->nome ?></h2>
            <p class="release-date mb-3"><?= $model->dataLancamento ?></p>
            <p class="game-description mb-4"><?= $model->descricao ?></p>

            <div class="toggle-details mb-3">
                <ul class="nav nav-pills mb-0" id="gameTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="detalhes-tab" data-bs-toggle="pill" href="#detalhes" role="tab"
                           aria-controls="detalhes" aria-selected="true">Detalhes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="generos-tab" data-bs-toggle="pill" href="#generos" role="tab"
                           aria-controls="generos" aria-selected="false">Géneros</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tags-tab" data-bs-toggle="pill" href="#tags" role="tab"
                           aria-controls="tags" aria-selected="false">Tags</a>
                    </li>
                </ul>
                <div class="tab-underline"></div>

                <div class="tab-content py-3" id="gameTabContent">
                    <div class="tab-pane fade show active" id="detalhes" role="tabpanel" aria-labelledby="detalhes-tab">
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-auto">
                                    <h5 class="fw-bold"><i class="fas fa-building"></i> Editora:</h5>
                                </div>
                                <div class="col">
                                    <p class="text-muted"><?= $model->editora->nome ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <h5 class="fw-bold"><i class="fas fa-briefcase"></i> Distribuidora:</h5>
                                </div>
                                <div class="col">
                                    <p class="text-muted"><?= $model->distribuidora->nome ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="generos" role="tabpanel" aria-labelledby="generos-tab">
                        <div class="row">
                            <div class="col-auto">
                                <h5 class="fw-bold"><i class="fas fa-tags"></i> Gêneros:</h5>
                            </div>
                            <div class="col">
                                <ul class="list-inline">
                                    <?php foreach ($model->generos as $genero): ?>
                                        <li class="list-inline-item badge bg-dark"><?= $genero->nome ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">
                        <div class="row">
                            <div class="col-auto">
                                <h5 class="fw-bold"><i class="fas fa-tag"></i> Tags:</h5>
                            </div>
                            <div class="col">
                                <ul class="list-inline">
                                    <?php foreach ($model->tags as $tag): ?>
                                        <li class="list-inline-item badge bg-dark"><?= $tag->nome ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="screenshots mb-4">
                <?= \yii\bootstrap5\Carousel::widget([
                    'items' => array_map(function ($screenshot) {
                        return [
                            'content' => Html::img(Yii::getAlias('@screenshotsJogoUrl') . '/' . $screenshot->filename, ['alt' => 'Screenshot', 'class' => 'd-block w-100 custom-img']),
                            'caption' => '',
                        ];
                    }, $model->screenshots),
                ])
                ?>
            </div>
        </div>

        <div class="col-md-4 interaction-holder">
            <div class="container py-5 rounded-3">
                <?php if (Yii::$app->user->can('adicionarFavoritos') || Yii::$app->user->can('adicionarJogados')): ?>
                    <?php $form = ActiveForm::begin(['action' => ['utilizador-jogo/update']]); ?>
                    <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>
                    <div class="row mb-4">
                        <div class="col-4 text-center">
                            <button type="submit" title="Adicionar aos Favoritos"
                                    class="btn btn-favorite <?= ($interaction && $interaction->isFavorito) ? 'ativo' : ''; ?>"
                                    name="action" value="1">
                                <i class="fas fa-heart"></i>
                            </button>
                            <p class="mb-0">Favorito</p>
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" title="Adicionar aos Jogados"
                                    class="btn btn-played <?= ($interaction && $interaction->isJogado) ? 'ativo' : ''; ?>"
                                    name="action" value="2">
                                <i class="fas fa-check-circle"></i>
                            </button>
                            <p class="mb-0">Jogado</p>
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" title="Adicionar aos Desejados"
                                    class="btn btn-wishlist <?= ($interaction && $interaction->isDesejado) ? 'ativo' : ''; ?>"
                                    name="action" value="3">
                                <i class="fas fa-star"></i>
                            </button>
                            <p class="mb-0">Desejado</p>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                <?php endif; ?>

                <div class="row mb-4 text-center">
                    <?php $form = ActiveForm::begin([
                        'id' => 'avaliacao-form',
                        'action' => ['avaliacao/avaliar'],
                    ]); ?>
                    <?php echo $form->field($avaliacao, 'jogo_id')->hiddenInput(); ?>
                    <div class="col-12">
                        <?= StarRating::widget(['model' => $avaliacao, 'attribute' => 'numEstrelas',
                            'name' => 'rating_35',
                            'value' => 3,
                            'pluginOptions' => [
                                'size' => 'lg',
                                'showClear' => true,
                                'showCaption' => false,
                                'theme' => 'krajee-uni',
                                'filledStar' => '★',
                                'emptyStar' => '☆'
                            ]
                        ]); ?>
                    </div>
                    <div class="col-12 text-center">
                        <?= Html::submitButton('Guardar Avaliação', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-12 text-center py-2">
                        <?= Html::button('Escrever Avaliação', ['class' => 'btn btn-primary reviewButton']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>Reviews</h1>

        </div>
    </div>

</div>

<?php

Modal::begin([
    'title' => 'Escrever avaliação',
    'id' => 'modal-review',
    'options' => ['class' => 'modal fade ']
]);
echo "<div id='modalContent'>";
echo $this->render('/comentario/_form', ['model' => $review,'jogoId' => $model->id]);
echo "</div>";
Modal::end();


?>

