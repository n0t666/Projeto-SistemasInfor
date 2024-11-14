-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 14, 2024 at 03:26 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbprojeto`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1731553137),
('cliente', '4', 1731553137),
('funcionario', '3', 1731553137),
('moderador', '2', 1731553137);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acederBackend', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('acederFrontend', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarDesejados', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarDistribuidoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarEditoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarFaq', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarFavoritos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarFranquias', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarGeneros', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarItensCarrinho', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarJogados', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarJogos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarJogosListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarMetodosEnvio', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarMetodosPagamento', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarPlataformas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarProdutos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarScreenshots', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('adicionarTags', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('admin', 1, NULL, NULL, NULL, 1731553137, 1731553137),
('alterarDiposicao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('alterarEstadoDenuncia', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('alterarEstadoEncomenda', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('alterarEstadoSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('apagarAvaliacao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('apagarChaves', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('apagarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('apagarComentario', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('apagarSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('associarRoles', 2, 'Associar um certo utilizador a uma role', NULL, NULL, 1731553136, 1731553136),
('ativarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('avaliarJogo', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('avaliarSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('banirUtilizador', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('bloquearUtilizador', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('cancelarEncomenda', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('cliente', 1, NULL, NULL, NULL, 1731553136, 1731553136),
('criarChaves', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('criarSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('definirPrivacidadeFavoritos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('definirPrivacidadeGostos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('definirPrivacidadeJogados', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('definirPrivacidadeListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('deixarSeguir', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('denunciarUtilizador', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('desativarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('destacarJogosPerfil', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarAvaliacao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarChaves', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarComentario', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarDetalhesPerfil', 2, 'Editar todos os detalhes associados ao perfil público', NULL, NULL, 1731553136, 1731553136),
('editarDetalhesUtilizador', 2, 'Editar detalhes própios', NULL, NULL, 1731553136, 1731553136),
('editarDetalhesUtilizadores', 2, 'Editar detalhes de todos os utilizadores na plataforma (Backend)', NULL, NULL, 1731553136, 1731553136),
('editarDistribuidoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarEditoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarFaq', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarFranquias', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarGeneros', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarItensCarrinho', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarJogos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarMetodosEnvio', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarMetodosPagamento', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarPlataformas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarProdutos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarScreenshots', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('editarTags', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('efetuarCompras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('escreverComentario', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('funcionario', 1, NULL, NULL, NULL, 1731553137, 1731553137),
('gostarComentario', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('gostarLista', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('moderador', 1, NULL, NULL, NULL, 1731553137, 1731553137),
('removerDesejados', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerDistribuidoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerEditoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerFaq', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerFavoritos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerFranquias', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerGeneros', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerItensCarrinho', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerJogados', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerJogos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerMetodosEnvio', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerMetodosPagamento', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerPlataformas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerProdutos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerScreenshots', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('removerTags', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('reporPassword', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('seguirUtilizador', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('usarCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesCodigosProm', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesDistribuidoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesEditoras', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesEncomendas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesFaq', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesFranquias', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesGeneros', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesJogos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesListas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesMetodosEnvio', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesMetodosPagamento', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesPlataformas', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesProdutos', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesScreenshots', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesSugestao', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesTags', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verDetalhesUtilizadores', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('verTudo', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('visualizarItensCarrinho', 2, NULL, NULL, NULL, 1731553136, 1731553136),
('visualizarPerfil', 2, 'Visualizar perfil público', NULL, NULL, 1731553136, 1731553136);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('funcionario', 'acederBackend'),
('moderador', 'acederBackend'),
('cliente', 'acederFrontend'),
('admin', 'adicionarCodigosProm'),
('cliente', 'adicionarDesejados'),
('admin', 'adicionarDistribuidoras'),
('admin', 'adicionarEditoras'),
('admin', 'adicionarFaq'),
('cliente', 'adicionarFavoritos'),
('admin', 'adicionarFranquias'),
('admin', 'adicionarGeneros'),
('cliente', 'adicionarItensCarrinho'),
('cliente', 'adicionarJogados'),
('admin', 'adicionarJogos'),
('cliente', 'adicionarJogosListas'),
('admin', 'adicionarListas'),
('cliente', 'adicionarListas'),
('admin', 'adicionarMetodosPagamento'),
('admin', 'adicionarPlataformas'),
('funcionario', 'adicionarProdutos'),
('admin', 'adicionarScreenshots'),
('admin', 'adicionarTags'),
('cliente', 'alterarDiposicao'),
('moderador', 'alterarEstadoDenuncia'),
('moderador', 'alterarEstadoEncomenda'),
('moderador', 'alterarEstadoSugestao'),
('cliente', 'apagarAvaliacao'),
('moderador', 'apagarAvaliacao'),
('admin', 'apagarChaves'),
('admin', 'apagarCodigosProm'),
('cliente', 'apagarComentario'),
('moderador', 'apagarComentario'),
('cliente', 'apagarSugestao'),
('moderador', 'apagarSugestao'),
('admin', 'associarRoles'),
('admin', 'ativarCodigosProm'),
('cliente', 'avaliarJogo'),
('cliente', 'avaliarSugestao'),
('moderador', 'banirUtilizador'),
('cliente', 'bloquearUtilizador'),
('funcionario', 'cancelarEncomenda'),
('admin', 'criarChaves'),
('cliente', 'criarSugestao'),
('cliente', 'definirPrivacidadeFavoritos'),
('cliente', 'definirPrivacidadeGostos'),
('cliente', 'definirPrivacidadeJogados'),
('cliente', 'definirPrivacidadeListas'),
('cliente', 'deixarSeguir'),
('cliente', 'denunciarUtilizador'),
('admin', 'desativarCodigosProm'),
('cliente', 'destacarJogosPerfil'),
('cliente', 'editarAvaliacao'),
('admin', 'editarChaves'),
('admin', 'editarCodigosProm'),
('cliente', 'editarComentario'),
('cliente', 'editarDetalhesPerfil'),
('cliente', 'editarDetalhesUtilizador'),
('admin', 'editarDetalhesUtilizadores'),
('admin', 'editarDistribuidoras'),
('admin', 'editarEditoras'),
('admin', 'editarFaq'),
('admin', 'editarFranquias'),
('admin', 'editarGeneros'),
('cliente', 'editarItensCarrinho'),
('admin', 'editarJogos'),
('cliente', 'editarListas'),
('admin', 'editarMetodosPagamento'),
('admin', 'editarPlataformas'),
('funcionario', 'editarProdutos'),
('admin', 'editarScreenshots'),
('cliente', 'editarSugestao'),
('admin', 'editarTags'),
('cliente', 'efetuarCompras'),
('cliente', 'escreverComentario'),
('admin', 'funcionario'),
('cliente', 'gostarComentario'),
('cliente', 'gostarLista'),
('admin', 'moderador'),
('cliente', 'removerDesejados'),
('admin', 'removerDistribuidoras'),
('admin', 'removerEditoras'),
('admin', 'removerFaq'),
('cliente', 'removerFavoritos'),
('admin', 'removerFranquias'),
('admin', 'removerGeneros'),
('cliente', 'removerItensCarrinho'),
('cliente', 'removerJogados'),
('admin', 'removerJogos'),
('cliente', 'removerListas'),
('moderador', 'removerListas'),
('admin', 'removerMetodosPagamento'),
('admin', 'removerPlataformas'),
('funcionario', 'removerProdutos'),
('admin', 'removerScreenshots'),
('admin', 'removerTags'),
('cliente', 'reporPassword'),
('cliente', 'seguirUtilizador'),
('admin', 'usarCodigosProm'),
('cliente', 'usarCodigosProm'),
('admin', 'verDetalhesCodigosProm'),
('admin', 'verDetalhesDistribuidoras'),
('funcionario', 'verDetalhesEncomendas'),
('moderador', 'verDetalhesEncomendas'),
('funcionario', 'verDetalhesFaq'),
('admin', 'verDetalhesFranquias'),
('admin', 'verDetalhesGeneros'),
('admin', 'verDetalhesJogos'),
('moderador', 'verDetalhesListas'),
('admin', 'verDetalhesMetodosEnvio'),
('admin', 'verDetalhesMetodosPagamento'),
('admin', 'verDetalhesPlataformas'),
('funcionario', 'verDetalhesProdutos'),
('admin', 'verDetalhesScreenshots'),
('moderador', 'verDetalhesSugestao'),
('admin', 'verDetalhesTags'),
('funcionario', 'verTudo'),
('moderador', 'verTudo'),
('cliente', 'visualizarItensCarrinho'),
('cliente', 'visualizarPerfil');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `numEstrelas` decimal(2,1) NOT NULL,
  `dataAvaliacao` timestamp NOT NULL,
  PRIMARY KEY (`utilizador_id`,`jogo_id`),
  KEY `fk_jogos_has_utilizadores_utilizadores1_idx` (`utilizador_id`),
  KEY `fk_jogos_has_utilizadores_jogos1_idx` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrinhosCompras_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `chaves`
--

DROP TABLE IF EXISTS `chaves`;
CREATE TABLE IF NOT EXISTS `chaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `plataforma_id` int NOT NULL,
  `chave` varchar(255) NOT NULL,
  `dataGeracao` timestamp NULL DEFAULT NULL,
  `dataExpiracao` timestamp NULL DEFAULT NULL,
  `isUsada` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `chave_UNIQUE` (`chave`),
  KEY `fk_chaves_produtos1_idx` (`produto_id`),
  KEY `fk_chaves_plataformas1_idx` (`plataforma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `codigospromocionais`
--

DROP TABLE IF EXISTS `codigospromocionais`;
CREATE TABLE IF NOT EXISTS `codigospromocionais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `desconto` int NOT NULL,
  `isAtivo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `codigospromocionais`
--

INSERT INTO `codigospromocionais` (`id`, `codigo`, `desconto`, `isAtivo`) VALUES
(1, 'SEMIVA', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `comentario` text NOT NULL,
  `dataComentario` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentarios_avaliacoes1_idx` (`utilizador_id`,`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `denuncias`
--

DROP TABLE IF EXISTS `denuncias`;
CREATE TABLE IF NOT EXISTS `denuncias` (
  `denunciante_id` int NOT NULL,
  `denunciado_id` int NOT NULL,
  `motivo` text NOT NULL,
  `dataDenuncia` timestamp NULL DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`denunciante_id`,`denunciado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores4_idx` (`denunciado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores3_idx` (`denunciante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `distribuidoras`
--

DROP TABLE IF EXISTS `distribuidoras`;
CREATE TABLE IF NOT EXISTS `distribuidoras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `distribuidoras`
--

INSERT INTO `distribuidoras` (`id`, `nome`) VALUES
(3, ' Deep Silver'),
(2, ' Warner Bros. Interactive Entertainment '),
(6, 'Activision Blizzard'),
(10, 'Bandai Namco'),
(13, 'Bethesda Softworks'),
(4, 'EA Games'),
(14, 'Mojang Studios'),
(7, 'Nintendo'),
(9, 'Sega'),
(8, 'Square Enix'),
(12, 'Take-Two Interactive'),
(5, 'Ubisoft');

-- --------------------------------------------------------

--
-- Table structure for table `editoras`
--

DROP TABLE IF EXISTS `editoras`;
CREATE TABLE IF NOT EXISTS `editoras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `editoras`
--

INSERT INTO `editoras` (`id`, `nome`) VALUES
(10, 'Activision'),
(11, 'Capcom'),
(8, 'CD Projekt Red'),
(2, 'Dambuster Studios'),
(3, 'Day 1 Studios'),
(9, 'Electronic Arts'),
(5, 'Microsoft Studios'),
(15, 'Mojang Studios'),
(14, 'Nintendo'),
(13, 'Paradox Interactive'),
(7, 'Rockstar Games'),
(4, 'Sony Interactive Entertainment'),
(6, 'Square Enix'),
(12, 'Valve Corporation');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `faturas`
--

DROP TABLE IF EXISTS `faturas`;
CREATE TABLE IF NOT EXISTS `faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `pagamento_id` int NOT NULL,
  `envio_id` int NOT NULL,
  `codigo_id` int DEFAULT NULL,
  `dataEncomenda` timestamp NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_encomendas_utilizadores1_idx` (`utilizador_id`),
  KEY `fk_encomendas_metodosPagamento1_idx` (`pagamento_id`),
  KEY `fk_encomendas_tiposEnvio1_idx` (`envio_id`),
  KEY `fk_encomendas_codigosPromocionais1_idx` (`codigo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `franquias`
--

DROP TABLE IF EXISTS `franquias`;
CREATE TABLE IF NOT EXISTS `franquias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `franquias`
--

INSERT INTO `franquias` (`id`, `nome`) VALUES
(23, 'Assassin\'s Creed'),
(19, 'Call of Duty'),
(6, 'Dead Island'),
(4, 'F.e.a.r'),
(17, 'Final Fantasy'),
(5, 'God of war'),
(16, 'Grand Theft Auto'),
(22, 'Halo'),
(18, 'Minecraft'),
(3, 'Resident Evil'),
(21, 'Super Mario'),
(20, 'The Legend of Zelda');

-- --------------------------------------------------------

--
-- Table structure for table `generos`
--

DROP TABLE IF EXISTS `generos`;
CREATE TABLE IF NOT EXISTS `generos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `generos`
--

INSERT INTO `generos` (`id`, `nome`) VALUES
(3, 'Ação'),
(4, 'Aventura'),
(8, 'Casual'),
(5, 'Corrida'),
(7, 'Estratégia'),
(51, 'Horror'),
(6, 'Indie'),
(50, 'Luta'),
(53, 'Música e Ritmo'),
(52, 'Plataforma'),
(9, 'RPG');

-- --------------------------------------------------------

--
-- Table structure for table `gostoscomentarios`
--

DROP TABLE IF EXISTS `gostoscomentarios`;
CREATE TABLE IF NOT EXISTS `gostoscomentarios` (
  `utilizador_id` int NOT NULL,
  `comentario_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`comentario_id`),
  KEY `fk_utilizadores_has_comentarios_comentarios1_idx` (`comentario_id`),
  KEY `fk_utilizadores_has_comentarios_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gostoslistas`
--

DROP TABLE IF EXISTS `gostoslistas`;
CREATE TABLE IF NOT EXISTS `gostoslistas` (
  `utilizador_id` int NOT NULL,
  `lista_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`lista_id`),
  KEY `fk_userData_has_listas_listas1_idx` (`lista_id`),
  KEY `fk_userData_has_listas_userData1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `jogos`
--

DROP TABLE IF EXISTS `jogos`;
CREATE TABLE IF NOT EXISTS `jogos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `dataLancamento` date NOT NULL,
  `descricao` text,
  `trailerLink` varchar(255) NOT NULL,
  `franquia_id` int DEFAULT NULL,
  `imagemCapa` varchar(255) NOT NULL,
  `distribuidora_id` int NOT NULL,
  `editora_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jogos_franquias1_idx` (`franquia_id`),
  KEY `fk_jogos_publicadora1_idx` (`distribuidora_id`),
  KEY `fk_jogos_editoras1_idx` (`editora_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jogos`
--

INSERT INTO `jogos` (`id`, `nome`, `dataLancamento`, `descricao`, `trailerLink`, `franquia_id`, `imagemCapa`, `distribuidora_id`, `editora_id`) VALUES
(18, 'The Legend of Zelda: Breath of the Wild', '2017-03-03', 'Um jogo de aventura em mundo aberto onde o jogador explora o vasto reino de Hyrule para derrotar o malvado Ganon e salvar a princesa Zelda.', 'https://www.youtube.com/watch?v=zw47_q9wbBE', 20, 'capa_zelda.jpg', 7, 14),
(19, 'Grand Theft Auto V', '2013-09-17', 'Um jogo de ação e aventura onde o jogador controla três criminosos num mundo aberto, com missões variadas e muito foco em exploração e interação com o ambiente.', 'https://www.youtube.com/watch?v=QkkoHAzjnUs', 16, 'capa_gta_v.jpg', 3, 7),
(20, 'Minecraft', '2011-11-11', 'Um jogo sandbox onde os jogadores podem construir e explorar um mundo em blocos, coletar recursos e criar suas próprias aventuras.', 'https://www.youtube.com/watch?v=Op6v3XkkC8w', 18, 'capa_minecraft.jpg', 14, 15),
(21, 'Call of Duty: Modern Warfare (2019)', '2019-10-25', ' Um reinício da famosa série, oferecendo uma experiência moderna e realista com foco em táticas e combate militar. O jogo inclui tanto a campanha quanto o modo multiplayer.', 'https://www.youtube.com/watch?v=8fNP9-pJ7JU', 19, 'capa_cod_mw.jpg', 6, 10),
(22, 'Call of Duty: Black Ops Cold War', '2020-11-13', 'Situado durante a Guerra Fria, o jogo traz missões de campanha, modos multiplayer e o modo zumbis. É conhecido pela sua narrativa imersiva e jogabilidade rápida.', 'https://www.youtube.com/watch?v=9VQ20xvA_Zk', 19, 'capa_cod_bocw.jpg', 6, 10),
(23, 'Call of Duty: Vanguard', '2021-11-05', 'Um jogo ambientado na Segunda Guerra Mundial, com foco nas campanhas militares em diferentes frentes de combate. Inclui modos de campanha, multiplayer e zumbis.', 'https://www.youtube.com/watch?v=X4nDk8t-KDY', 19, 'capa_cod_vanguard.jpg', 6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `jogosgeneros`
--

DROP TABLE IF EXISTS `jogosgeneros`;
CREATE TABLE IF NOT EXISTS `jogosgeneros` (
  `jogo_id` int NOT NULL,
  `genero_id` int NOT NULL,
  PRIMARY KEY (`jogo_id`,`genero_id`),
  KEY `fk_jogos_has_generos_generos1_idx` (`genero_id`),
  KEY `fk_jogos_has_generos_jogos1_idx` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jogosgeneros`
--

INSERT INTO `jogosgeneros` (`jogo_id`, `genero_id`) VALUES
(19, 3),
(21, 3),
(22, 3),
(23, 3),
(18, 4),
(19, 4),
(19, 5),
(18, 8),
(20, 9),
(20, 50);

-- --------------------------------------------------------

--
-- Table structure for table `jogostags`
--

DROP TABLE IF EXISTS `jogostags`;
CREATE TABLE IF NOT EXISTS `jogostags` (
  `jogo_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`jogo_id`,`tag_id`),
  KEY `fk_jogos_has_tags_tags1_idx` (`tag_id`),
  KEY `fk_jogos_has_tags_jogos1_idx` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jogostags`
--

INSERT INTO `jogostags` (`jogo_id`, `tag_id`) VALUES
(19, 7),
(22, 7),
(18, 8),
(19, 8),
(20, 8),
(18, 11),
(20, 13),
(22, 14),
(23, 16);

-- --------------------------------------------------------

--
-- Table structure for table `linhascarrinho`
--

DROP TABLE IF EXISTS `linhascarrinho`;
CREATE TABLE IF NOT EXISTS `linhascarrinho` (
  `carrinhos_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `dataAdicao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`carrinhos_id`,`produtos_id`),
  KEY `fk_carrinhos_has_produtos_produtos1_idx` (`produtos_id`),
  KEY `fk_carrinhos_has_produtos_carrinhos1_idx` (`carrinhos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `linhasfatura`
--

DROP TABLE IF EXISTS `linhasfatura`;
CREATE TABLE IF NOT EXISTS `linhasfatura` (
  `fatura_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `chave_id` int NOT NULL,
  `precoUnitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`fatura_id`,`produto_id`,`chave_id`),
  KEY `fk_faturas_has_produtos_produtos1_idx` (`produto_id`),
  KEY `fk_faturas_has_produtos_faturas1_idx` (`fatura_id`),
  KEY `fk_faturas_has_produtos_chaves1_idx` (`chave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `listabloqueios`
--

DROP TABLE IF EXISTS `listabloqueios`;
CREATE TABLE IF NOT EXISTS `listabloqueios` (
  `utilizador_id` int NOT NULL,
  `utilizadorBloqueado_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`utilizadorBloqueado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores2_idx` (`utilizadorBloqueado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `listas`
--

DROP TABLE IF EXISTS `listas`;
CREATE TABLE IF NOT EXISTS `listas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` text,
  `dataCriacao` timestamp NULL DEFAULT NULL,
  `idUtilizador` int NOT NULL,
  `privacidade` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_listas_clientes1_idx` (`idUtilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `listasjogos`
--

DROP TABLE IF EXISTS `listasjogos`;
CREATE TABLE IF NOT EXISTS `listasjogos` (
  `lista_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `ordem` tinyint DEFAULT NULL,
  PRIMARY KEY (`lista_id`,`jogo_id`),
  KEY `fk_listas_has_jogos_jogos1_idx` (`jogo_id`),
  KEY `fk_listas_has_jogos_listas1_idx` (`lista_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `metodosenvio`
--

DROP TABLE IF EXISTS `metodosenvio`;
CREATE TABLE IF NOT EXISTS `metodosenvio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `metodospagamento`
--

DROP TABLE IF EXISTS `metodospagamento`;
CREATE TABLE IF NOT EXISTS `metodospagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `isAtivo` tinyint(1) NOT NULL DEFAULT '0',
  `logotipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `plataformas`
--

DROP TABLE IF EXISTS `plataformas`;
CREATE TABLE IF NOT EXISTS `plataformas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `logotipo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jogo_id` int NOT NULL,
  `plataforma_id` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produtos_jogos1_idx` (`jogo_id`),
  KEY `fk_produtos_plataformas1_idx` (`plataforma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

DROP TABLE IF EXISTS `screenshots`;
CREATE TABLE IF NOT EXISTS `screenshots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jogo_id` int NOT NULL,
  `caminho` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_screenshots_jogos1_idx` (`jogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `seguidores`
--

DROP TABLE IF EXISTS `seguidores`;
CREATE TABLE IF NOT EXISTS `seguidores` (
  `seguidor_id` int NOT NULL,
  `seguido_id` int NOT NULL,
  `dataSeguir` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`seguido_id`,`seguidor_id`),
  KEY `fk_seguidores_utilizadores1_idx` (`seguidor_id`),
  KEY `fk_seguidores_utilizadores2_idx` (`seguido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `sugestoesfuncionalidades`
--

DROP TABLE IF EXISTS `sugestoesfuncionalidades`;
CREATE TABLE IF NOT EXISTS `sugestoesfuncionalidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `descricao` text NOT NULL,
  `titulo` varchar(80) NOT NULL,
  `dataSugestao` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sugestoesFuncionalidades_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(18, 'Battle Royale'),
(13, 'Construção'),
(12, 'Criativo'),
(11, 'Exploração'),
(16, 'FPS'),
(7, 'Gráficos realistas'),
(14, 'Guerra Fria'),
(6, 'História rica'),
(4, 'Multiplayer'),
(8, 'Mundo aberto'),
(9, 'Puzzle'),
(15, 'Segunda Guerra Mundial'),
(5, 'Solo'),
(17, 'TPS');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'leandro', 'K9UnJtlcf_1WBLVDMG5kCrwALVx8w066', '$2y$13$6SxheCw28qrFM1/RX3c8g.j6P16LEO9Eusraj7j/8r/QF.W0Rbn72', NULL, 'l@gmail.com', 10, 1731436668, 1731436668, 'G5k99l_cItoWfGSLO48iKJ3_As0l53Wq_1731436668'),
(2, 'leandros', '7Ha88KDPu98p17gu7VigvCW_xx0D6NRy', '$2y$13$DqAG/dGoxag3THXd3iegROEC33wGpcv1MZNoD.z3NEm.m.Tqygneu', NULL, 'ls@gmail.com', 10, 1731436752, 1731436752, 'S4nwqSZZDhMUUH2LFKze8lKvz-Rgwy3K_1731436752'),
(3, 'jonh', 'eRFE2N6tS0eAGESgo1ScmK5cWYxnS89R', '$2y$13$Axw3q0WmA3GOBORMggiqTuxWQc3ZaW3KhegPamnAhATmz2h3AiZ6a', NULL, 'j@gmail.com', 10, 1731436807, 1731436807, 'x3L9VeF-GVEw4dNfElZhuQf55Tm7sq5L_1731436807'),
(4, 'fs', 'liwTkRkiMVsaMdpO3ThIjOus0EZJ0WZv', '$2y$13$83KkF42rAXd/3T7B31O0SeEig1gMqFqXrUKsexywkogPw4lGICIJi', NULL, 'fs@gmail.com', 10, 1731436837, 1731436837, 'y7zwshfS_QAUcdmlLEryv9eiEDdQUE4o_1731436837'),
(5, 'dsf', '6CR1rGx4nJtfPHFFeT5CD40LmNm9R1RR', '$2y$13$aZnCeVIhGnZ36f18XKFx.uMAQf4.ZssaJIlYv0zJ/I05z2PaOoP06', NULL, 'd2@gmail.com', 10, 1731437086, 1731437086, '77em-Gb1YblYk727ORovKQ2shwZ7bf5U_1731437086'),
(6, 'gdfs', '53jSiwj0-bshJ5M7A2I0X2kiy6gE3QiH', '$2y$13$xX6SbucO1Ois13/l3hIl8Owi3puCwUD6OuaygO/XVQZCRm4wg299m', NULL, 'dfgs@gmail.com', 10, 1731438495, 1731438495, 'abjC1VYHYzF6gUU5pdJPNf1zCFxAY6nO_1731438495');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nome` varchar(200) NOT NULL,
  `nif` char(9) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `biografia` varchar(150) DEFAULT NULL,
  `fotoCapa` varchar(255) DEFAULT NULL,
  `fotoPerfil` varchar(255) DEFAULT NULL,
  `privacidadeSeguidores` tinyint(1) NOT NULL DEFAULT '0',
  `privacidadeFavoritos` tinyint(1) NOT NULL DEFAULT '0',
  `privacidadeJogos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nif_UNIQUE` (`nif`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `user_id`, `nome`, `nif`, `dataNascimento`, `biografia`, `fotoCapa`, `fotoPerfil`, `privacidadeSeguidores`, `privacidadeFavoritos`, `privacidadeJogos`) VALUES
(1, 1, 'Leandro Alves Pereira', '123456789', NULL, NULL, NULL, NULL, 0, 0, 0),
(2, 2, 'Leandro Alves', '123345678', NULL, NULL, NULL, NULL, 0, 0, 0),
(3, 3, 'João', '123456790', NULL, NULL, NULL, NULL, 0, 0, 0),
(4, 4, 'Alice', '999999999', NULL, NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `utilizacaocodigos`
--

DROP TABLE IF EXISTS `utilizacaocodigos`;
CREATE TABLE IF NOT EXISTS `utilizacaocodigos` (
  `utilizador_id` int NOT NULL,
  `codigo_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`codigo_id`),
  KEY `fk_utilizadores_has_codigosPromocionais_codigosPromocionais_idx` (`codigo_id`),
  KEY `fk_utilizadores_has_codigosPromocionais_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `utilizadoresjogos`
--

DROP TABLE IF EXISTS `utilizadoresjogos`;
CREATE TABLE IF NOT EXISTS `utilizadoresjogos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `isJogado` tinyint(1) NOT NULL DEFAULT '0',
  `isDesejado` tinyint(1) NOT NULL DEFAULT '0',
  `isFavorito` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`utilizador_id`,`jogo_id`),
  KEY `fk_utilizadores_has_jogos_jogos1_idx` (`jogo_id`),
  KEY `fk_utilizadores_has_jogos_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `votosfuncionalidades`
--

DROP TABLE IF EXISTS `votosfuncionalidades`;
CREATE TABLE IF NOT EXISTS `votosfuncionalidades` (
  `utilizador_id` int NOT NULL,
  `funcionalidade_id` int NOT NULL,
  `voto` tinyint(1) NOT NULL,
  PRIMARY KEY (`utilizador_id`,`funcionalidade_id`),
  KEY `fk_utilizadores_has_sugestoesFuncionalidades_sugestoesFunci_idx` (`funcionalidade_id`),
  KEY `fk_utilizadores_has_sugestoesFuncionalidades_utilizadores1_idx` (`utilizador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `fk_jogos_has_utilizadores_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  ADD CONSTRAINT `fk_jogos_has_utilizadores_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `fk_carrinhosCompras_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `chaves`
--
ALTER TABLE `chaves`
  ADD CONSTRAINT `fk_chaves_plataformas1` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`),
  ADD CONSTRAINT `fk_chaves_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentarios_avaliacoes1` FOREIGN KEY (`utilizador_id`,`jogo_id`) REFERENCES `avaliacoes` (`utilizador_id`, `jogo_id`);

--
-- Constraints for table `denuncias`
--
ALTER TABLE `denuncias`
  ADD CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores3` FOREIGN KEY (`denunciante_id`) REFERENCES `userdata` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores4` FOREIGN KEY (`denunciado_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `faturas`
--
ALTER TABLE `faturas`
  ADD CONSTRAINT `fk_encomendas_codigosPromocionais1` FOREIGN KEY (`codigo_id`) REFERENCES `codigospromocionais` (`id`),
  ADD CONSTRAINT `fk_encomendas_metodosPagamento1` FOREIGN KEY (`pagamento_id`) REFERENCES `metodospagamento` (`id`),
  ADD CONSTRAINT `fk_encomendas_tiposEnvio1` FOREIGN KEY (`envio_id`) REFERENCES `metodosenvio` (`id`),
  ADD CONSTRAINT `fk_encomendas_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `gostoscomentarios`
--
ALTER TABLE `gostoscomentarios`
  ADD CONSTRAINT `fk_utilizadores_has_comentarios_comentarios1` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_comentarios_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `gostoslistas`
--
ALTER TABLE `gostoslistas`
  ADD CONSTRAINT `fk_userData_has_listas_listas1` FOREIGN KEY (`lista_id`) REFERENCES `listas` (`id`),
  ADD CONSTRAINT `fk_userData_has_listas_userData1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `jogos`
--
ALTER TABLE `jogos`
  ADD CONSTRAINT `fk_jogos_editoras1` FOREIGN KEY (`editora_id`) REFERENCES `editoras` (`id`),
  ADD CONSTRAINT `fk_jogos_franquias1` FOREIGN KEY (`franquia_id`) REFERENCES `franquias` (`id`),
  ADD CONSTRAINT `fk_jogos_publicadora1` FOREIGN KEY (`distribuidora_id`) REFERENCES `distribuidoras` (`id`);

--
-- Constraints for table `jogosgeneros`
--
ALTER TABLE `jogosgeneros`
  ADD CONSTRAINT `fk_jogos_has_generos_generos1` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`),
  ADD CONSTRAINT `fk_jogos_has_generos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`);

--
-- Constraints for table `jogostags`
--
ALTER TABLE `jogostags`
  ADD CONSTRAINT `fk_jogos_has_tags_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  ADD CONSTRAINT `fk_jogos_has_tags_tags1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `linhascarrinho`
--
ALTER TABLE `linhascarrinho`
  ADD CONSTRAINT `fk_carrinhos_has_produtos_carrinhos1` FOREIGN KEY (`carrinhos_id`) REFERENCES `carrinhos` (`id`),
  ADD CONSTRAINT `fk_carrinhos_has_produtos_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `linhasfatura`
--
ALTER TABLE `linhasfatura`
  ADD CONSTRAINT `fk_faturas_has_produtos_chaves1` FOREIGN KEY (`chave_id`) REFERENCES `chaves` (`id`),
  ADD CONSTRAINT `fk_faturas_has_produtos_faturas1` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  ADD CONSTRAINT `fk_faturas_has_produtos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `listabloqueios`
--
ALTER TABLE `listabloqueios`
  ADD CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores2` FOREIGN KEY (`utilizadorBloqueado_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `listas`
--
ALTER TABLE `listas`
  ADD CONSTRAINT `fk_listas_clientes1` FOREIGN KEY (`idUtilizador`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `listasjogos`
--
ALTER TABLE `listasjogos`
  ADD CONSTRAINT `fk_listas_has_jogos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  ADD CONSTRAINT `fk_listas_has_jogos_listas1` FOREIGN KEY (`lista_id`) REFERENCES `listas` (`id`);

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  ADD CONSTRAINT `fk_produtos_plataformas1` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`);

--
-- Constraints for table `screenshots`
--
ALTER TABLE `screenshots`
  ADD CONSTRAINT `fk_screenshots_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`);

--
-- Constraints for table `seguidores`
--
ALTER TABLE `seguidores`
  ADD CONSTRAINT `fk_seguidores_utilizadores1` FOREIGN KEY (`seguidor_id`) REFERENCES `userdata` (`id`),
  ADD CONSTRAINT `fk_seguidores_utilizadores2` FOREIGN KEY (`seguido_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `sugestoesfuncionalidades`
--
ALTER TABLE `sugestoesfuncionalidades`
  ADD CONSTRAINT `fk_sugestoesFuncionalidades_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `userdata`
--
ALTER TABLE `userdata`
  ADD CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `utilizacaocodigos`
--
ALTER TABLE `utilizacaocodigos`
  ADD CONSTRAINT `fk_utilizadores_has_codigosPromocionais_codigosPromocionais1` FOREIGN KEY (`codigo_id`) REFERENCES `codigospromocionais` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_codigosPromocionais_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `utilizadoresjogos`
--
ALTER TABLE `utilizadoresjogos`
  ADD CONSTRAINT `fk_utilizadores_has_jogos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_jogos_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);

--
-- Constraints for table `votosfuncionalidades`
--
ALTER TABLE `votosfuncionalidades`
  ADD CONSTRAINT `fk_utilizadores_has_sugestoesFuncionalidades_sugestoesFuncion1` FOREIGN KEY (`funcionalidade_id`) REFERENCES `sugestoesfuncionalidades` (`id`),
  ADD CONSTRAINT `fk_utilizadores_has_sugestoesFuncionalidades_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
