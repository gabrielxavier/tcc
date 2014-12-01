-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 01-Dez-2014 às 23:25
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `inscricao`
--

INSERT INTO `inscricao` (`id`, `titulo`, `descricao`, `id_projeto`, `id_aluno1`, `id_aluno2`, `id_orientador`, `id_turma`, `created_at`, `updated_at`, `id_situacao`) VALUES
(11, 'Projeto tccs', 'Gerenciados de inscrições', 38, 1, 0, 2, 2, '2014-11-05 22:35:13', '2014-12-01 23:03:11', 4),
(12, 'fhftyquy', 'fuyty', 39, 1, 0, 2, 2, '2014-11-05 23:18:04', '2014-12-01 22:58:12', 2),
(13, 'sadas', 'dasda', 37, 1, 0, 2, 2, '2014-11-06 23:08:42', '2014-11-10 22:32:03', 2),
(14, 'Usabilidade site globo.com', 'Tcc sobre usabiliaded....wwwt88787', 40, 1, 4, 2, 2, '2014-11-10 20:36:48', '2014-11-10 22:31:21', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=55 ;

--
-- Extraindo dados da tabela `inscricao_situacao`
--

INSERT INTO `inscricao_situacao` (`id`, `id_situacao`, `id_inscricao`, `comentario`, `created_at`, `updated_at`, `id_autor`) VALUES
(35, 1, 11, NULL, '2014-11-05 22:35:13', '0000-00-00 00:00:00', 1),
(43, 2, 11, 'Teste', '2014-11-05 22:42:30', '0000-00-00 00:00:00', 1),
(44, 4, 11, 'Faltou alguma coisa', '2014-11-05 22:45:00', '0000-00-00 00:00:00', 2),
(45, 1, 12, NULL, '2014-11-05 23:18:04', '0000-00-00 00:00:00', 1),
(46, 2, 12, NULL, '2014-11-05 23:23:17', '0000-00-00 00:00:00', 1),
(47, 1, 13, NULL, '2014-11-06 23:08:42', '0000-00-00 00:00:00', 1),
(48, 1, 14, NULL, '2014-11-10 20:36:48', '0000-00-00 00:00:00', 1),
(49, 2, 14, 'kasdladasda', '2014-11-10 20:38:05', '0000-00-00 00:00:00', 1),
(50, 4, 14, 'Nao foi aprovado.', '2014-11-10 20:39:35', '0000-00-00 00:00:00', 2),
(51, 2, 14, 'Corrigi ,a,sda, a.', '2014-11-10 20:40:09', '0000-00-00 00:00:00', 1),
(52, 3, 14, 'xXsl pl da', '2014-11-10 20:40:52', '0000-00-00 00:00:00', 2),
(53, 2, 13, 'ww', '2014-11-10 22:32:03', '0000-00-00 00:00:00', 1);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`id`, `titulo`, `descricao`, `ativo`, `created_at`, `updated_at`) VALUES
(37, 'Catapulta', 'ajdnasijdnsa', 1, '2014-09-27 19:07:07', '2014-09-27 19:07:07'),
(38, 'Projeto usabilidade', 'Usabilidade', 1, '2014-09-29 23:40:20', '2014-09-29 23:40:20'),
(39, 'Desenvolvimento API facebook2', 'desc', 1, '2014-11-05 22:52:53', '2014-11-05 23:08:18'),
(40, 'Projeto de usabilidade em sistemas web', 'Descricao do projeto', 1, '2014-11-10 20:35:06', '2014-11-10 20:35:06');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Extraindo dados da tabela `projeto_curso`
--

INSERT INTO `projeto_curso` (`id`, `id_projeto`, `id_curso`, `created_at`, `updated_at`) VALUES
(25, 31, 1, '2014-09-02 02:08:40', '2014-09-02 02:08:40'),
(29, 32, 1, '2014-09-02 02:09:36', '2014-09-02 02:09:36'),
(30, 32, 1, '2014-09-02 02:09:36', '2014-09-02 02:09:36'),
(36, 33, 2, '2014-09-03 00:36:10', '2014-09-03 00:36:10'),
(37, 34, 2, '2014-09-03 00:36:25', '2014-09-03 00:36:25'),
(39, 36, 1, '2014-09-24 00:12:51', '2014-09-24 00:12:51'),
(44, 35, 1, '2014-09-24 00:13:20', '2014-09-24 00:13:20'),
(45, 35, 2, '2014-09-24 00:13:20', '2014-09-24 00:13:20'),
(48, 38, 1, '2014-09-29 23:40:20', '2014-09-29 23:40:20'),
(49, 38, 2, '2014-09-29 23:40:20', '2014-09-29 23:40:20'),
(54, 39, 1, '2014-11-05 23:12:32', '2014-11-05 23:12:32'),
(55, 39, 2, '2014-11-05 23:12:32', '2014-11-05 23:12:32'),
(56, 40, 1, '2014-11-10 20:35:06', '2014-11-10 20:35:06'),
(57, 40, 2, '2014-11-10 20:35:06', '2014-11-10 20:35:06'),
(60, 37, 1, '2014-12-01 23:22:10', '2014-12-01 23:22:10'),
(61, 37, 2, '2014-12-01 23:22:10', '2014-12-01 23:22:10');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `projeto_professor`
--

INSERT INTO `projeto_professor` (`id`, `id_projeto`, `id_professor`, `created_at`, `updated_at`) VALUES
(15, 31, 2, '2014-09-02 02:08:40', '2014-09-02 02:08:40'),
(19, 32, 1, '2014-09-02 02:09:36', '2014-09-02 02:09:36'),
(21, 33, 1, '2014-09-03 00:36:10', '2014-09-03 00:36:10'),
(22, 33, 2, '2014-09-03 00:36:10', '2014-09-03 00:36:10'),
(23, 34, 1, '2014-09-03 00:36:25', '2014-09-03 00:36:25'),
(25, 36, 1, '2014-09-24 00:12:51', '2014-09-24 00:12:51'),
(30, 35, 1, '2014-09-24 00:13:20', '2014-09-24 00:13:20'),
(31, 35, 2, '2014-09-24 00:13:20', '2014-09-24 00:13:20'),
(33, 38, 2, '2014-09-29 23:40:20', '2014-09-29 23:40:20'),
(39, 39, 2, '2014-11-05 23:12:32', '2014-11-05 23:12:32'),
(40, 40, 2, '2014-11-10 20:35:06', '2014-11-10 20:35:06'),
(42, 37, 2, '2014-12-01 23:22:10', '2014-12-01 23:22:10');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`, `matricula`, `id_perfil`, `ultimo_acesso`) VALUES
(1, 'Gabriel Xavier', 'gabriel.xavier.joinville@gmail.com', 'tele3436', '2014-08-30 22:26:00', '2014-12-01 23:17:26', '112003827', 1, '2014-12-01 23:17:26'),
(2, 'Paulo Manseira', 'antonio@gmail.com', 'professor', '2014-09-02 01:14:14', '2014-12-01 22:35:57', 'professor', 2, '2014-12-01 22:35:57'),
(3, 'Administrador', 'admin', 'admin', '2014-09-05 01:35:36', '2014-12-01 23:22:39', 'admin', 3, '2014-12-01 23:22:39'),
(4, 'Angelo Gugelmin', 'angelo@gmail.com', 'angelo', '2014-11-06 22:55:32', '2014-11-06 23:55:06', 'angelo', 1, '2014-11-06 23:55:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
