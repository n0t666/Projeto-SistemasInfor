<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Jogo */

$this->title = $model->nome;

?>

<div class="container my-5 view-game">
    <div class="row">
        <div class="col-md-4 d-flex flex-column align-items-center">

            <div class="product-poster mb-4">
                <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $model->imagemCapa; ?>" alt="Game Poster"
                     class="img-fluid">
            </div>


            <div class="product-price mb-3">
                <span class="h3">59.99</span>
            </div>
            <div class="platform-dropdown mb-3 w-100">
                <label for="platform" class="form-label">Escolha uma plataforma:</label>
                <select id="platform" class="form-select">
                    <option>PC</option>
                    <option>PS5</option>
                    <option>Xbox</option>
                </select>
            </div>
            <div class="quantity-controls mb-3 w-100 d-flex justify-content-between align-items-center">
                <button class="btn btn-secondary" id="decrement">-</button>
                <span id="quantity" class="mx-3">1</span>
                <button class="btn btn-secondary" id="increment">+</button>
            </div>
            <div class="add-to-cart mb-3 w-100">
                <button class="btn btn-primary w-100 py-2">Adicionar ao carrinho</button>
            </div>


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


            <div class="avaliacoes mb-4">
                <h5>Avaliações</h5>
                <div class="rating-line mb-2"></div>
                <p>100 Avaliações</p>
                <div class="media-graphic mb-3">
                    <img src="game-media.jpg" alt="Game Media" class="img-fluid">
                </div>
                <div class="stars">
                    <span class="star">☆</span><span class="star">☆</span><span class="star">☆</span><span class="star">☆</span><span
                            class="star">☆</span>
                </div>
            </div>
        </div>

        <div class="col-md-4 interaction-holder">
            <div class="container py-5">
                <?php if (Yii::$app->user->can('adicionarFavoritos') || Yii::$app->user->can('adicionarJogados')): ?>
                <?php $form = ActiveForm::begin(['action' => ['utilizador-jogo/update']]); ?>
                <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <div class="row mb-4">
                    <div class="col-4 text-center">
                        <button type="submit" title="Adicionar aos Favoritos" class="btn btn-favorite <?= ($interaction && $interaction->isFavorito) ? 'ativo' : ''; ?>" name="action" value="1">
                            <i class="fas fa-heart"></i>
                        </button>
                        <p class="mb-0">Favorito</p>
                    </div>
                    <div class="col-4 text-center">
                        <button type="submit"  title="Adicionar aos Jogados"  class="btn btn-played <?= ($interaction && $interaction->isJogado) ? 'ativo' : ''; ?>" name="action" value="2" >
                            <i class="fas fa-check-circle"></i>
                        </button>
                        <p class="mb-0">Jogado</p>
                    </div>
                    <div class="col-4 text-center">
                        <button type="submit" title="Adicionar aos Desejados" class="btn btn-wishlist <?= ($interaction && $interaction->isDesejado) ? 'ativo' : ''; ?>" name="action" value="3">
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
                    <?php echo $form->field($avaliacao,'jogo_id')->hiddenInput(); ?>
                    <div class="col-12">
                        <?=StarRating::widget(['model' => $avaliacao, 'attribute' => 'numEstrelas',
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

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

