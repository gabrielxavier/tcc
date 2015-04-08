-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Abr-2015 às 00:32
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
-- Estrutura da tabela `arquivo`
--

CREATE TABLE IF NOT EXISTS `arquivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caminho` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `arquivo`
--

INSERT INTO `arquivo` (`id`, `caminho`, `nome`, `created_at`, `updated_at`) VALUES
(9, 'arquivos/jnfnsdfjsd-20150317002609.pps', 'jnfnsdfjsd', '2015-03-17 15:26:09', '0000-00-00 00:00:00'),
(10, 'arquivos/asdasda-20150321161600.jpg', 'asdasda', '2015-03-21 07:16:00', '0000-00-00 00:00:00'),
(11, 'arquivos/asdsada-20150321162330.xlsx', 'asdsada', '2015-03-21 07:23:30', '0000-00-00 00:00:00'),
(12, 'arquivos/bh-hjhhj--hj-jhh-hh-20150324220911.pdf', 'bh hjhhj  hj jhh hh', '2015-03-25 01:09:11', '0000-00-00 00:00:00');

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
  `id_orientador` int(11) DEFAULT NULL,
  `id_turma` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_situacao` int(11) DEFAULT '1',
  `semestre` varchar(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `titulo` (`titulo`),
  KEY `id_projeto` (`id_projeto`),
  KEY `id_aluno1` (`id_aluno1`),
  KEY `id_turma` (`id_turma`),
  KEY `id_situacao` (`id_situacao`),
  KEY `id_orientador` (`id_orientador`),
  KEY `id_aluno2` (`id_aluno2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `inscricao`
--

INSERT INTO `inscricao` (`id`, `titulo`, `descricao`, `id_projeto`, `id_aluno1`, `id_aluno2`, `id_orientador`, `id_turma`, `created_at`, `updated_at`, `id_situacao`, `semestre`) VALUES
(1, 'Sistema web acadêmico para gerenciamento de projetos de TCC', 'descricao', 1, 1, NULL, 2, 2, '2014-12-09 22:59:35', '2015-04-08 00:22:18', 3, '2015/1'),
(2, 'asdasdasdadsa', 'sdadasdasa', 2, 1, NULL, 5, 1, '2015-03-21 08:11:24', '2015-04-08 00:22:18', 2, '2015/1'),
(3, 'asdas', 'dasdasasdas', 1, 1, NULL, 5, 2, '2015-03-21 08:11:40', '2015-04-08 00:22:18', 1, '2015/1'),
(4, 'sfadas', 'dasdasdasda', 2, 1, NULL, 5, 1, '2015-03-21 08:12:08', '2015-04-08 00:22:18', 2, '2015/1'),
(5, 'asda', 'dasdasdas', 1, 1, NULL, 5, 2, '2015-03-21 08:12:17', '2015-04-08 00:22:18', 2, '2015/1'),
(6, 'teste', 'teste', 1, 1, NULL, 2, 2, '2015-04-07 04:07:44', '2015-04-08 00:22:18', 3, '2015/1'),
(7, 'aa', 'aaa', 1, 1, NULL, 2, 2, '2015-04-07 04:09:06', '2015-04-08 00:22:18', 4, '2015/1'),
(9, 'teste2', 'teste', 2, 1, 6, 5, 1, '2015-04-08 00:29:24', '2015-04-08 00:30:20', 1, '2015/1'),
(10, 'teste', 'teste', 2, 1, 6, 5, 1, '2015-04-08 00:30:43', '2015-04-08 00:30:43', 1, '2015/1');

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
  PRIMARY KEY (`id`),
  KEY `id_inscricao` (`id_inscricao`),
  KEY `id_situacao` (`id_situacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `inscricao_situacao`
--

INSERT INTO `inscricao_situacao` (`id`, `id_situacao`, `id_inscricao`, `comentario`, `created_at`, `updated_at`, `id_autor`) VALUES
(1, 1, 1, 'Inscrição criada com sucesso.', '2014-12-09 22:59:35', '0000-00-00 00:00:00', 1),
(2, 2, 1, 'Projeto ok', '2014-12-09 23:00:50', '0000-00-00 00:00:00', 1),
(3, 4, 1, 'O tema já foi solicitado, por favor altere seu tema.', '2014-12-09 23:02:08', '0000-00-00 00:00:00', 2),
(4, 2, 1, 'Alterei o tema, favor avaliar novamente,', '2014-12-09 23:04:18', '0000-00-00 00:00:00', 1),
(5, 3, 1, 'Tema ok', '2014-12-09 23:04:40', '0000-00-00 00:00:00', 2),
(6, 1, 2, 'Inscrição criada com sucesso.', '2015-03-21 08:09:48', '0000-00-00 00:00:00', 1),
(7, 2, 2, 'Inscrição enviada para aprovação com sucesso.', '2015-03-21 08:09:48', '0000-00-00 00:00:00', 1),
(8, 1, 2, 'Inscrição criada com sucesso.', '2015-03-21 08:11:24', '0000-00-00 00:00:00', 1),
(9, 2, 2, 'Inscrição enviada para aprovação com sucesso.', '2015-03-21 08:11:24', '0000-00-00 00:00:00', 1),
(10, 1, 3, 'Inscrição criada com sucesso.', '2015-03-21 08:11:40', '0000-00-00 00:00:00', 1),
(11, 1, 4, 'Inscrição criada com sucesso.', '2015-03-21 08:12:08', '0000-00-00 00:00:00', 1),
(12, 2, 4, 'Inscrição enviada para aprovação com sucesso.', '2015-03-21 08:12:08', '0000-00-00 00:00:00', 1),
(13, 1, 5, 'Inscrição criada com sucesso.', '2015-03-21 08:12:17', '0000-00-00 00:00:00', 1),
(14, 2, 5, 'Inscrição enviada para aprovação com sucesso.', '2015-04-07 04:06:21', '0000-00-00 00:00:00', 1),
(15, 1, 6, 'Inscrição criada com sucesso.', '2015-04-07 04:07:44', '0000-00-00 00:00:00', 1),
(16, 2, 6, 'Inscrição enviada para aprovação com sucesso.', '2015-04-07 04:07:44', '0000-00-00 00:00:00', 1),
(17, 3, 6, NULL, '2015-04-07 04:08:08', '0000-00-00 00:00:00', 2),
(18, 1, 7, 'Inscrição criada com sucesso.', '2015-04-07 04:09:06', '0000-00-00 00:00:00', 1),
(19, 2, 7, 'Inscrição enviada para aprovação com sucesso.', '2015-04-07 04:09:06', '0000-00-00 00:00:00', 1),
(20, 4, 7, NULL, '2015-04-07 04:09:23', '0000-00-00 00:00:00', 2),
(23, 1, 9, 'Inscrição criada com sucesso.', '2015-04-08 00:29:24', '0000-00-00 00:00:00', 1),
(24, 1, 10, 'Inscrição criada com sucesso.', '2015-04-08 00:30:43', '0000-00-00 00:00:00', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`id`, `titulo`, `descricao`, `ativo`, `created_at`, `updated_at`, `tags`) VALUES
(1, 'Análise de usabilidade portal unisociesc', 'Descricao', 1, '2014-12-09 22:56:05', '2014-12-09 22:56:05', 'usabilidade,analise,unisociesc,portal'),
(2, 'teste', 'teste', 1, '2014-12-09 22:56:34', '2014-12-09 22:56:34', 'teste'),
(3, 'teste2', 'teste', 0, '2015-03-24 13:06:02', '2015-03-25 01:08:12', 'asdas,sad'),
(4, 'aaa', 'aaa', 0, '2015-03-25 01:07:21', '2015-03-25 01:07:21', 'aa,aaw');

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
  PRIMARY KEY (`id`),
  KEY `id_projeto` (`id_projeto`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `projeto_curso`
--

INSERT INTO `projeto_curso` (`id`, `id_projeto`, `id_curso`, `created_at`, `updated_at`) VALUES
(4, 2, 2, '2015-03-14 06:32:36', '2015-03-14 18:32:36'),
(5, 1, 1, '2015-03-14 06:32:59', '2015-03-14 18:32:59'),
(7, 3, 1, '2015-03-25 01:08:12', '2015-03-25 01:08:12');

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
  PRIMARY KEY (`id`),
  KEY `id_professor` (`id_professor`),
  KEY `id_projeto` (`id_projeto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `projeto_professor`
--

INSERT INTO `projeto_professor` (`id`, `id_projeto`, `id_professor`, `created_at`, `updated_at`) VALUES
(5, 2, 5, '2015-03-14 06:32:36', '2015-03-14 18:32:36'),
(6, 1, 5, '2015-03-14 06:32:59', '2015-03-14 18:32:59'),
(7, 1, 2, '2015-03-14 06:32:59', '2015-03-14 18:32:59'),
(9, 3, 2, '2015-03-25 01:08:12', '2015-03-25 01:08:12');

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
  `semestre` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`id`, `nome`, `sigla`, `created_at`, `updated_at`, `id_curso`, `semestre`) VALUES
(1, 'Tecnologia em Sistemas de Informação 351', 'TDS351', '2014-08-30 22:30:44', '2015-03-14 20:04:02', 2, '2015/1'),
(2, 'Tecnologia em Sistemas para internet 341', 'TSI341', '2014-08-30 22:30:44', '2015-03-14 20:04:21', 1, '2015/1'),
(3, 'teste', 'teste', '2015-04-08 00:23:25', '2015-04-08 00:23:30', 2, '2014/1');

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
  PRIMARY KEY (`id`),
  KEY `id_aluno` (`id_aluno`),
  KEY `id_turma` (`id_turma`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `turma_aluno`
--

INSERT INTO `turma_aluno` (`id`, `id_aluno`, `id_turma`, `created_at`, `updated_at`) VALUES
(13, 1, 1, '2015-04-07 04:06:03', '2015-04-07 04:06:03'),
(14, 1, 2, '2015-04-07 04:06:03', '2015-04-07 04:06:03');

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
  `telefone_residencial` varchar(15) DEFAULT NULL,
  `telefone_comercial` varchar(15) DEFAULT NULL,
  `telefone_celular` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `nome` (`nome`),
  KEY `nome_2` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`, `matricula`, `id_perfil`, `ultimo_acesso`, `telefone_residencial`, `telefone_comercial`, `telefone_celular`) VALUES
(1, 'Gabriel Xavier', 'gabriel.xavier.joinville@gmail.com', 'bfb1ce4d0179347b12e828d09a9ff482', '2014-08-30 22:26:00', '2015-04-08 00:30:49', '112003827', 1, '2015-04-08 00:30:49', '(47) 3436-7861', '(47) 3333-3333', '(47) 9999-9999'),
(2, 'Paulo Manseira', 'antonio@gmail.com', '3f9cd3c7b11eb1bae99dddb3d05da3c5', '2014-09-02 01:14:14', '2015-04-07 04:09:27', 'professor', 2, '2015-04-07 04:09:27', NULL, NULL, NULL),
(3, 'Administrador', 'gabriel.xavier@a2c.com.br', '21232f297a57a5a743894a0e4a801fc3', '2014-09-05 01:35:36', '2015-04-08 00:23:32', 'admin', 3, '2015-04-08 00:23:32', '(47) 3333-2222', '(47) 3333-1111', '(47) 9933-2010'),
(5, 'Francini Reitz', 'francini.reitz@sociesc.org.br', '3f9cd3c7b11eb1bae99dddb3d05da3c5', '2014-12-06 15:52:12', '2014-12-06 15:52:12', 'francini', 2, NULL, NULL, NULL, NULL),
(6, 'angelo', 'angelo', 'angelo', '2015-04-08 00:30:10', '2015-04-08 00:30:10', 'angelo', 1, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `inscricao_ibfk_6` FOREIGN KEY (`id_aluno2`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `inscricao_ibfk_1` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id`),
  ADD CONSTRAINT `inscricao_ibfk_2` FOREIGN KEY (`id_aluno1`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `inscricao_ibfk_3` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id`),
  ADD CONSTRAINT `inscricao_ibfk_4` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id`),
  ADD CONSTRAINT `inscricao_ibfk_5` FOREIGN KEY (`id_orientador`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `inscricao_situacao`
--
ALTER TABLE `inscricao_situacao`
  ADD CONSTRAINT `inscricao_situacao_ibfk_2` FOREIGN KEY (`id_situacao`) REFERENCES `situacao` (`id`),
  ADD CONSTRAINT `inscricao_situacao_ibfk_1` FOREIGN KEY (`id_inscricao`) REFERENCES `inscricao` (`id`);

--
-- Limitadores para a tabela `projeto_curso`
--
ALTER TABLE `projeto_curso`
  ADD CONSTRAINT `projeto_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `projeto_curso_ibfk_1` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id`);

--
-- Limitadores para a tabela `projeto_professor`
--
ALTER TABLE `projeto_professor`
  ADD CONSTRAINT `projeto_professor_ibfk_2` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id`),
  ADD CONSTRAINT `projeto_professor_ibfk_1` FOREIGN KEY (`id_professor`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Limitadores para a tabela `turma_aluno`
--
ALTER TABLE `turma_aluno`
  ADD CONSTRAINT `turma_aluno_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id`),
  ADD CONSTRAINT `turma_aluno_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
