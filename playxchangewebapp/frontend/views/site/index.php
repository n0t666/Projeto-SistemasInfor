<?php

/** @var yii\web\View $this */

$this->title = 'Página inicial';
?>
<div class="full-width">
    <div class="header-index d-flex align-items-center justify-content-center text-center text-white w-100">
        <div class="header-overlay"></div>
        <div class="header-content container-fluid">
            <h1 class="display-4 fw-bold">Gestão e Compra de Videojogos Facilitada</h1>
            <p class="lead">Organiza a tua coleção de videojogos e conecta-te com amigos.</p>
            <a href="/site/signup" class="btn btn-primary btn-lg mt-3">Cria a tua conta agora!</a>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () { // Após os elementos da página terem sido carregados, dar override no padding em que o conteúdo da página é gerado
        var content = document.getElementById('contentHolder');
        if (content) {
            content.style.paddingTop = "0";
        }
    });
</script>
