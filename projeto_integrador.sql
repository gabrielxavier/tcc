-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Dez-2014 às 14:38
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projeto_integrador`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `nome`, `sigla`, `created_at`, `updated_at`) VALUES
(1, 'Tecnologia em Sistemas para Internet', 'TSI', '2014-10-28 23:20:21', '0000-00-00 00:00:00'),
(2, 'Tecnologia em Sistemas de Informação', 'TDS', '2014-10-28 23:20:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricao`
--

CREATE TABLE IF NOT EXISTS `inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `id_projeto` int(11) NOT NULL,
  `id_aluno1` int(11) DEFAULT NULL,
  `id_aluno2` int(11) DEFAULT NULL,
  `id_orientador` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_situacao` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `titulo` (`titulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Extraindo dados da tabela `inscricao`
--

INSERT INTO `inscricao` (`id`, `titulo`, `descricao`, `id_projeto`, `id_aluno1`, `id_aluno2`, `id_orientador`, `id_turma`, `created_at`, `updated_at`, `id_situacao`) VALUES
(19, 'Sistema web acadêmico responsivo', 'lorem ipsum', 41, 1, 0, 2, 2, '2014-12-06 16:12:34', '2014-12-06 16:17:10', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricao_situacao`
--

CREATE TABLE IF NOT EXISTS `inscricao_situacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_situacao` int(11) NOT NULL,
  `id_inscricao` int(11) NOT NULL,
  `comentario` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `id_autor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Extraindo dados da tabela `inscricao_situacao`
--

INSERT INTO `inscricao_situacao` (`id`, `id_situacao`, `id_inscricao`, `comentario`, `created_at`, `updated_at`, `id_autor`) VALUES
(63, 1, 19, NULL, '2014-12-06 16:12:34', '0000-00-00 00:00:00', 1),
(64, 2, 19, 'qweqeqweqeqw', '2014-12-06 16:12:48', '0000-00-00 00:00:00', 1),
(65, 4, 19, 'wwwww', '2014-12-06 16:15:44', '0000-00-00 00:00:00', 2),
(66, 2, 19, 'ergeger', '2014-12-06 16:16:25', '0000-00-00 00:00:00', 1),
(67, 3, 19, 'awweqeqqeqqe', '2014-12-06 16:17:10', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `ativo` int(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tags` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`id`, `titulo`, `descricao`, `ativo`, `created_at`, `updated_at`, `tags`) VALUES
(41, 'Projeto de usabilidade em sistemas web', 'Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.', 1, '2014-12-06 15:44:10', '2014-12-08 23:06:09', 'usabilidade,sistemas web,w3c'),
(42, 'aaa', 'aaa', 0, '2014-12-08 23:05:36', '2014-12-08 23:05:36', 'usabilidade,teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_curso`
--

CREATE TABLE IF NOT EXISTS `projeto_curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_projeto` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Extraindo dados da tabela `projeto_curso`
--

INSERT INTO `projeto_curso` (`id`, `id_projeto`, `id_curso`, `created_at`, `updated_at`) VALUES
(78, 41, 1, '2014-12-08 23:06:09', '2014-12-08 23:06:09'),
(79, 41, 2, '2014-12-08 23:06:09', '2014-12-08 23:06:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_professor`
--

CREATE TABLE IF NOT EXISTS `projeto_professor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_projeto` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Extraindo dados da tabela `projeto_professor`
--

INSERT INTO `projeto_professor` (`id`, `id_projeto`, `id_professor`, `created_at`, `updated_at`) VALUES
(59, 41, 5, '2014-12-08 23:06:09', '2014-12-08 23:06:09'),
(60, 41, 2, '2014-12-08 23:06:09', '2014-12-08 23:06:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE IF NOT EXISTS `situacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `situacao`
--

INSERT INTO `situacao` (`id`, `valor`, `updated_at`, `created_at`) VALUES
(1, 'Nova', '0000-00-00 00:00:00', '2014-10-30 22:26:24'),
(2, 'Aguardando aprovação', '0000-00-00 00:00:00', '2014-10-30 22:26:24'),
(3, 'Aprovada', '0000-00-00 00:00:00', '2014-10-30 22:26:24'),
(4, 'Reprovada', '0000-00-00 00:00:00', '2014-10-30 22:26:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE IF NOT EXISTS `turma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `sigla` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`id`, `nome`, `sigla`, `created_at`, `updated_at`, `id_curso`) VALUES
(1, 'Tecnologia da Informacao', 'TDS351', '2014-08-30 22:30:44', '2014-11-10 22:11:04', 2),
(2, 'Sistemas para internet', 'TSI341', '2014-08-30 22:30:44', '2014-11-10 22:11:10', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma_aluno`
--

CREATE TABLE IF NOT EXISTS `turma_aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `turma_aluno`
--

INSERT INTO `turma_aluno` (`id`, `id_aluno`, `id_turma`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2014-09-02 23:43:39', '2014-09-27 19:25:00'),
(2, 4, 1, '2014-11-06 22:55:55', '2014-11-06 22:55:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `matricula` varchar(20) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `ultimo_acesso` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`, `matricula`, `id_perfil`, `ultimo_acesso`) VALUES
(1, 'Gabriel Xavier', 'gabriel.xavier.joinville@gmail.com', 'bfb1ce4d0179347b12e828d09a9ff482', '2014-08-30 22:26:00', '2014-12-09 02:25:22', '112003827', 1, '2014-12-09 02:25:22'),
(2, 'Paulo Manseira', 'antonio@gmail.com', '3f9cd3c7b11eb1bae99dddb3d05da3c5', '2014-09-02 01:14:14', '2014-12-08 22:43:00', 'professor', 2, '2014-12-08 22:43:00'),
(3, 'Administrador', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2014-09-05 01:35:36', '2014-12-09 02:25:59', 'admin', 3, '2014-12-09 02:25:59'),
(4, 'Angelo Gugelmin', 'angelo@gmail.com', '98a8d3f11b400ddc06d7343375b71a84', '2014-11-06 22:55:32', '2014-12-08 22:29:47', 'angelo', 1, '2014-12-08 22:29:47'),
(5, 'Francini Reitz', 'francini.reitz@sociesc.org.br', '3f9cd3c7b11eb1bae99dddb3d05da3c5', '2014-12-06 15:52:12', '2014-12-06 15:52:12', 'francini', 2, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
