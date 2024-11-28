<?php

/** @var yii\web\View $this */

use backend\controllers\UtilsController;
use practically\chartjs\widgets\Chart;
use yii\bootstrap5\Html;

$this->title = 'Página inicial';
?>
<div class="full-width mt-5">
    <div class="header-index d-flex align-items-center justify-content-center text-center text-white w-100">
        <div class="header-overlay"></div>
        <div class="header-content container-fluid">
            <?php if(Yii::$app->user->isGuest): ?>
            <h1 class="display-4 fw-bold">Gestão e Compra de Videojogos Facilitada</h1>
            <p class="lead">Organiza a tua coleção de videojogos e conecta-te com amigos.</p>
            <?= Html::a('Cria a tua conta agora!', ['/site/signup'], ['class' => 'btn btn-primary btn-lg mt-3']); ?>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row g-4">
        <?php foreach ($jogos as $jogo): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card game-card">
                    <img src="<?= Yii::getAlias('@capasJogoUrl') . '/' . $jogo->imagemCapa; ?>" class="game-poster img-fluid">
                    <div class="center-links">
                        <div class="game-stats">
                        <span class="played">
                            <i class="fas fa-play"></i>
                            <?= UtilsController::number_format_short($jogo->getNumJogados()) ?>
                        </span>
                            <span class="wishlisted">
                            <i class="fas fa-heart"></i>
                            <?= UtilsController::number_format_short($jogo->getNumFavoritos()) ?>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () { // Após os elementos da página terem sido carregados, dar override no padding em que o conteúdo da página é gerado
        var content = document.getElementById('contentHolder');
        var search = document.getElementById('search_input_box');


        if (content) {
            content.style.paddingTop = "0";
        }

        if(search){
            console.log(search);
            search.style.paddingTop = "100px";
        }
    });





</script>
