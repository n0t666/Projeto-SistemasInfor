CREATE DATABASE  IF NOT EXISTS `dbprojeto_test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbprojeto_test`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: dbprojeto_test
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','1',1732569863),('cliente','19',1733032838),('cliente','20',1734747020),('cliente','21',1733349150),('cliente','22',1734500090),('cliente','23',1734500373),('cliente','24',1734500644),('cliente','25',1734500851),('cliente','4',1732569863),('funcionario','3',1732569863),('moderador','2',1732569863);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('acederBackend',2,NULL,NULL,NULL,1732569863,1732569863),('acederFrontend',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarDesejados',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarDistribuidoras',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarEditoras',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarFaq',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarFavoritos',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarFranquias',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarGeneros',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarItensCarrinho',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarJogados',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarJogos',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarJogosListas',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarListas',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarMetodosEnvio',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarMetodosPagamento',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarPlataformas',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarProdutos',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarScreenshots',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarTags',2,NULL,NULL,NULL,1732569863,1732569863),('adicionarUtilizadores',2,NULL,NULL,NULL,1732569863,1732569863),('admin',1,NULL,NULL,NULL,1732569863,1732569863),('alterarDiposicao',2,NULL,NULL,NULL,1732569863,1732569863),('alterarEstadoDenuncia',2,NULL,NULL,NULL,1732569863,1732569863),('alterarEstadoEncomenda',2,NULL,NULL,NULL,1732569863,1732569863),('alterarEstadoSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('apagarAvaliacao',2,NULL,NULL,NULL,1732569863,1732569863),('apagarChaves',2,NULL,NULL,NULL,1732569863,1732569863),('apagarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('apagarComentario',2,NULL,NULL,NULL,1732569863,1732569863),('apagarDenuncia',2,'Apagar denuncia particular feita por um cliente',NULL,NULL,1732569863,1732569863),('apagarDenuncias',2,'Apagar denuncias no geral',NULL,NULL,1732569863,1732569863),('apagarSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('associarRoles',2,'Associar um certo utilizador a uma role',NULL,NULL,1732569863,1732569863),('ativarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('avaliarJogo',2,NULL,NULL,NULL,1732569863,1732569863),('avaliarSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('banirUtilizador',2,NULL,NULL,NULL,1732569863,1732569863),('bloquearUtilizador',2,NULL,NULL,NULL,1732569863,1732569863),('cancelarEncomenda',2,NULL,NULL,NULL,1732569863,1732569863),('cliente',1,NULL,NULL,NULL,1732569863,1732569863),('criarChaves',2,NULL,NULL,NULL,1732569863,1732569863),('criarSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('definirPrivacidadeFavoritos',2,NULL,NULL,NULL,1732569863,1732569863),('definirPrivacidadeGostos',2,NULL,NULL,NULL,1732569863,1732569863),('definirPrivacidadeJogados',2,NULL,NULL,NULL,1732569863,1732569863),('definirPrivacidadeListas',2,NULL,NULL,NULL,1732569863,1732569863),('deixarSeguir',2,NULL,NULL,NULL,1732569863,1732569863),('denunciarUtilizador',2,NULL,NULL,NULL,1732569863,1732569863),('desativarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('destacarJogosPerfil',2,NULL,NULL,NULL,1732569863,1732569863),('editarAvaliacao',2,NULL,NULL,NULL,1732569863,1732569863),('editarChaves',2,NULL,NULL,NULL,1732569863,1732569863),('editarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('editarComentario',2,NULL,NULL,NULL,1732569863,1732569863),('editarDenuncia',2,'Edição de uma denuncia em particular feita por um cliente',NULL,NULL,1732569863,1732569863),('editarDenuncias',2,'Edição em geral de todas as denuncias',NULL,NULL,1732569863,1732569863),('editarDetalhesPerfil',2,'Editar todos os detalhes associados ao perfil público',NULL,NULL,1732569863,1732569863),('editarDetalhesUtilizador',2,'Editar detalhes própios',NULL,NULL,1732569863,1732569863),('editarDetalhesUtilizadores',2,'Editar detalhes de todos os utilizadores na plataforma (Backend)',NULL,NULL,1732569863,1732569863),('editarDistribuidoras',2,NULL,NULL,NULL,1732569863,1732569863),('editarEditoras',2,NULL,NULL,NULL,1732569863,1732569863),('editarFaq',2,NULL,NULL,NULL,1732569863,1732569863),('editarFranquias',2,NULL,NULL,NULL,1732569863,1732569863),('editarGeneros',2,NULL,NULL,NULL,1732569863,1732569863),('editarItensCarrinho',2,NULL,NULL,NULL,1732569863,1732569863),('editarJogos',2,NULL,NULL,NULL,1732569863,1732569863),('editarListas',2,NULL,NULL,NULL,1732569863,1732569863),('editarMetodosEnvio',2,NULL,NULL,NULL,1732569863,1732569863),('editarMetodosPagamento',2,NULL,NULL,NULL,1732569863,1732569863),('editarPlataformas',2,NULL,NULL,NULL,1732569863,1732569863),('editarProdutos',2,NULL,NULL,NULL,1732569863,1732569863),('editarScreenshots',2,NULL,NULL,NULL,1732569863,1732569863),('editarSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('editarTags',2,NULL,NULL,NULL,1732569863,1732569863),('efetuarCompras',2,NULL,NULL,NULL,1732569863,1732569863),('escreverComentario',2,NULL,NULL,NULL,1732569863,1732569863),('funcionario',1,NULL,NULL,NULL,1732569863,1732569863),('gostarComentario',2,NULL,NULL,NULL,1732569863,1732569863),('gostarLista',2,NULL,NULL,NULL,1732569863,1732569863),('moderador',1,NULL,NULL,NULL,1732569863,1732569863),('removerDesejados',2,NULL,NULL,NULL,1732569863,1732569863),('removerDistribuidoras',2,NULL,NULL,NULL,1732569863,1732569863),('removerEditoras',2,NULL,NULL,NULL,1732569863,1732569863),('removerFaq',2,NULL,NULL,NULL,1732569863,1732569863),('removerFavoritos',2,NULL,NULL,NULL,1732569863,1732569863),('removerFranquias',2,NULL,NULL,NULL,1732569863,1732569863),('removerGeneros',2,NULL,NULL,NULL,1732569863,1732569863),('removerItensCarrinho',2,NULL,NULL,NULL,1732569863,1732569863),('removerJogados',2,NULL,NULL,NULL,1732569863,1732569863),('removerJogos',2,NULL,NULL,NULL,1732569863,1732569863),('removerListas',2,NULL,NULL,NULL,1732569863,1732569863),('removerMetodosEnvio',2,NULL,NULL,NULL,1732569863,1732569863),('removerMetodosPagamento',2,NULL,NULL,NULL,1732569863,1732569863),('removerPlataformas',2,NULL,NULL,NULL,1732569863,1732569863),('removerProdutos',2,NULL,NULL,NULL,1732569863,1732569863),('removerScreenshots',2,NULL,NULL,NULL,1732569863,1732569863),('removerTags',2,NULL,NULL,NULL,1732569863,1732569863),('reporPassword',2,NULL,NULL,NULL,1732569863,1732569863),('seguirUtilizador',2,NULL,NULL,NULL,1732569863,1732569863),('usarCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesChaves',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesCodigosProm',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesDenuncias',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesDistribuidoras',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesEditoras',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesEncomendas',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesFaq',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesFranquias',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesGeneros',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesJogos',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesListas',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesMetodosEnvio',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesMetodosPagamento',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesPlataformas',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesProdutos',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesScreenshots',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesSugestao',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesTags',2,NULL,NULL,NULL,1732569863,1732569863),('verDetalhesUtilizadores',2,NULL,NULL,NULL,1732569863,1732569863),('verTudo',2,NULL,NULL,NULL,1732569863,1732569863),('visualizarDetalhesEncomendas',2,NULL,NULL,NULL,1732569863,1732569863),('visualizarEncomendas',2,'Visualizar todas as encomendas feitas com sucesso',NULL,NULL,1732569863,1732569863),('visualizarItensCarrinho',2,NULL,NULL,NULL,1732569863,1732569863),('visualizarPerfil',2,'Visualizar perfil público',NULL,NULL,1732569863,1732569863);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('funcionario','acederBackend'),('moderador','acederBackend'),('cliente','acederFrontend'),('admin','adicionarCodigosProm'),('cliente','adicionarDesejados'),('admin','adicionarDistribuidoras'),('admin','adicionarEditoras'),('admin','adicionarFaq'),('cliente','adicionarFavoritos'),('admin','adicionarFranquias'),('admin','adicionarGeneros'),('cliente','adicionarItensCarrinho'),('cliente','adicionarJogados'),('admin','adicionarJogos'),('cliente','adicionarJogosListas'),('admin','adicionarListas'),('cliente','adicionarListas'),('admin','adicionarMetodosEnvio'),('admin','adicionarMetodosPagamento'),('admin','adicionarPlataformas'),('funcionario','adicionarProdutos'),('admin','adicionarScreenshots'),('admin','adicionarTags'),('admin','adicionarUtilizadores'),('cliente','alterarDiposicao'),('moderador','alterarEstadoDenuncia'),('moderador','alterarEstadoEncomenda'),('moderador','alterarEstadoSugestao'),('cliente','apagarAvaliacao'),('moderador','apagarAvaliacao'),('admin','apagarChaves'),('admin','apagarCodigosProm'),('cliente','apagarComentario'),('moderador','apagarComentario'),('cliente','apagarDenuncia'),('moderador','apagarDenuncias'),('cliente','apagarSugestao'),('moderador','apagarSugestao'),('admin','associarRoles'),('admin','ativarCodigosProm'),('cliente','avaliarJogo'),('cliente','avaliarSugestao'),('moderador','banirUtilizador'),('cliente','bloquearUtilizador'),('funcionario','cancelarEncomenda'),('admin','criarChaves'),('cliente','criarSugestao'),('cliente','definirPrivacidadeFavoritos'),('cliente','definirPrivacidadeGostos'),('cliente','definirPrivacidadeJogados'),('cliente','definirPrivacidadeListas'),('cliente','deixarSeguir'),('cliente','denunciarUtilizador'),('admin','desativarCodigosProm'),('cliente','destacarJogosPerfil'),('cliente','editarAvaliacao'),('admin','editarChaves'),('admin','editarCodigosProm'),('cliente','editarComentario'),('cliente','editarDenuncia'),('moderador','editarDenuncias'),('cliente','editarDetalhesPerfil'),('cliente','editarDetalhesUtilizador'),('admin','editarDetalhesUtilizadores'),('admin','editarDistribuidoras'),('admin','editarEditoras'),('admin','editarFaq'),('admin','editarFranquias'),('admin','editarGeneros'),('cliente','editarItensCarrinho'),('admin','editarJogos'),('cliente','editarListas'),('admin','editarMetodosEnvio'),('admin','editarMetodosPagamento'),('admin','editarPlataformas'),('funcionario','editarProdutos'),('admin','editarScreenshots'),('cliente','editarSugestao'),('admin','editarTags'),('cliente','efetuarCompras'),('cliente','escreverComentario'),('admin','funcionario'),('cliente','gostarComentario'),('cliente','gostarLista'),('admin','moderador'),('cliente','removerDesejados'),('admin','removerDistribuidoras'),('admin','removerEditoras'),('admin','removerFaq'),('cliente','removerFavoritos'),('admin','removerFranquias'),('admin','removerGeneros'),('cliente','removerItensCarrinho'),('cliente','removerJogados'),('admin','removerJogos'),('cliente','removerListas'),('moderador','removerListas'),('admin','removerMetodosEnvio'),('admin','removerMetodosPagamento'),('admin','removerPlataformas'),('funcionario','removerProdutos'),('admin','removerScreenshots'),('admin','removerTags'),('cliente','reporPassword'),('cliente','seguirUtilizador'),('admin','usarCodigosProm'),('cliente','usarCodigosProm'),('admin','verDetalhesChaves'),('admin','verDetalhesCodigosProm'),('moderador','verDetalhesDenuncias'),('admin','verDetalhesDistribuidoras'),('funcionario','verDetalhesEncomendas'),('moderador','verDetalhesEncomendas'),('moderador','verDetalhesFaq'),('admin','verDetalhesFranquias'),('admin','verDetalhesGeneros'),('admin','verDetalhesJogos'),('moderador','verDetalhesListas'),('admin','verDetalhesMetodosEnvio'),('admin','verDetalhesMetodosPagamento'),('admin','verDetalhesPlataformas'),('funcionario','verDetalhesProdutos'),('admin','verDetalhesScreenshots'),('moderador','verDetalhesSugestao'),('admin','verDetalhesTags'),('admin','verDetalhesUtilizadores'),('moderador','verDetalhesUtilizadores'),('funcionario','verTudo'),('moderador','verTudo'),('cliente','visualizarDetalhesEncomendas'),('cliente','visualizarEncomendas'),('cliente','visualizarItensCarrinho'),('cliente','visualizarPerfil');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avaliacoes` (
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `numEstrelas` decimal(2,1) NOT NULL,
  `dataAvaliacao` timestamp NOT NULL,
  PRIMARY KEY (`utilizador_id`,`jogo_id`),
  KEY `fk_jogos_has_utilizadores_utilizadores1_idx` (`utilizador_id`),
  KEY `fk_jogos_has_utilizadores_jogos1_idx` (`jogo_id`),
  CONSTRAINT `fk_jogos_has_utilizadores_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  CONSTRAINT `fk_jogos_has_utilizadores_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacoes`
--

LOCK TABLES `avaliacoes` WRITE;
/*!40000 ALTER TABLE `avaliacoes` DISABLE KEYS */;
INSERT INTO `avaliacoes` VALUES (19,19,2.0,'2024-11-30 22:33:02'),(20,18,4.0,'2024-12-12 23:10:23'),(20,19,4.0,'2024-12-21 02:52:38'),(1,19,3.0,'2024-12-12 23:10:23');
/*!40000 ALTER TABLE `avaliacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrinhosCompras_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_carrinhosCompras_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinhos`
--

LOCK TABLES `carrinhos` WRITE;
/*!40000 ALTER TABLE `carrinhos` DISABLE KEYS */;
INSERT INTO `carrinhos` VALUES (2,19,150.00,5),(3,20,0.00,0),(4,22,NULL,NULL),(5,22,NULL,NULL),(6,23,NULL,NULL),(7,23,NULL,NULL),(8,24,NULL,NULL),(9,24,NULL,NULL),(10,25,NULL,NULL),(11,25,NULL,NULL);
/*!40000 ALTER TABLE `carrinhos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chaves`
--

DROP TABLE IF EXISTS `chaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chaves` (
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
  KEY `fk_chaves_plataformas1_idx` (`plataforma_id`),
  CONSTRAINT `fk_chaves_plataformas1` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`),
  CONSTRAINT `fk_chaves_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chaves`
--

LOCK TABLES `chaves` WRITE;
/*!40000 ALTER TABLE `chaves` DISABLE KEYS */;
INSERT INTO `chaves` VALUES (1,2,1,'ABCDG-GDFGF-SFSFS',NULL,NULL,0),(2,1,1,'gdfgd-fgdfg-dfgdf',NULL,NULL,1),(3,1,1,'gdfgd-fgdfg-dffff',NULL,NULL,1),(4,1,1,'gdfgw-t345t-534df',NULL,NULL,1),(5,1,1,'gdfdf-g345t-tegdf',NULL,NULL,1),(6,1,1,'SDSDX-CXCXC-F4343',NULL,NULL,1),(7,1,1,'gfd44-33434-343sd',NULL,NULL,1),(8,1,1,'AAAAA-4343F-DDFFD',NULL,NULL,1),(9,4,1,'dfgtw-ydh45-y3tty','2024-11-25 00:00:00','2024-11-25 00:00:00',0),(10,1,1,'dfgdg-34534-53453',NULL,NULL,1),(11,1,1,'34553-4dfgs-dgfdf',NULL,NULL,1),(12,1,1,'53454-35346-534fs',NULL,NULL,0),(13,1,1,'53434-5tdfg-dfgdf',NULL,NULL,0);
/*!40000 ALTER TABLE `chaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigospromocionais`
--

DROP TABLE IF EXISTS `codigospromocionais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `codigospromocionais` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `desconto` int NOT NULL,
  `isAtivo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigospromocionais`
--

LOCK TABLES `codigospromocionais` WRITE;
/*!40000 ALTER TABLE `codigospromocionais` DISABLE KEYS */;
INSERT INTO `codigospromocionais` VALUES (1,'SEMIVA',10,1),(2,'COMIVA',50,1);
/*!40000 ALTER TABLE `codigospromocionais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `comentario` text NOT NULL,
  `dataComentario` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentarios_avaliacoes1_idx` (`utilizador_id`,`jogo_id`),
  CONSTRAINT `fk_comentarios_avaliacoes1` FOREIGN KEY (`utilizador_id`, `jogo_id`) REFERENCES `avaliacoes` (`utilizador_id`, `jogo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (9,19,19,'let\'s go one moree','2024-12-01 04:01:11'),(10,20,19,'Es','2024-12-21 02:10:54');
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denuncias`
--

DROP TABLE IF EXISTS `denuncias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `denuncias` (
  `denunciante_id` int NOT NULL,
  `denunciado_id` int NOT NULL,
  `motivo` text NOT NULL,
  `dataDenuncia` timestamp NULL DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`denunciante_id`,`denunciado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores4_idx` (`denunciado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores3_idx` (`denunciante_id`),
  CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores3` FOREIGN KEY (`denunciante_id`) REFERENCES `userdata` (`id`),
  CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores4` FOREIGN KEY (`denunciado_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denuncias`
--

LOCK TABLES `denuncias` WRITE;
/*!40000 ALTER TABLE `denuncias` DISABLE KEYS */;
/*!40000 ALTER TABLE `denuncias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distribuidoras`
--

DROP TABLE IF EXISTS `distribuidoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `distribuidoras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distribuidoras`
--

LOCK TABLES `distribuidoras` WRITE;
/*!40000 ALTER TABLE `distribuidoras` DISABLE KEYS */;
INSERT INTO `distribuidoras` VALUES (3,' Deep Silver'),(2,' Warner Bros. Interactive Entertainment '),(6,'Activision Blizzard'),(10,'Bandai Namco'),(13,'Bethesda Softworks'),(4,'EA Games'),(14,'Mojang Studios'),(7,'Nintendo'),(9,'Sega'),(8,'Square Enix'),(12,'Take-Two Interactive'),(5,'Ubisoft');
/*!40000 ALTER TABLE `distribuidoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editoras`
--

DROP TABLE IF EXISTS `editoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `editoras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editoras`
--

LOCK TABLES `editoras` WRITE;
/*!40000 ALTER TABLE `editoras` DISABLE KEYS */;
INSERT INTO `editoras` VALUES (10,'Activision'),(11,'Capcom'),(8,'CD Projekt Red'),(2,'Dambuster Studios'),(3,'Day 1 Studios'),(9,'Electronic Arts'),(5,'Microsoft Studios'),(15,'Mojang Studios'),(14,'Nintendo'),(13,'Paradox Interactive'),(7,'Rockstar Games'),(4,'Sony Interactive Entertainment'),(6,'Square Enix'),(12,'Valve Corporation');
/*!40000 ALTER TABLE `editoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (2,'Como posso comprar um jogo','Para comprar um jogo, basta clicar no botão \"Comprar\" que se encontra na página do jogo que deseja adquirir. Após clicar no botão, o jogo será adicionado ao carrinho de compras e poderá finalizar a compra no carrinho de compras.');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faturas`
--

DROP TABLE IF EXISTS `faturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `pagamento_id` int NOT NULL,
  `envio_id` int NOT NULL,
  `codigo_id` int DEFAULT NULL,
  `dataEncomenda` timestamp NULL DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_encomendas_utilizadores1_idx` (`utilizador_id`),
  KEY `fk_encomendas_metodosPagamento1_idx` (`pagamento_id`),
  KEY `fk_encomendas_tiposEnvio1_idx` (`envio_id`),
  KEY `fk_encomendas_codigosPromocionais1_idx` (`codigo_id`),
  CONSTRAINT `fk_encomendas_codigosPromocionais1` FOREIGN KEY (`codigo_id`) REFERENCES `codigospromocionais` (`id`),
  CONSTRAINT `fk_encomendas_metodosPagamento1` FOREIGN KEY (`pagamento_id`) REFERENCES `metodospagamento` (`id`),
  CONSTRAINT `fk_encomendas_tiposEnvio1` FOREIGN KEY (`envio_id`) REFERENCES `metodosenvio` (`id`),
  CONSTRAINT `fk_encomendas_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faturas`
--

LOCK TABLES `faturas` WRITE;
/*!40000 ALTER TABLE `faturas` DISABLE KEYS */;
INSERT INTO `faturas` VALUES (27,20,1,2,NULL,'2024-12-02 18:19:01',55.00,7),(28,20,1,1,NULL,'2024-12-02 18:21:16',150.00,2),(31,20,1,1,NULL,'2024-12-02 18:24:48',150.00,2),(35,20,1,2,NULL,'2024-12-12 00:16:35',164.00,2),(37,20,1,2,NULL,'2024-12-14 05:28:55',131.00,2),(38,20,1,2,2,'2024-12-14 05:29:30',10.00,3),(90,20,1,2,NULL,'2030-11-01 00:00:00',60.00,5),(91,20,1,2,2,'2024-12-21 02:53:02',45.00,2);
/*!40000 ALTER TABLE `faturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franquias`
--

DROP TABLE IF EXISTS `franquias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `franquias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franquias`
--

LOCK TABLES `franquias` WRITE;
/*!40000 ALTER TABLE `franquias` DISABLE KEYS */;
INSERT INTO `franquias` VALUES (23,'Assassin\'s Creed'),(19,'Call of Duty'),(6,'Dead Island'),(4,'F.e.a.r'),(17,'Final Fantasy'),(5,'God of war'),(16,'Grand Theft Auto'),(22,'Halo'),(18,'Minecraft'),(3,'Resident Evil'),(21,'Super Mario'),(20,'The Legend of Zelda');
/*!40000 ALTER TABLE `franquias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generos`
--

DROP TABLE IF EXISTS `generos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `generos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generos`
--

LOCK TABLES `generos` WRITE;
/*!40000 ALTER TABLE `generos` DISABLE KEYS */;
INSERT INTO `generos` VALUES (3,'Ação'),(4,'Aventura'),(8,'Casual'),(5,'Corrida'),(7,'Estratégia'),(51,'Horror'),(6,'Indie'),(50,'Luta'),(53,'Música e Ritmo'),(52,'Plataforma'),(9,'RPG');
/*!40000 ALTER TABLE `generos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gostoscomentarios`
--

DROP TABLE IF EXISTS `gostoscomentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gostoscomentarios` (
  `utilizador_id` int NOT NULL,
  `comentario_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`comentario_id`),
  KEY `fk_utilizadores_has_comentarios_comentarios1_idx` (`comentario_id`),
  KEY `fk_utilizadores_has_comentarios_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_utilizadores_has_comentarios_comentarios1` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`),
  CONSTRAINT `fk_utilizadores_has_comentarios_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gostoscomentarios`
--

LOCK TABLES `gostoscomentarios` WRITE;
/*!40000 ALTER TABLE `gostoscomentarios` DISABLE KEYS */;
INSERT INTO `gostoscomentarios` VALUES (19,9),(20,10);
/*!40000 ALTER TABLE `gostoscomentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gostoslistas`
--

DROP TABLE IF EXISTS `gostoslistas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gostoslistas` (
  `utilizador_id` int NOT NULL,
  `lista_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`lista_id`),
  KEY `fk_userData_has_listas_listas1_idx` (`lista_id`),
  KEY `fk_userData_has_listas_userData1_idx` (`utilizador_id`),
  CONSTRAINT `fk_userData_has_listas_listas1` FOREIGN KEY (`lista_id`) REFERENCES `listas` (`id`),
  CONSTRAINT `fk_userData_has_listas_userData1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gostoslistas`
--

LOCK TABLES `gostoslistas` WRITE;
/*!40000 ALTER TABLE `gostoslistas` DISABLE KEYS */;
/*!40000 ALTER TABLE `gostoslistas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogos`
--

DROP TABLE IF EXISTS `jogos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogos` (
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
  KEY `fk_jogos_editoras1_idx` (`editora_id`),
  CONSTRAINT `fk_jogos_editoras1` FOREIGN KEY (`editora_id`) REFERENCES `editoras` (`id`),
  CONSTRAINT `fk_jogos_franquias1` FOREIGN KEY (`franquia_id`) REFERENCES `franquias` (`id`),
  CONSTRAINT `fk_jogos_publicadora1` FOREIGN KEY (`distribuidora_id`) REFERENCES `distribuidoras` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogos`
--

LOCK TABLES `jogos` WRITE;
/*!40000 ALTER TABLE `jogos` DISABLE KEYS */;
INSERT INTO `jogos` VALUES (18,'The Legend of Zelda: Breath of the Wild','2017-03-03','','https://www.youtube.com/watch?v=zw47_q9wbBE',20,'eMLxwZBk_Dn_RS45U_SFuBK4OH6FrJaQ.jpg',7,14),(19,'Grand Theft Auto V','2013-09-17','Um jogo de ação e aventura onde o jogador controla três criminosos num mundo aberto, com missões variadas e muito foco em exploração e interação com o ambiente.','https://www.youtube.com/watch?v=QkkoHAzjnUs',16,'bTQ9L3QeImzDrCp3vC1zDbOKOnQOhWFH.png',3,7),(20,'Minecraft','2011-11-11','Um jogo sandbox onde os jogadores podem construir e explorar um mundo em blocos, coletar recursos e criar suas próprias aventuras.','https://www.youtube.com/watch?v=Op6v3XkkC8w',18,'KiJ66NWZpUPuns7pAs_vDtwuV3SM9you.jpg',14,15),(21,'Call of Duty: Modern Warfare (2019)','2019-10-25',' Um reinício da famosa série, oferecendo uma experiência moderna e realista com foco em táticas e combate militar. O jogo inclui tanto a campanha quanto o modo multiplayer.','https://www.youtube.com/watch?v=8fNP9-pJ7JU',19,'ij9B9WGq6auzdwh-K5sEvihqp6XpswA6.jpg',6,10),(22,'Call of Duty: Black Ops Cold War','2020-11-13','Situado durante a Guerra Fria, o jogo traz missões de campanha, modos multiplayer e o modo zumbis. É conhecido pela sua narrativa imersiva e jogabilidade rápida.','https://www.youtube.com/watch?v=9VQ20xvA_Zk',19,'zZAo_5_cq_OGT11NiUp2MYjtHMyVuHEY.jpeg',6,10),(23,'Call of Duty: Vanguard','2021-11-05','Um jogo ambientado na Segunda Guerra Mundial, com foco nas campanhas militares em diferentes frentes de combate. Inclui modos de campanha, multiplayer e zumbis.','https://www.youtube.com/watch?v=X4nDk8t-KDY',19,'6NTluo8D5ZRNyFJy1s5KAdG6tnNuu3r5.png',6,10),(54,' F.E.A.R. 3','2021-06-21','Alma está esperando e um novo nível de terror cresce enquanto você e seu irmão canibal batalham em um pesadelo infernal. Lutem juntos ou morra sozinho em uma missão mortal para enfrentar a sua mãe perturbada. Os jogadores podem entrar no papel do Point Man, um soldado geneticamente melhorado com reflexos sobre-humanos e a habilidade de manipular o tempo, ou o espirito do seu irmão, Paxton Fettel, uma entidade paranormal que possui incríveis poderes psíquicos.','https://www.hltv.org/matches',4,'dITzAvvwSqVNyFKAOQx9b_nX78N7w4ut.png',2,11);
/*!40000 ALTER TABLE `jogos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogosgeneros`
--

DROP TABLE IF EXISTS `jogosgeneros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogosgeneros` (
  `jogo_id` int NOT NULL,
  `genero_id` int NOT NULL,
  PRIMARY KEY (`jogo_id`,`genero_id`),
  KEY `fk_jogos_has_generos_generos1_idx` (`genero_id`),
  KEY `fk_jogos_has_generos_jogos1_idx` (`jogo_id`),
  CONSTRAINT `fk_jogos_has_generos_generos1` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`),
  CONSTRAINT `fk_jogos_has_generos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogosgeneros`
--

LOCK TABLES `jogosgeneros` WRITE;
/*!40000 ALTER TABLE `jogosgeneros` DISABLE KEYS */;
INSERT INTO `jogosgeneros` VALUES (18,3),(19,3),(21,3),(22,3),(23,3),(54,3),(18,4),(19,4),(54,4),(19,5),(18,8),(54,8),(20,9),(20,50);
/*!40000 ALTER TABLE `jogosgeneros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogostags`
--

DROP TABLE IF EXISTS `jogostags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogostags` (
  `jogo_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`jogo_id`,`tag_id`),
  KEY `fk_jogos_has_tags_tags1_idx` (`tag_id`),
  KEY `fk_jogos_has_tags_jogos1_idx` (`jogo_id`),
  CONSTRAINT `fk_jogos_has_tags_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  CONSTRAINT `fk_jogos_has_tags_tags1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogostags`
--

LOCK TABLES `jogostags` WRITE;
/*!40000 ALTER TABLE `jogostags` DISABLE KEYS */;
INSERT INTO `jogostags` VALUES (19,7),(22,7),(18,8),(19,8),(20,8),(18,11),(20,13),(22,14),(23,16),(54,16),(18,17);
/*!40000 ALTER TABLE `jogostags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linhascarrinho`
--

DROP TABLE IF EXISTS `linhascarrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linhascarrinho` (
  `carrinhos_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `dataAdicao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`carrinhos_id`,`produtos_id`),
  KEY `fk_carrinhos_has_produtos_produtos1_idx` (`produtos_id`),
  KEY `fk_carrinhos_has_produtos_carrinhos1_idx` (`carrinhos_id`),
  CONSTRAINT `fk_carrinhos_has_produtos_carrinhos1` FOREIGN KEY (`carrinhos_id`) REFERENCES `carrinhos` (`id`),
  CONSTRAINT `fk_carrinhos_has_produtos_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhascarrinho`
--

LOCK TABLES `linhascarrinho` WRITE;
/*!40000 ALTER TABLE `linhascarrinho` DISABLE KEYS */;
/*!40000 ALTER TABLE `linhascarrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linhasfatura`
--

DROP TABLE IF EXISTS `linhasfatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linhasfatura` (
  `fatura_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `chave_id` int DEFAULT NULL,
  `precoUnitario` decimal(10,2) NOT NULL,
  UNIQUE KEY `unique_fatura_produto_chave` (`fatura_id`,`produto_id`,`chave_id`),
  KEY `fk_faturas_has_produtos_produtos1_idx` (`produto_id`),
  KEY `fk_faturas_has_produtos_faturas1_idx` (`fatura_id`),
  KEY `fk_faturas_has_produtos_chaves1_idx` (`chave_id`),
  CONSTRAINT `fk_faturas_has_produtos_chaves1` FOREIGN KEY (`chave_id`) REFERENCES `chaves` (`id`),
  CONSTRAINT `fk_faturas_has_produtos_faturas1` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  CONSTRAINT `fk_faturas_has_produtos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linhasfatura`
--

LOCK TABLES `linhasfatura` WRITE;
/*!40000 ALTER TABLE `linhasfatura` DISABLE KEYS */;
INSERT INTO `linhasfatura` VALUES (27,2,NULL,11.00),(27,2,NULL,11.00),(27,2,NULL,11.00),(27,2,NULL,11.00),(27,2,NULL,11.00),(28,1,1,30.00),(28,1,2,30.00),(28,1,3,30.00),(28,1,4,30.00),(28,1,5,30.00),(31,1,6,30.00),(31,1,7,30.00),(31,1,8,30.00),(31,1,10,30.00),(31,1,11,30.00),(35,2,NULL,11.00),(35,2,NULL,11.00),(35,2,NULL,11.00),(35,2,NULL,11.00),(35,4,NULL,20.00),(35,4,NULL,20.00),(35,4,NULL,20.00),(35,4,NULL,20.00),(35,4,NULL,20.00),(35,4,NULL,20.00),(37,4,NULL,20.00),(37,5,NULL,111.00),(38,4,NULL,20.00),(90,1,NULL,30.00),(90,1,NULL,30.00),(91,1,NULL,30.00),(91,1,NULL,30.00),(91,1,NULL,30.00);
/*!40000 ALTER TABLE `linhasfatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listabloqueios`
--

DROP TABLE IF EXISTS `listabloqueios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listabloqueios` (
  `utilizador_id` int NOT NULL,
  `utilizadorBloqueado_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`utilizadorBloqueado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores2_idx` (`utilizadorBloqueado_id`),
  KEY `fk_utilizadores_has_utilizadores_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`),
  CONSTRAINT `fk_utilizadores_has_utilizadores_utilizadores2` FOREIGN KEY (`utilizadorBloqueado_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listabloqueios`
--

LOCK TABLES `listabloqueios` WRITE;
/*!40000 ALTER TABLE `listabloqueios` DISABLE KEYS */;
/*!40000 ALTER TABLE `listabloqueios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listas`
--

DROP TABLE IF EXISTS `listas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` text,
  `dataCriacao` timestamp NULL DEFAULT NULL,
  `idUtilizador` int NOT NULL,
  `privacidade` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_listas_clientes1_idx` (`idUtilizador`),
  CONSTRAINT `fk_listas_clientes1` FOREIGN KEY (`idUtilizador`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listas`
--

LOCK TABLES `listas` WRITE;
/*!40000 ALTER TABLE `listas` DISABLE KEYS */;
/*!40000 ALTER TABLE `listas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listasjogos`
--

DROP TABLE IF EXISTS `listasjogos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listasjogos` (
  `lista_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `ordem` tinyint DEFAULT NULL,
  PRIMARY KEY (`lista_id`,`jogo_id`),
  KEY `fk_listas_has_jogos_jogos1_idx` (`jogo_id`),
  KEY `fk_listas_has_jogos_listas1_idx` (`lista_id`),
  CONSTRAINT `fk_listas_has_jogos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  CONSTRAINT `fk_listas_has_jogos_listas1` FOREIGN KEY (`lista_id`) REFERENCES `listas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listasjogos`
--

LOCK TABLES `listasjogos` WRITE;
/*!40000 ALTER TABLE `listasjogos` DISABLE KEYS */;
/*!40000 ALTER TABLE `listasjogos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodosenvio`
--

DROP TABLE IF EXISTS `metodosenvio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodosenvio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodosenvio`
--

LOCK TABLES `metodosenvio` WRITE;
/*!40000 ALTER TABLE `metodosenvio` DISABLE KEYS */;
INSERT INTO `metodosenvio` VALUES (2,'Entrega em Loja'),(1,'Entrega Online');
/*!40000 ALTER TABLE `metodosenvio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metodospagamento`
--

DROP TABLE IF EXISTS `metodospagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodospagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `isAtivo` tinyint(1) NOT NULL DEFAULT '0',
  `logotipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metodospagamento`
--

LOCK TABLES `metodospagamento` WRITE;
/*!40000 ALTER TABLE `metodospagamento` DISABLE KEYS */;
INSERT INTO `metodospagamento` VALUES (1,'Paypal',1,'wFaeTwVTvwiLddoFSGDH_CXhEYMwtzAe.png'),(2,'Cartão de crédito',1,'MqAzqBYIR0kZRVDUB553c87U75FruSu_.png');
/*!40000 ALTER TABLE `metodospagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plataformas`
--

DROP TABLE IF EXISTS `plataformas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plataformas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `logotipo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plataformas`
--

LOCK TABLES `plataformas` WRITE;
/*!40000 ALTER TABLE `plataformas` DISABLE KEYS */;
INSERT INTO `plataformas` VALUES (1,'PlayStation 4','ppaYpFgUxFPXeJUu0ctwrXu4f9aT9p0C.png'),(2,'PC','_DNdUPBwT64Xu1mMLZXqFDiMSu63vaks.png');
/*!40000 ALTER TABLE `plataformas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jogo_id` int NOT NULL,
  `plataforma_id` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_jogo_plataforma` (`jogo_id`,`plataforma_id`),
  KEY `fk_produtos_jogos1_idx` (`jogo_id`),
  KEY `fk_produtos_plataformas1_idx` (`plataforma_id`),
  CONSTRAINT `fk_produtos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  CONSTRAINT `fk_produtos_plataformas1` FOREIGN KEY (`plataforma_id`) REFERENCES `plataformas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,19,1,30.00,15),(2,19,2,11.00,96),(4,18,1,5.00,5),(5,20,2,111.00,19);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `screenshots`
--

DROP TABLE IF EXISTS `screenshots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `screenshots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jogo_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_screenshots_jogos1_idx` (`jogo_id`),
  CONSTRAINT `fk_screenshots_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `screenshots`
--

LOCK TABLES `screenshots` WRITE;
/*!40000 ALTER TABLE `screenshots` DISABLE KEYS */;
INSERT INTO `screenshots` VALUES (14,54,'8b5GxsCcKzb2xQ6TScu4HkphFEuLa9n3.png'),(20,18,'3gxUDMjbGkO4EAngXy7Fq9FZNQ6MuuPP.png'),(21,54,'jUIMa62iaT4c9A3eBGuLumiA1O1_JtWR.png'),(22,19,'SVWWwSGsV9XbQ66fblmB4Ms9_YEqvQQt.jpg'),(23,19,'i9anZG-sfnHBEkekTOUIxjVOgz5x0vpF.jpg'),(25,19,'65z7xMqW5c69EY8Qn6mHk54oM8Gf9FST.jpg');
/*!40000 ALTER TABLE `screenshots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguidores`
--

DROP TABLE IF EXISTS `seguidores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguidores` (
  `seguidor_id` int NOT NULL,
  `seguido_id` int NOT NULL,
  `dataSeguir` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`seguido_id`,`seguidor_id`),
  KEY `fk_seguidores_utilizadores1_idx` (`seguidor_id`),
  KEY `fk_seguidores_utilizadores2_idx` (`seguido_id`),
  CONSTRAINT `fk_seguidores_utilizadores1` FOREIGN KEY (`seguidor_id`) REFERENCES `userdata` (`id`),
  CONSTRAINT `fk_seguidores_utilizadores2` FOREIGN KEY (`seguido_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguidores`
--

LOCK TABLES `seguidores` WRITE;
/*!40000 ALTER TABLE `seguidores` DISABLE KEYS */;
INSERT INTO `seguidores` VALUES (19,20,NULL),(21,20,NULL),(20,21,NULL);
/*!40000 ALTER TABLE `seguidores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sugestoesfuncionalidades`
--

DROP TABLE IF EXISTS `sugestoesfuncionalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sugestoesfuncionalidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `descricao` text NOT NULL,
  `titulo` varchar(80) NOT NULL,
  `dataSugestao` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sugestoesFuncionalidades_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_sugestoesFuncionalidades_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sugestoesfuncionalidades`
--

LOCK TABLES `sugestoesfuncionalidades` WRITE;
/*!40000 ALTER TABLE `sugestoesfuncionalidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `sugestoesfuncionalidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (18,'Battle Royale'),(13,'Construção'),(12,'Criativo'),(11,'Exploração'),(16,'FPS'),(7,'Gráficos realistas'),(14,'Guerra Fria'),(6,'História rica'),(4,'Multiplayer'),(8,'Mundo aberto'),(9,'Puzzle'),(15,'Segunda Guerra Mundial'),(5,'Solo'),(17,'TPS');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userdata` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nome` varchar(200) NOT NULL,
  `nif` char(9) DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `biografia` varchar(150) DEFAULT NULL,
  `fotoCapa` varchar(255) DEFAULT NULL,
  `fotoPerfil` varchar(255) DEFAULT NULL,
  `privacidadeSeguidores` tinyint(1) NOT NULL DEFAULT '0',
  `privacidadePerfil` tinyint(1) NOT NULL DEFAULT '0',
  `privacidadeJogos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nif_UNIQUE` (`nif`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` VALUES (1,1,'Leandro Alves Pereira','123456789',NULL,NULL,NULL,NULL,0,0,0),(2,2,'Leandro Alves','123345678',NULL,'This is a new bio about the user.','/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_background.png','/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_user.jpg',0,0,0),(3,3,'João','123456790',NULL,NULL,NULL,NULL,0,0,0),(4,4,'Alice','999999999',NULL,NULL,NULL,NULL,0,0,0),(17,17,'Joana Alves','123456780',NULL,NULL,'/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_background.png','/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_user.jpg',0,0,0),(18,18,'Leandro Alves Pereira','223456789',NULL,NULL,'/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_background.png','/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_user.jpg',0,0,0),(19,19,'sdfsd','111111111',NULL,NULL,'/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_background.png','/Projeto-SistemasInfor/playxchangewebapp/frontend/web/images/default_user.jpg',0,0,0),(20,20,'aabb','534534534','2024-08-07','fggfd','lN-uyp1yi50MQl56ZeXShZHykH63MyCw.jpeg','ENB1oWlFX5lI3CphzYf1_VLbG_dY7nMa.jpeg',0,0,1),(21,21,'fgrs','123143567','2024-12-04','',NULL,NULL,0,0,0),(22,22,'João Pereira','aaaaaaaaa','2024-12-18',NULL,NULL,NULL,0,0,0),(23,23,'lpp','abaaaaaaa','2024-12-18',NULL,NULL,NULL,0,0,0),(24,24,'bcvbc','aabaaaaaa','2024-12-18',NULL,NULL,NULL,0,0,0),(25,25,'a','133456789','2024-12-18',NULL,NULL,NULL,0,0,0);
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizacaocodigos`
--

DROP TABLE IF EXISTS `utilizacaocodigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizacaocodigos` (
  `utilizador_id` int NOT NULL,
  `codigo_id` int NOT NULL,
  PRIMARY KEY (`utilizador_id`,`codigo_id`),
  KEY `fk_utilizadores_has_codigosPromocionais_codigosPromocionais_idx` (`codigo_id`),
  KEY `fk_utilizadores_has_codigosPromocionais_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_utilizadores_has_codigosPromocionais_codigosPromocionais1` FOREIGN KEY (`codigo_id`) REFERENCES `codigospromocionais` (`id`),
  CONSTRAINT `fk_utilizadores_has_codigosPromocionais_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizacaocodigos`
--

LOCK TABLES `utilizacaocodigos` WRITE;
/*!40000 ALTER TABLE `utilizacaocodigos` DISABLE KEYS */;
INSERT INTO `utilizacaocodigos` VALUES (20,2);
/*!40000 ALTER TABLE `utilizacaocodigos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilizadoresjogos`
--

DROP TABLE IF EXISTS `utilizadoresjogos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilizadoresjogos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilizador_id` int NOT NULL,
  `jogo_id` int NOT NULL,
  `isJogado` tinyint(1) NOT NULL DEFAULT '0',
  `isDesejado` tinyint(1) NOT NULL DEFAULT '0',
  `isFavorito` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`utilizador_id`,`jogo_id`),
  KEY `fk_utilizadores_has_jogos_jogos1_idx` (`jogo_id`),
  KEY `fk_utilizadores_has_jogos_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_utilizadores_has_jogos_jogos1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`),
  CONSTRAINT `fk_utilizadores_has_jogos_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilizadoresjogos`
--

LOCK TABLES `utilizadoresjogos` WRITE;
/*!40000 ALTER TABLE `utilizadoresjogos` DISABLE KEYS */;
INSERT INTO `utilizadoresjogos` VALUES (1,19,21,0,0,0),(2,19,18,1,1,1),(3,19,19,1,1,1),(4,19,22,0,0,0),(5,19,20,1,1,1),(6,19,54,0,0,1),(7,20,18,0,1,1),(8,20,19,1,1,1),(9,20,22,1,0,0);
/*!40000 ALTER TABLE `utilizadoresjogos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votosfuncionalidades`
--

DROP TABLE IF EXISTS `votosfuncionalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votosfuncionalidades` (
  `utilizador_id` int NOT NULL,
  `funcionalidade_id` int NOT NULL,
  `voto` tinyint(1) NOT NULL,
  PRIMARY KEY (`utilizador_id`,`funcionalidade_id`),
  KEY `fk_utilizadores_has_sugestoesFuncionalidades_sugestoesFunci_idx` (`funcionalidade_id`),
  KEY `fk_utilizadores_has_sugestoesFuncionalidades_utilizadores1_idx` (`utilizador_id`),
  CONSTRAINT `fk_utilizadores_has_sugestoesFuncionalidades_sugestoesFuncion1` FOREIGN KEY (`funcionalidade_id`) REFERENCES `sugestoesfuncionalidades` (`id`),
  CONSTRAINT `fk_utilizadores_has_sugestoesFuncionalidades_utilizadores1` FOREIGN KEY (`utilizador_id`) REFERENCES `userdata` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votosfuncionalidades`
--

LOCK TABLES `votosfuncionalidades` WRITE;
/*!40000 ALTER TABLE `votosfuncionalidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `votosfuncionalidades` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-28 14:24:04
