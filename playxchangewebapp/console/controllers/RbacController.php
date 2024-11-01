<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public  function actionInit()
    {
        $auth = Yii::$app->authManager;

        $adicionarFranquias = $auth->createPermission('adicionarFranquias');
        $removerFranquias = $auth->createPermission('removerFranquias');
        $editarFranquias = $auth->createPermission('editarFranquias');

        $adicionarEditoras = $auth->createPermission('adicionarEditoras');
        $removerEditoras = $auth->createPermission('removerEditoras');
        $editarEditoras = $auth->createPermission('editarEditoras');


        $adicionarScreenshots = $auth->createPermission('adicionarScreenshots');
        $removerScreenshots = $auth->createPermission('removerScreenshots');
        $editarScreenshots = $auth->createPermission('editarScreenshots');


        $adicionarTags = $auth->createPermission('adicionarTags');
        $removerTags = $auth->createPermission('removerTags');
        $editarTags = $auth->createPermission('editarTags');


        $adicionarGeneros = $auth->createPermission('adicionarGeneros');
        $removerGeneros = $auth->createPermission('removerGeneros');
        $editarGeneros = $auth->createPermission('editarGeneros');


        $adicionarPublicadoras = $auth->createPermission('adicionarPublicadoras');
        $removerPublicadoras = $auth->createPermission('removerPublicadoras');
        $editarPublicadoras = $auth->createPermission('editarPublicadoras');

        $adicionarCodigosProm = $auth->createPermission('adicionarCodigosProm');
        $usarCodigosProm = $auth->createPermission('usarCodigosProm');
        $editarCodigosProm = $auth->createPermission('editarCodigosProm');
        $apagarCodigosProm = $auth->createPermission('apagarCodigosProm');
        $ativarCodigosProm = $auth->createPermission('ativarCodigosProm');
        $desativarCodigosProm = $auth->createPermission('desativarCodigosProm');


        $adicionarMetodosEnvio = $auth->createPermission('adicionarMetodosEnvio');
        $removerMetodosEnvio = $auth->createPermission('removerMetodosEnvio');
        $editarMetodosEnvio = $auth->createPermission('editarMetodosEnvio');

        $adicionarMetodosPagamento = $auth->createPermission('adicionarMetodosPagamento');
        $removerMetodosPagamento = $auth->createPermission('removerMetodosPagamento');
        $editarMetodosPagamento = $auth->createPermission('editarMetodosPagamento');

        $adicionarJogos = $auth->createPermission('adicionarJogos');
        $removerJogos = $auth->createPermission('removerJogos');
        $editarJogos = $auth->createPermission('editarJogos');



        $adicionarProdutos = $auth->createPermission('adicionarProdutos');
        $removerProdutos = $auth->createPermission('removerProdutos');
        $editarProdutos = $auth->createPermission('editarProdutos');


        $adicionarFaq = $auth->createPermission('adicionarFaq');
        $removerFaq = $auth->createPermission('removerFaq');
        $editarFaq = $auth->createPermission('editarFaq');

        $visualizarPerfil = $auth->createPermission('visualizarPerfil');
        $visualizarPerfil->description = 'Visualizar perfil público';
        $editarDetalhesPerfil = $auth->createPermission('editarDetalhesPerfil');
        $editarDetalhesPerfil ->description = 'Editar todos os detalhes associados ao perfil público';
        $editarDetalhesUtilizador = $auth->createPermission('editarDetalhesUtilizador');
        $editarDetalhesUtilizador -> description = 'Editar detalhes própios';
        $editarDetalhesUtilizadores = $auth->createPermission('editarDetalhesUtilizadores');
        $editarDetalhesUtilizadores -> description = 'Editar detalhes de todos os utilizadores na plataforma (Backend)';

        $destacarJogosPerfil = $auth->createPermission('destacarJogosPerfil');

        $adicionarPlataformas = $auth->createPermission('adicionarPlataformas');
        $removerPlataformas = $auth->createPermission('removerPlataformas');
        $editarPlataformas = $auth->createPermission('editarPlataformas');

        $adicionarCarrinho = $auth->createPermission('adicionarItensCarrinho');
        $removerCarrinho = $auth->createPermission('removerItensCarrinho');
        $editarCarrinho = $auth->createPermission('editarItensCarrinho');
        $visualizarCarrinho = $auth->createPermission('visualizarItensCarrinho');

        $criarListas = $auth->createPermission('adicionarListas');
        $removerListas = $auth->createPermission('removerListas');
        $adicionarJogosListas = $auth->createPermission('adicionarJogosListas');
        $editarListas = $auth->createPermission('editarListas');
        $definirPrivacidadeListas = $auth->createPermission('definirPrivacidadeListas');
        $definirPrivacidadeGostos= $auth->createPermission('definirPrivacidadeGostos');
        $definirPrivacidadeFavoritos= $auth->createPermission('definirPrivacidadeFavoritos');
        $definirPrivacidadeJogados = $auth->createPermission('definirPrivacidadeJogados');
        $alterarDisposicao =  $auth->createPermission('alterarDiposicao');

        $avaliarJogo = $auth->createPermission('avaliarJogo');
        $editarAvaliacao = $auth->createPermission('editarAvaliacao');
        $apagarAvaliacao = $auth->createPermission('apagarAvaliacao');

        $apagarComentario = $auth->createPermission('apagarComentario');
        $escreverComentario = $auth->createPermission('escreverComentario');
        $gostarComentario = $auth->createPermission('gostarComentario');
        $gostarLista = $auth->createPermission('gostarLista');

        $seguirUtilizador = $auth->createPermission('seguirUtilizador');
        $deixarSeguir = $auth->createPermission('deixarSeguir');
        $bloquearUtilizador = $auth->createPermission('bloquearUtilizador');
        $banirUtilizador = $auth->createPermission('banirUtilizador');
        $denunciarUtilizador = $auth->createPermission('denunciarUtilizador');
        $avaliarSugestao = $auth->createPermission('avaliarSugestao');
        $efetuarCompras =  $auth->createPermission('efetuarCompras');

        $alterarEstadoDenuncia = $auth->createPermission('alterarEstadoDenuncia');
        $alterarEstadoEncomenda = $auth->createPermission('alterarEstadoEncomenda');
        $alterarEstadoSugestao = $auth->createPermission('alterarEstadoSugestao');

        $criarChaves = $auth->createPermission('criarChaves');
        $editarChaves = $auth->createPermission('editarChaves');
        $apagarChaves = $auth->createPermission('apagarChaves');

        $reporPassword = $auth->createPermission('reporPassword');

        $criarSugestao = $auth->createPermission('criarSugestao');
        $editarSugestao = $auth->createPermission('editarSugestao');
        $apagarSugestao =  $auth->createPermission('apagarSugestao');

        $adicionarFavoritos = $auth->createPermission('adicionarFavoritos');
        $removerFavoritos = $auth->createPermission('removerFavoritos');

        $adicionarDesejados = $auth->createPermission('adicionarDesejados');
        $removerDesejados = $auth->createPermission('removerDesejados');

        $adicionarJogados= $auth->createPermission('adicionarJogados');
        $removerJogados= $auth->createPermission('removerJogados');
        $visualizarTudo = $auth->createPermission('verTudo');
        $cancelarEncomenda = $auth->createPermission('cancelarEncomenda');

        $cliente = $auth->createRole('cliente');
        $cliente->addChild($cliente, $usarCodigosProm);
        $cliente->addChild($cliente, $visualizarPerfil);
        $cliente->addChild($cliente, $editarDetalhesPerfil);
        $cliente->addChild($cliente, $editarDetalhesUtilizador);
        $cliente->addChild($cliente, $destacarJogosPerfil);
        $cliente->addChild($cliente, $adicionarCarrinho);
        $cliente->addChild($cliente, $removerCarrinho);
        $cliente->addChild($cliente, $editarCarrinho);
        $cliente->addChild($cliente, $visualizarCarrinho);
        $cliente->addChild($cliente, $criarListas);
        $cliente->addChild($cliente, $removerListas);
        $cliente->addChild($cliente, $adicionarJogosListas);
        $cliente->addChild($cliente, $editarListas);
        $cliente->addChild($cliente, $definirPrivacidadeListas);
        $cliente->addChild($cliente, $definirPrivacidadeGostos);
        $cliente->addChild($cliente, $definirPrivacidadeFavoritos);
        $cliente->addChild($cliente, $definirPrivacidadeJogados);
        $cliente->addChild($cliente, $alterarDisposicao);
        $cliente->addChild($cliente, $avaliarJogo);
        $cliente->addChild($cliente, $editarAvaliacao);
        $cliente->addChild($cliente, $apagarAvaliacao);
        $cliente->addChild($cliente, $apagarComentario);
        $cliente->addChild($cliente, $escreverComentario);
        $cliente->addChild($cliente, $gostarComentario);
        $cliente->addChild($cliente, $gostarLista);
        $cliente->addChild($cliente, $seguirUtilizador);
        $cliente->addChild($cliente, $deixarSeguir);
        $cliente->addChild($cliente, $bloquearUtilizador);
        $cliente->addChild($cliente, $denunciarUtilizador);
        $cliente->addChild($cliente, $avaliarSugestao);
        $cliente->addChild($cliente, $efetuarCompras);
        $cliente->addChild($cliente, $reporPassword);
        $cliente->addChild($cliente, $criarSugestao);
        $cliente->addChild($cliente, $editarSugestao);
        $cliente->addChild($cliente, $apagarSugestao);
        $cliente->addChild($cliente, $adicionarFavoritos);
        $cliente->addChild($cliente, $removerFavoritos);
        $cliente->addChild($cliente, $adicionarDesejados);
        $cliente->addChild($cliente, $removerDesejados);
        $cliente->addChild($cliente, $adicionarJogados);
        $cliente->addChild($cliente, $removerJogados);
        $auth->add($cliente);

        $vendedor = $auth->createRole('vendedor');
        $vendedor->addChild($vendedor, $adicionarProdutos);
        $vendedor->addChild($vendedor,$removerProdutos);
        $vendedor->addChild($vendedor,$editarProdutos);
        $vendedor->addChild($vendedor,$cancelarEncomenda);
        $vendedor->addChild($vendedor,$visualizarTudo);
        $auth->add($vendedor);

        $moderador = $auth->createRole('moderador');
        $moderador->addChild($moderador,$removerListas);
        $moderador->addChild($moderador,$apagarAvaliacao);
        $moderador->addChild($moderador,$apagarComentario);
        $moderador->addChild($moderador,$apagarSugestao);
        $moderador->addChild($moderador,$banirUtilizador);

        $moderador->addChild($moderador,$alterarEstadoDenuncia);
        $moderador->addChild($moderador,$alterarEstadoEncomenda);
        $moderador->addChild($moderador,$alterarEstadoSugestao);
        $moderador->addChild($moderador,$visualizarTudo);
        $auth->add($moderador);

        $admin = $auth->createRole('admin');

        // Herdar de vendedor e moderador
        $admin->addChild($admin,$vendedor);
        $admin->addChild($admin,$moderador);

        $admin->addChild($admin,$adicionarFranquias);
        $admin->addChild($admin,$removerFranquias);
        $admin->addChild($admin,$editarFranquias);

        $admin->addChild($admin,$adicionarEditoras);
        $admin->addChild($admin,$removerEditoras );
        $admin->addChild($admin,$editarEditoras);

        $admin->addChild($admin,$adicionarScreenshots);
        $admin->addChild($admin,$removerScreenshots);
        $admin->addChild($admin,$editarScreenshots);

        $admin->addChild($admin,$adicionarTags);
        $admin->addChild($admin,$removerTags);
        $admin->addChild($admin,$editarTags);

        $admin->addChild($admin,$adicionarGeneros );
        $admin->addChild($admin,$removerGeneros);
        $admin->addChild($admin,$editarGeneros);

        $admin->addChild($admin, $adicionarPublicadoras);
        $admin->addChild($admin,$removerPublicadoras);
        $admin->addChild($admin,$editarPublicadoras);

        $admin->addChild($admin,$adicionarCodigosProm);
        $admin->addChild($admin,$apagarCodigosProm);
        $admin->addChild($admin,$editarCodigosProm);
        $admin->addChild($admin,$usarCodigosProm);
        $admin->addChild($admin,$ativarCodigosProm);
        $admin->addChild($admin,$desativarCodigosProm);

        $admin->addChild($admin,$adicionarMetodosEnvio);
        $admin->addChild($admin,$removerMetodosEnvio);
        $admin->addChild($admin,$editarMetodosEnvio);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarJogos);
        $admin->addChild($admin,$removerJogos);
        $admin->addChild($admin,$editarJogos);

        $admin->addChild($admin, $adicionarFaq);
        $admin->addChild($admin,$removerFaq);
        $admin->addChild($admin,$editarFaq);

        $admin->addChild($admin, $editarDetalhesUtilizadores);


        $admin->addChild($admin, $adicionarPlataformas);
        $admin->addChild($admin,$removerPlataformas);
        $admin->addChild($admin,$editarPlataformas);

        $admin->addChild($admin, $criarListas);
        $admin->addChild($admin,$removerListas);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $adicionarMetodosPagamento);
        $admin->addChild($admin,$removerMetodosPagamento);
        $admin->addChild($admin,$editarMetodosPagamento);

        $admin->addChild($admin, $criarChaves);
        $admin->addChild($admin,$editarChaves);
        $admin->addChild($admin,$apagarChaves);


        $auth->add($admin);



    }

}