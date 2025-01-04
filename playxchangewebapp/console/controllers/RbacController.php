<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public  function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adicionarFranquias = $auth->createPermission('adicionarFranquias');
        $removerFranquias = $auth->createPermission('removerFranquias');
        $editarFranquias = $auth->createPermission('editarFranquias');
        $verDetalhesFranquias = $auth->createPermission('verDetalhesFranquias');
        $auth->add($adicionarFranquias);
        $auth->add($removerFranquias);
        $auth->add($editarFranquias);
        $auth->add($verDetalhesFranquias);

        $verDetalhesEditoras = $auth->createPermission('verDetalhesEditoras');
        $adicionarEditoras = $auth->createPermission('adicionarEditoras');
        $removerEditoras = $auth->createPermission('removerEditoras');
        $editarEditoras = $auth->createPermission('editarEditoras');
        $auth->add($adicionarEditoras);
        $auth->add($removerEditoras);
        $auth->add($editarEditoras);
        $auth->add($verDetalhesEditoras);


        $verDetalhesScreenshots = $auth->createPermission('verDetalhesScreenshots');
        $adicionarScreenshots = $auth->createPermission('adicionarScreenshots');
        $removerScreenshots = $auth->createPermission('removerScreenshots');
        $editarScreenshots = $auth->createPermission('editarScreenshots');
        $auth->add($adicionarScreenshots);
        $auth->add($removerScreenshots);
        $auth->add($editarScreenshots);
        $auth->add($verDetalhesScreenshots);


        $verDetalhesTags = $auth->createPermission('verDetalhesTags');
        $adicionarTags = $auth->createPermission('adicionarTags');
        $removerTags = $auth->createPermission('removerTags');
        $editarTags = $auth->createPermission('editarTags');
        $auth->add($adicionarTags);
        $auth->add($removerTags);
        $auth->add($editarTags);
        $auth->add($verDetalhesTags);

        $verDetalhesGeneros = $auth->createPermission('verDetalhesGeneros');
        $adicionarGeneros = $auth->createPermission('adicionarGeneros');
        $removerGeneros = $auth->createPermission('removerGeneros');
        $editarGeneros = $auth->createPermission('editarGeneros');
        $auth->add($adicionarGeneros);
        $auth->add($removerGeneros);
        $auth->add($editarGeneros);
        $auth->add($verDetalhesGeneros);

        $verDetalhesDistribuidoras = $auth->createPermission('verDetalhesDistribuidoras');
        $adicionarDistribuidoras = $auth->createPermission('adicionarDistribuidoras');
        $removerDistribuidoras = $auth->createPermission('removerDistribuidoras');
        $editarDistribuidoras = $auth->createPermission('editarDistribuidoras');
        $auth->add($adicionarDistribuidoras);
        $auth->add($removerDistribuidoras);
        $auth->add($editarDistribuidoras);
        $auth->add($verDetalhesDistribuidoras);

        $verDetalhesCodigosProm = $auth->createPermission('verDetalhesCodigosProm');
        $adicionarCodigosProm = $auth->createPermission('adicionarCodigosProm');
        $usarCodigosProm = $auth->createPermission('usarCodigosProm');
        $editarCodigosProm = $auth->createPermission('editarCodigosProm');
        $apagarCodigosProm = $auth->createPermission('apagarCodigosProm');
        $ativarCodigosProm = $auth->createPermission('ativarCodigosProm');
        $desativarCodigosProm = $auth->createPermission('desativarCodigosProm');
        $auth->add($adicionarCodigosProm);
        $auth->add($usarCodigosProm);
        $auth->add($editarCodigosProm);
        $auth->add($apagarCodigosProm);
        $auth->add($ativarCodigosProm);
        $auth->add($desativarCodigosProm);
        $auth->add($verDetalhesCodigosProm);


        $verDetalhesMetodosEnvio = $auth->createPermission('verDetalhesMetodosEnvio');
        $adicionarMetodosEnvio = $auth->createPermission('adicionarMetodosEnvio');
        $removerMetodosEnvio = $auth->createPermission('removerMetodosEnvio');
        $editarMetodosEnvio = $auth->createPermission('editarMetodosEnvio');
        $auth->add($adicionarMetodosEnvio);
        $auth->add($removerMetodosEnvio);
        $auth->add($editarMetodosEnvio);
        $auth->add($verDetalhesMetodosEnvio);

        $verDetalhesMetodosPagamento = $auth->createPermission('verDetalhesMetodosPagamento');
        $adicionarMetodosPagamento = $auth->createPermission('adicionarMetodosPagamento');
        $removerMetodosPagamento = $auth->createPermission('removerMetodosPagamento');
        $editarMetodosPagamento = $auth->createPermission('editarMetodosPagamento');
        $auth->add($adicionarMetodosPagamento);
        $auth->add($removerMetodosPagamento);
        $auth->add($editarMetodosPagamento);
        $auth->add($verDetalhesMetodosPagamento);

        $verDetalhesJogos = $auth->createPermission('verDetalhesJogos');
        $adicionarJogos = $auth->createPermission('adicionarJogos');
        $removerJogos = $auth->createPermission('removerJogos');
        $editarJogos = $auth->createPermission('editarJogos');
        $auth->add($adicionarJogos);
        $auth->add($editarJogos);
        $auth->add($removerJogos);
        $auth->add($verDetalhesJogos);

        $verDetalhesProdutos = $auth->createPermission('verDetalhesProdutos');
        $adicionarProdutos = $auth->createPermission('adicionarProdutos');
        $removerProdutos = $auth->createPermission('removerProdutos');
        $editarProdutos = $auth->createPermission('editarProdutos');
        $auth->add($adicionarProdutos);
        $auth->add($removerProdutos);
        $auth->add($editarProdutos);
        $auth->add($verDetalhesProdutos);

        $verDetalhesFaq = $auth->createPermission('verDetalhesFaq');
        $adicionarFaq = $auth->createPermission('adicionarFaq');
        $removerFaq = $auth->createPermission('removerFaq');
        $editarFaq = $auth->createPermission('editarFaq');
        $auth->add($adicionarFaq);
        $auth->add($removerFaq);
        $auth->add($editarFaq);
        $auth->add($verDetalhesFaq);

        $visualizarPerfil = $auth->createPermission('visualizarPerfil');
        $visualizarPerfil->description = 'Visualizar perfil público';
        $editarDetalhesPerfil = $auth->createPermission('editarDetalhesPerfil');
        $editarDetalhesPerfil ->description = 'Editar todos os detalhes associados ao perfil público';
        $editarDetalhesUtilizador = $auth->createPermission('editarDetalhesUtilizador');
        $editarDetalhesUtilizador -> description = 'Editar detalhes própios';
        $editarDetalhesUtilizadores = $auth->createPermission('editarDetalhesUtilizadores');
        $editarDetalhesUtilizadores -> description = 'Editar detalhes de todos os utilizadores na plataforma (Backend)';
        $auth->add($visualizarPerfil);
        $auth->add($editarDetalhesPerfil);
        $auth->add($editarDetalhesUtilizador);
        $auth->add($editarDetalhesUtilizadores);

        $destacarJogosPerfil = $auth->createPermission('destacarJogosPerfil');
        $auth->add($destacarJogosPerfil);

        $verDetalhesPlataformas = $auth->createPermission('verDetalhesPlataformas');
        $adicionarPlataformas = $auth->createPermission('adicionarPlataformas');
        $removerPlataformas = $auth->createPermission('removerPlataformas');
        $editarPlataformas = $auth->createPermission('editarPlataformas');
        $auth->add($adicionarPlataformas);
        $auth->add($removerPlataformas);
        $auth->add($editarPlataformas);
        $auth->add($verDetalhesPlataformas);

        $adicionarCarrinho = $auth->createPermission('adicionarItensCarrinho');
        $removerCarrinho = $auth->createPermission('removerItensCarrinho');
        $editarCarrinho = $auth->createPermission('editarItensCarrinho');
        $visualizarCarrinho = $auth->createPermission('visualizarItensCarrinho');
        $visualizarEncomendas = $auth->createPermission('visualizarEncomendas');
        $visualizarEncomendas->description = 'Visualizar todas as encomendas feitas com sucesso';
        $visualizarDetalhesEncomendas = $auth->createPermission('visualizarDetalhesEncomendas');
        $auth->add($adicionarCarrinho);
        $auth->add($removerCarrinho);
        $auth->add($editarCarrinho);
        $auth->add($visualizarCarrinho);
        $auth->add($visualizarEncomendas);
        $auth->add($visualizarDetalhesEncomendas);

        $verDetalhesListas = $auth->createPermission('verDetalhesListas');
        $criarListas = $auth->createPermission('adicionarListas');
        $removerListas = $auth->createPermission('removerListas');
        $adicionarJogosListas = $auth->createPermission('adicionarJogosListas');
        $editarListas = $auth->createPermission('editarListas');
        $definirPrivacidadeListas = $auth->createPermission('definirPrivacidadeListas');
        $definirPrivacidadeGostos= $auth->createPermission('definirPrivacidadeGostos');
        $definirPrivacidadeFavoritos= $auth->createPermission('definirPrivacidadeFavoritos');
        $definirPrivacidadeJogados = $auth->createPermission('definirPrivacidadeJogados');
        $alterarDisposicao =  $auth->createPermission('alterarDiposicao');
        $auth->add($verDetalhesListas);
        $auth->add($criarListas);
        $auth->add($removerListas);
        $auth->add($adicionarJogosListas);
        $auth->add($editarListas);
        $auth->add($definirPrivacidadeListas);
        $auth->add($definirPrivacidadeGostos);
        $auth->add($definirPrivacidadeFavoritos);
        $auth->add($definirPrivacidadeJogados);
        $auth->add($alterarDisposicao);

        $avaliarJogo = $auth->createPermission('avaliarJogo');
        $editarAvaliacao = $auth->createPermission('editarAvaliacao');
        $apagarAvaliacao = $auth->createPermission('apagarAvaliacao');
        $auth->add($avaliarJogo);
        $auth->add($editarAvaliacao);
        $auth->add($apagarAvaliacao);

        $apagarComentario = $auth->createPermission('apagarComentario');
        $escreverComentario = $auth->createPermission('escreverComentario');
        $editarComentario = $auth->createPermission('editarComentario');
        $gostarComentario = $auth->createPermission('gostarComentario');
        $gostarLista = $auth->createPermission('gostarLista');
        $auth->add($apagarComentario);
        $auth->add($escreverComentario);
        $auth->add($gostarLista);
        $auth->add($editarComentario);
        $auth->add($gostarComentario);

        $verDetalhesUtilizadores = $auth->createPermission('verDetalhesUtilizadores');
        $seguirUtilizador = $auth->createPermission('seguirUtilizador');
        $deixarSeguir = $auth->createPermission('deixarSeguir');
        $bloquearUtilizador = $auth->createPermission('bloquearUtilizador');
        $banirUtilizador = $auth->createPermission('banirUtilizador');
        $denunciarUtilizador = $auth->createPermission('denunciarUtilizador');
        $avaliarSugestao = $auth->createPermission('avaliarSugestao');
        $efetuarCompras =  $auth->createPermission('efetuarCompras');
        $auth->add($seguirUtilizador);
        $auth->add($deixarSeguir);
        $auth->add($bloquearUtilizador);
        $auth->add($banirUtilizador);
        $auth->add($denunciarUtilizador);
        $auth->add($avaliarSugestao);
        $auth->add($efetuarCompras);
        $auth->add($verDetalhesUtilizadores);


        $alterarEstadoDenuncia = $auth->createPermission('alterarEstadoDenuncia');
        $alterarEstadoEncomenda = $auth->createPermission('alterarEstadoEncomenda');
        $alterarEstadoSugestao = $auth->createPermission('alterarEstadoSugestao');
        $editarDenuncia = $auth->createPermission('editarDenuncia');
        $editarDenuncia->description = 'Edição de uma denuncia em particular feita por um cliente';
        $editarDenuncias = $auth->createPermission('editarDenuncias');
        $editarDenuncias->description = 'Edição em geral de todas as denuncias';
        $apagarDenuncia = $auth->createPermission('apagarDenuncia');
        $apagarDenuncia->description = 'Apagar denuncia particular feita por um cliente';
        $apagarDenuncias = $auth->createPermission('apagarDenuncias');
        $apagarDenuncias->description = 'Apagar denuncias no geral';
        $verDetalhesDenuncias = $auth->createPermission('verDetalhesDenuncias');
        $auth->add($alterarEstadoDenuncia);
        $auth->add($alterarEstadoEncomenda);
        $auth->add($alterarEstadoSugestao);
        $auth->add($editarDenuncia);
        $auth->add($editarDenuncias);
        $auth->add($apagarDenuncia);
        $auth->add($apagarDenuncias);
        $auth->add($verDetalhesDenuncias);

        $criarChaves = $auth->createPermission('criarChaves');
        $editarChaves = $auth->createPermission('editarChaves');
        $apagarChaves = $auth->createPermission('apagarChaves');
        $verDetalhesChaves = $auth->createPermission('verDetalhesChaves');
        $auth->add($criarChaves);
        $auth->add($editarChaves);
        $auth->add($apagarChaves);
        $auth->add($verDetalhesChaves);

        $reporPassword = $auth->createPermission('reporPassword');
        $auth->add($reporPassword);

        $verDetalhesSugestao = $auth->createPermission('verDetalhesSugestao');
        $criarSugestao = $auth->createPermission('criarSugestao');
        $editarSugestao = $auth->createPermission('editarSugestao');
        $apagarSugestao =  $auth->createPermission('apagarSugestao');
        $auth->add($criarSugestao);
        $auth->add($editarSugestao);
        $auth->add($apagarSugestao);
        $auth->add($verDetalhesSugestao);

        $adicionarFavoritos = $auth->createPermission('adicionarFavoritos');
        $removerFavoritos = $auth->createPermission('removerFavoritos');
        $auth->add($adicionarFavoritos);
        $auth->add($removerFavoritos);

        $adicionarDesejados = $auth->createPermission('adicionarDesejados');
        $removerDesejados = $auth->createPermission('removerDesejados');
        $auth->add($adicionarDesejados);
        $auth->add($removerDesejados);

        $adicionarJogados= $auth->createPermission('adicionarJogados');
        $removerJogados= $auth->createPermission('removerJogados');
        $visualizarTudo = $auth->createPermission('verTudo');
        $cancelarEncomenda = $auth->createPermission('cancelarEncomenda');
        $verDetalhesEncomendas = $auth->createPermission('verDetalhesEncomendas');
        $auth->add($adicionarJogados);
        $auth->add($removerJogados);
        $auth->add($visualizarTudo);
        $auth->add($cancelarEncomenda);
        $auth->add($verDetalhesEncomendas);

        $associarRoles = $auth->createPermission('associarRoles');
        $associarRoles->description = 'Associar um certo utilizador a uma role';
        $auth->add($associarRoles);

        $acederBackend = $auth->createPermission('acederBackend');
        $auth->add($acederBackend);

        $acederFrontend = $auth->createPermission('acederFrontend');
        $auth->add($acederFrontend);

        $adicionarUtilizadores = $auth->createPermission('adicionarUtilizadores');
        $auth->add($adicionarUtilizadores);

        $adicionarIvas = $auth->createPermission('adicionarIvas');
        $removerIvas = $auth->createPermission('removerIvas');
        $editarIvas = $auth->createPermission('editarIvas');
        $verDetalhesIvas = $auth->createPermission('verDetalhesIvas');
        $auth->add($adicionarIvas);
        $auth->add($removerIvas);
        $auth->add($editarIvas);
        $auth->add($verDetalhesIvas);

        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);
        $auth->addChild($cliente, $usarCodigosProm);
        $auth->addChild($cliente, $visualizarPerfil);
        $auth->addChild($cliente, $editarDetalhesPerfil);
        $auth->addChild($cliente, $editarDetalhesUtilizador);
        $auth->addChild($cliente, $destacarJogosPerfil);
        $auth->addChild($cliente, $adicionarCarrinho);
        $auth->addChild($cliente, $removerCarrinho);
        $auth->addChild($cliente, $editarCarrinho);
        $auth->addChild($cliente, $visualizarCarrinho);
        $auth->addChild($cliente, $criarListas);
        $auth->addChild($cliente, $removerListas);
        $auth->addChild($cliente, $adicionarJogosListas);
        $auth->addChild($cliente, $editarListas);
        $auth->addChild($cliente, $definirPrivacidadeListas);
        $auth->addChild($cliente, $definirPrivacidadeGostos);
        $auth->addChild($cliente, $definirPrivacidadeFavoritos);
        $auth->addChild($cliente, $definirPrivacidadeJogados);
        $auth->addChild($cliente, $alterarDisposicao);
        $auth->addChild($cliente, $avaliarJogo);
        $auth->addChild($cliente, $editarAvaliacao);
        $auth->addChild($cliente, $apagarAvaliacao);
        $auth->addChild($cliente, $apagarComentario);
        $auth->addChild($cliente, $escreverComentario);
        $auth->addChild($cliente, $gostarComentario);
        $auth->addChild($cliente, $gostarLista);
        $auth->addChild($cliente, $seguirUtilizador);
        $auth->addChild($cliente, $deixarSeguir);
        $auth->addChild($cliente, $bloquearUtilizador);
        $auth->addChild($cliente, $denunciarUtilizador);
        $auth->addChild($cliente, $avaliarSugestao);
        $auth->addChild($cliente, $efetuarCompras);
        $auth->addChild($cliente, $reporPassword);
        $auth->addChild($cliente, $criarSugestao);
        $auth->addChild($cliente, $editarSugestao);
        $auth->addChild($cliente, $apagarSugestao);
        $auth->addChild($cliente, $adicionarFavoritos);
        $auth->addChild($cliente, $removerFavoritos);
        $auth->addChild($cliente, $adicionarDesejados);
        $auth->addChild($cliente, $removerDesejados);
        $auth->addChild($cliente, $adicionarJogados);
        $auth->addChild($cliente, $removerJogados);
        $auth->addChild($cliente, $editarComentario);
        $auth->addChild($cliente, $acederFrontend);
        $auth->addChild($cliente,$editarDenuncia);
        $auth->addChild($cliente, $apagarDenuncia);
        $auth->addChild($cliente, $visualizarEncomendas);
        $auth->addChild($cliente, $visualizarDetalhesEncomendas);

        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);
        $auth->addChild($funcionario, $adicionarProdutos);
        $auth->addChild($funcionario,$removerProdutos);
        $auth->addChild($funcionario,$editarProdutos);
        $auth->addChild($funcionario,$cancelarEncomenda);
        $auth->addChild($funcionario,$visualizarTudo);
        $auth->addChild($funcionario,$acederBackend);
        $auth->addChild($funcionario,$verDetalhesEncomendas);
        $auth->addChild($funcionario,$verDetalhesProdutos);


        $moderador = $auth->createRole('moderador');
        $auth->add($moderador);
        $auth->addChild($moderador,$removerListas);
        $auth->addChild($moderador,$apagarAvaliacao);
        $auth->addChild($moderador,$apagarComentario);
        $auth->addChild($moderador,$apagarSugestao);
        $auth->addChild($moderador,$banirUtilizador);
        $auth->addChild($moderador,$alterarEstadoDenuncia);
        $auth->addChild($moderador,$alterarEstadoEncomenda);
        $auth->addChild($moderador,$alterarEstadoSugestao);
        $auth->addChild($moderador,$visualizarTudo);
        $auth->addChild($moderador,$acederBackend);
        $auth->addChild($moderador,$verDetalhesEncomendas);
        $auth->addChild($moderador,$verDetalhesListas);
        $auth->addChild($moderador,$verDetalhesSugestao);
        $auth->addChild($moderador,$verDetalhesFaq);
        $auth->addChild($moderador,$verDetalhesUtilizadores);
        $auth->addChild($moderador,$editarDenuncias);
        $auth->addChild($moderador, $apagarDenuncias);
        $auth->addChild($moderador, $verDetalhesDenuncias);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        // Herdar de vendedor e moderador
        $auth->addChild($admin,$funcionario);
        $auth->addChild($admin,$moderador);

        $auth->addChild($admin,$adicionarFranquias);
        $auth->addChild($admin,$removerFranquias);
        $auth->addChild($admin,$editarFranquias);
        $auth->addChild($admin,$acederBackend);

        $auth->addChild($admin,$adicionarEditoras);
        $auth->addChild($admin,$removerEditoras );
        $auth->addChild($admin,$editarEditoras);

        $auth->addChild($admin,$adicionarScreenshots);
        $auth->addChild($admin,$removerScreenshots);
        $auth->addChild($admin,$editarScreenshots);

        $auth->addChild($admin,$adicionarTags);
        $auth->addChild($admin,$removerTags);
        $auth->addChild($admin,$editarTags);

        $auth->addChild($admin,$adicionarGeneros );
        $auth->addChild($admin,$removerGeneros);
        $auth->addChild($admin,$editarGeneros);

        $auth->addChild($admin, $adicionarDistribuidoras);
        $auth->addChild($admin,$removerDistribuidoras);
        $auth->addChild($admin,$editarDistribuidoras);

        $auth->addChild($admin,$adicionarCodigosProm);
        $auth->addChild($admin,$apagarCodigosProm);
        $auth->addChild($admin,$editarCodigosProm);
        $auth->addChild($admin,$usarCodigosProm);
        $auth->addChild($admin,$ativarCodigosProm);
        $auth->addChild($admin,$desativarCodigosProm);


        $auth->addChild($admin, $adicionarJogos);
        $auth->addChild($admin,$removerJogos);
        $auth->addChild($admin,$editarJogos);

        $auth->addChild($admin, $adicionarFaq);
        $auth->addChild($admin,$removerFaq);
        $auth->addChild($admin,$editarFaq);

        $auth->addChild($admin, $editarDetalhesUtilizadores);

        $auth->addChild($admin, $adicionarPlataformas);
        $auth->addChild($admin,$removerPlataformas);
        $auth->addChild($admin,$editarPlataformas);

        $auth->addChild($admin, $criarListas);

        $auth->addChild($admin, $adicionarMetodosPagamento);
        $auth->addChild($admin,$removerMetodosPagamento);
        $auth->addChild($admin,$editarMetodosPagamento);

        $auth->addChild($admin, $criarChaves);
        $auth->addChild($admin,$editarChaves);
        $auth->addChild($admin,$apagarChaves);
        $auth->addChild($admin,$associarRoles);

        $auth->addChild($admin,$verDetalhesFranquias);
        $auth->addChild($admin,$verDetalhesScreenshots);
        $auth->addChild($admin,$verDetalhesTags);
        $auth->addChild($admin,$verDetalhesGeneros);
        $auth->addChild($admin,$verDetalhesDistribuidoras);
        $auth->addChild($admin,$verDetalhesCodigosProm);
        $auth->addChild($admin,$verDetalhesMetodosEnvio);
        $auth->addChild($admin,$verDetalhesMetodosPagamento);
        $auth->addChild($admin,$verDetalhesJogos);
        $auth->addChild($admin,$verDetalhesPlataformas);
        $auth->addChild($admin,$verDetalhesChaves);
        $auth->addChild($admin,$adicionarMetodosEnvio);
        $auth->addChild($admin,$editarMetodosEnvio);
        $auth->addChild($admin,$verDetalhesUtilizadores);
        $auth->addChild($admin,$adicionarUtilizadores);
        $auth->addChild($admin,$removerMetodosEnvio);

        $auth->addChild($admin,$verDetalhesIvas);
        $auth->addChild($admin,$adicionarIvas);
        $auth->addChild($admin,$removerIvas);
        $auth->addChild($admin,$editarIvas);

        $auth->assign($admin, 1);
        $auth->assign($moderador, 2);
        $auth->assign($funcionario, 3);
        $auth->assign($cliente, 4);
    }

}