<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Acerca';

$this->registerCssFile('@web/css/about.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className(),\hail812\adminlte3\assets\FontAwesomeAsset::className()]]);


?>
<div class="site-about">
    <div class="container py-5">
        <div class="section-title">Acerca</div>

        <div class="row">
            <div class="col-12">
                <p>Este é um <strong>projeto universitário</strong> que visa incorporar tanto a vertente social como a de compra de <span class="highlight">videogogos</span> em uma única plataforma, desenvolvida por um único membro. O objetivo é criar um espaço onde os utilizadores possam <span class="highlight">interagir socialmente</span> enquanto exploram e adquirem os seus jogos preferidos. No entanto, o projeto ainda está em <em>fase de testes</em> e tem muito a melhorar.</p>
        </div>

        <div class="section-line"></div>

        <div class="social-media-icons">
            <a href="https://www.facebook.com" target="_blank" class="fab fa-facebook"></a>
            <a href="https://twitter.com" target="_blank" class="fab fa-twitter"></a>
            <a href="https://www.instagram.com" target="_blank" class="fab fa-instagram"></a>
            <a href="https://www.linkedin.com" target="_blank" class="fab fa-linkedin"></a>
        </div>

        <!-- Google Map -->
        <div class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3068.2319950550077!2d-8.821043300000001!3d39.7344393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22735a4e067afb%3A0xcfaf619f4450fa76!2sPolit%C3%A9cnico%20de%20Leiria%20%7C%20ESTG%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o_Edif%C3%ADcio%20D!5e0!3m2!1spt-PT!2spt!4v1732933712526!5m2!1spt-PT!2spt" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
