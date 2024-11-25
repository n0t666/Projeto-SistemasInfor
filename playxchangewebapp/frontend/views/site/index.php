<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Página inicial';
?>
<div class="full-width mt-5">
    <div class="header-index d-flex align-items-center justify-content-center text-center text-white w-100">
        <div class="header-overlay"></div>
        <div class="header-content container-fluid">
            <h1 class="display-4 fw-bold">Gestão e Compra de Videojogos Facilitada</h1>
            <p class="lead">Organiza a tua coleção de videojogos e conecta-te com amigos.</p>
            <?= Html::a('Cria a tua conta agora!', ['/site/signup'], ['class' => 'btn btn-primary btn-lg mt-3']); ?>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card game-card">
                <img src="https://cdn.europosters.eu/image/750/posters/guardins-of-the-galaxy-video-game-i122525.jpg" class="game-poster img-fluid" alt="Game Poster 3">
                <div class="center-links">
                    <a href="#" class="play-now">
                        <i class="fas fa-play"></i> Play Now
                    </a>
                    <a href="#" class="view-details">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card game-card">
                <img src="https://cdn.europosters.eu/image/750/posters/guardins-of-the-galaxy-video-game-i122525.jpg" class="game-poster img-fluid" alt="Game Poster 3">
                <div class="center-links">
                    <a href="#" class="play-now">
                        <i class="fas fa-play"></i> Play Now
                    </a>
                    <a href="#" class="view-details">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card game-card">
                <img src="https://cdn.europosters.eu/image/750/posters/guardins-of-the-galaxy-video-game-i122525.jpg" class="game-poster img-fluid" alt="Game Poster 3">
                <div class="center-links">
                    <a href="#" class="play-now">
                        <i class="fas fa-play"></i> Play Now
                    </a>
                    <a href="#" class="view-details">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card game-card">
                <img src="https://cdn.europosters.eu/image/750/posters/guardins-of-the-galaxy-video-game-i122525.jpg" class="game-poster img-fluid" alt="Game Poster 3">
                <div class="center-links">
                    <a href="#" class="play-now">
                        <i class="fas fa-play"></i> Play Now
                    </a>
                    <a href="#" class="view-details">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
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
