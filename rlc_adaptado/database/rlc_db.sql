-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2025 às 20:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rlc_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id_aluno` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `id_turma` int(11) DEFAULT NULL,
  `numero_chamada` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'matricula'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id_aluno`, `nome`, `id_turma`, `numero_chamada`, `status`) VALUES
(48, 'Bruna Yasmim Gros Sampaio', 1, 1, 'matricula'),
(49, 'Bruno Otavio Frederico Trento', 1, 2, 'matricula'),
(50, 'Caio Henrique Vucik Palacio', 1, 3, 'matricula'),
(51, 'Camila Wang de Oliveira', 1, 4, 'matricula'),
(52, 'Denis Matheus da Cruz Fedrigo', 1, 5, 'matricula'),
(53, 'Eduardo Santos de Cerqueira', 1, 6, 'matricula'),
(54, 'Enzo Buck Siqueira de Morais', 1, 7, 'matricula'),
(55, 'Evilin Galvão Furlan', 1, 8, 'matricula'),
(56, 'Fábio Messias Felix Gonçalves', 1, 9, 'matricula'),
(57, 'Felipe Magro Macedo', 1, 10, 'matricula'),
(58, 'Gabriel Giovanni Gonzaga Pezavento', 1, 11, 'matricula'),
(59, 'Gabriel Henrique Gonçalves Moraes', 1, 12, 'matricula'),
(60, 'Gabriel Todeschini Faria', 1, 13, 'matricula'),
(61, 'Gabriel Ventura Luzzi', 1, 14, 'matricula'),
(62, 'Gabrielly Cordeiro Martins', 1, 15, 'matricula'),
(63, 'Helena Maria Lima Potulski', 1, 16, 'matricula'),
(64, 'João Pedro Batista dos Santos', 1, 17, 'matricula'),
(65, 'Julia de Lima Carneiro', 1, 18, 'matricula'),
(66, 'Kawan Birck Uto', 1, 19, 'transferido'),
(67, 'Lucas Castaman Francener', 1, 20, 'transferido'),
(68, 'Luiz Gustavo Klak Oliveira', 1, 21, 'matricula'),
(69, 'Tiago Albino Rodrigues', 1, 22, 'matricula'),
(70, 'Vinícius Rafael Ribeiro de Morais', 1, 23, 'matricula'),
(71, '2º TESTE ', 2, 1, 'matricula');

-- --------------------------------------------------------

--
-- Estrutura para tabela `coordenadores`
--

CREATE TABLE `coordenadores` (
  `id_coordenador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nome`, `descricao`) VALUES
(1, 'Desenvolvimento de Sistemas', NULL),
(2, 'Administração', NULL),
(3, 'Estética', NULL),
(4, 'Programação de Jogos Digitais', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs_acesso`
--

CREATE TABLE `logs_acesso` (
  `id_log` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `data_acesso` datetime NOT NULL,
  `acao_realizada` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `logs_acesso`
--

INSERT INTO `logs_acesso` (`id_log`, `id_usuario`, `data_acesso`, `acao_realizada`) VALUES
(1, 1, '2025-05-27 22:03:32', 'Login realizado'),
(2, 3, '2025-05-27 22:03:50', 'Login realizado'),
(3, 3, '2025-05-27 22:04:49', 'Login realizado'),
(4, 3, '2025-05-27 22:10:48', 'Login realizado'),
(5, 3, '2025-05-30 13:26:03', 'Login realizado'),
(6, 3, '2025-05-30 13:39:07', 'Login realizado'),
(7, 1, '2025-05-30 13:41:10', 'Login realizado'),
(8, 1, '2025-05-30 13:41:11', 'Login realizado'),
(9, 2, '2025-05-30 13:51:32', 'Login realizado'),
(10, 2, '2025-05-30 13:51:33', 'Login realizado'),
(11, 1, '2025-05-30 13:51:56', 'Login realizado'),
(12, 1, '2025-05-30 13:54:19', 'Login realizado'),
(13, 1, '2025-05-30 13:54:33', 'Login realizado'),
(14, 1, '2025-05-30 13:56:12', 'Login realizado'),
(15, 1, '2025-05-30 13:57:10', 'Login realizado'),
(16, 1, '2025-05-30 13:57:29', 'Login realizado'),
(17, 3, '2025-05-30 13:57:42', 'Login realizado'),
(18, 1, '2025-05-30 13:58:14', 'Login realizado'),
(19, 2, '2025-05-30 13:58:52', 'Login realizado'),
(20, 1, '2025-05-30 14:32:19', 'Login realizado'),
(21, 1, '2025-05-30 14:32:20', 'Login realizado'),
(22, 1, '2025-05-30 14:34:29', 'Login realizado'),
(23, 2, '2025-05-30 14:34:37', 'Login realizado'),
(24, 2, '2025-05-30 14:35:00', 'Login realizado'),
(25, 1, '2025-05-30 14:35:11', 'Login realizado'),
(26, 1, '2025-05-30 14:39:34', 'Login realizado'),
(27, 3, '2025-05-30 14:39:56', 'Login realizado'),
(28, 1, '2025-05-30 14:40:04', 'Login realizado'),
(29, 2, '2025-05-30 14:40:11', 'Login realizado'),
(30, 1, '2025-05-30 14:45:46', 'Login realizado'),
(31, 1, '2025-05-30 14:54:37', 'Login realizado'),
(32, 1, '2025-05-30 14:55:03', 'Login realizado'),
(33, 1, '2025-05-30 14:55:06', 'Login realizado'),
(34, 1, '2025-05-30 15:00:53', 'Login realizado'),
(35, 3, '2025-05-30 15:01:09', 'Login realizado'),
(36, 3, '2025-05-30 15:01:53', 'Login realizado'),
(37, 3, '2025-06-03 13:20:55', 'Login realizado'),
(38, 3, '2025-06-03 13:21:05', 'Login realizado'),
(39, 2, '2025-06-03 13:22:15', 'Login realizado'),
(40, 1, '2025-06-03 13:22:25', 'Login realizado'),
(41, 3, '2025-06-03 13:24:31', 'Login realizado'),
(42, 3, '2025-06-03 13:25:08', 'Login realizado'),
(43, 2, '2025-06-03 13:29:57', 'Login realizado'),
(44, 2, '2025-06-03 13:35:29', 'Login realizado'),
(45, 1, '2025-06-03 13:38:17', 'Login realizado'),
(46, 2, '2025-06-03 17:20:11', 'Login realizado'),
(47, 3, '2025-06-03 17:20:21', 'Login realizado'),
(48, 3, '2025-06-03 20:32:13', 'Login realizado'),
(49, 1, '2025-06-03 20:53:39', 'Login realizado'),
(50, 3, '2025-06-03 20:54:39', 'Login realizado'),
(51, 1, '2025-06-03 20:54:51', 'Login realizado'),
(52, 1, '2025-06-03 20:56:58', 'Login realizado'),
(53, 7, '2025-06-03 20:58:11', 'Login realizado'),
(54, 3, '2025-06-03 21:31:12', 'Login realizado'),
(55, 7, '2025-06-03 21:31:27', 'Login realizado'),
(56, 7, '2025-06-03 21:39:06', 'Login realizado'),
(57, 7, '2025-06-03 21:45:39', 'Login realizado'),
(58, 7, '2025-06-03 21:45:43', 'Login realizado'),
(59, 2, '2025-06-03 21:46:02', 'Login realizado'),
(60, 7, '2025-06-03 21:46:14', 'Login realizado'),
(61, 7, '2025-06-03 21:49:46', 'Login realizado'),
(62, 7, '2025-06-03 21:53:42', 'Login realizado'),
(63, 3, '2025-06-19 17:06:14', 'Login realizado'),
(64, 3, '2025-06-19 17:08:01', 'Login realizado'),
(65, 3, '2025-06-19 17:09:59', 'Login realizado'),
(66, 3, '2025-07-07 16:26:29', 'Login realizado'),
(67, 3, '2025-07-07 16:29:17', 'Login realizado'),
(68, 3, '2025-07-07 16:29:53', 'Login realizado'),
(69, 3, '2025-07-07 16:33:01', 'Login realizado'),
(70, 3, '2025-07-07 16:33:12', 'Login realizado'),
(71, 3, '2025-07-07 16:36:07', 'Login realizado'),
(72, 3, '2025-07-07 16:39:27', 'Login realizado'),
(73, 1, '2025-07-07 16:52:22', 'Login realizado'),
(74, 8, '2025-07-07 16:53:54', 'Login realizado'),
(75, 8, '2025-07-07 16:58:16', 'Login realizado'),
(76, 8, '2025-07-07 17:03:49', 'Login realizado'),
(77, 8, '2025-07-07 17:49:24', 'Login realizado'),
(78, 8, '2025-07-14 21:04:13', 'Login realizado'),
(79, 8, '2025-07-14 21:14:18', 'Login realizado'),
(80, 8, '2025-07-21 20:45:13', 'Login realizado'),
(81, 2, '2025-07-21 20:49:37', 'Login realizado'),
(82, 8, '2025-07-21 20:51:10', 'Login realizado'),
(83, 8, '2025-07-21 20:51:12', 'Login realizado'),
(84, 8, '2025-07-28 13:18:56', 'Login realizado'),
(85, 8, '2025-08-11 13:22:29', 'Login realizado'),
(86, 2, '2025-08-11 13:23:25', 'Login realizado'),
(87, 2, '2025-08-11 14:20:51', 'Login realizado'),
(88, 2, '2025-08-18 13:40:38', 'Login realizado'),
(89, 1, '2025-08-25 13:22:15', 'Login realizado'),
(90, 7, '2025-08-25 13:22:53', 'Login realizado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedagogos`
--

CREATE TABLE `pedagogos` (
  `id_pedagogo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `registros_presenca`
--

CREATE TABLE `registros_presenca` (
  `id_registro` int(11) NOT NULL,
  `id_aluno` int(11) DEFAULT NULL,
  `id_turma` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `status` enum('presente','atrasado','saiu_antecipado','falta') NOT NULL,
  `observacao` text DEFAULT NULL,
  `data_horario_obs` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `registros_presenca`
--

INSERT INTO `registros_presenca` (`id_registro`, `id_aluno`, `id_turma`, `data`, `status`, `observacao`, `data_horario_obs`) VALUES
(1, 48, 1, '2025-07-07', 'presente', '', NULL),
(2, 49, 1, '2025-07-07', 'presente', '', NULL),
(3, 50, 1, '2025-07-07', 'presente', '', NULL),
(4, 51, 1, '2025-07-07', 'presente', '', NULL),
(5, 52, 1, '2025-07-07', 'presente', '', NULL),
(6, 53, 1, '2025-07-07', 'presente', '', NULL),
(7, 54, 1, '2025-07-07', 'presente', '', NULL),
(8, 55, 1, '2025-07-07', 'presente', '', NULL),
(9, 56, 1, '2025-07-07', 'presente', '', NULL),
(10, 57, 1, '2025-07-07', 'presente', 'matou a  aula', NULL),
(11, 58, 1, '2025-07-07', 'presente', '', NULL),
(12, 59, 1, '2025-07-07', 'presente', '', NULL),
(13, 60, 1, '2025-07-07', 'presente', '', NULL),
(14, 61, 1, '2025-07-07', 'presente', '', NULL),
(15, 62, 1, '2025-07-07', 'presente', '', NULL),
(16, 63, 1, '2025-07-07', 'presente', '', NULL),
(17, 64, 1, '2025-07-07', 'presente', '', NULL),
(18, 65, 1, '2025-07-07', 'presente', '', NULL),
(19, 68, 1, '2025-07-07', 'presente', '', NULL),
(20, 69, 1, '2025-07-07', 'presente', '', NULL),
(21, 70, 1, '2025-07-07', 'presente', '', NULL),
(22, NULL, 1, '2025-07-07', 'presente', '', NULL),
(23, NULL, 1, '2025-07-07', 'presente', '', NULL),
(24, NULL, 1, '2025-07-07', 'presente', '', NULL),
(25, NULL, 1, '2025-07-07', 'presente', '', NULL),
(26, NULL, 1, '2025-07-07', 'presente', '', NULL),
(27, NULL, 1, '2025-07-07', 'presente', '', NULL),
(28, NULL, 1, '2025-07-07', 'presente', '', NULL),
(29, NULL, 1, '2025-07-07', 'presente', '', NULL),
(30, NULL, 1, '2025-07-07', 'presente', '', NULL),
(31, NULL, 1, '2025-07-07', 'presente', '', NULL),
(32, NULL, 1, '2025-07-07', 'presente', '', NULL),
(33, NULL, 1, '2025-07-07', 'presente', '', NULL),
(34, NULL, 1, '2025-07-07', 'presente', '', NULL),
(35, NULL, 1, '2025-07-07', 'presente', '', NULL),
(36, NULL, 1, '2025-07-07', 'presente', '', NULL),
(37, NULL, 1, '2025-07-07', 'presente', '', NULL),
(38, NULL, 1, '2025-07-07', 'presente', '', NULL),
(39, NULL, 1, '2025-07-07', 'presente', '', NULL),
(40, NULL, 1, '2025-07-07', 'presente', '', NULL),
(41, NULL, 1, '2025-07-07', 'presente', '', NULL),
(42, NULL, 1, '2025-07-07', 'presente', '', NULL),
(43, 48, 1, '2025-07-15', 'presente', '', NULL),
(44, 49, 1, '2025-07-15', 'presente', '', NULL),
(45, 50, 1, '2025-07-15', 'presente', '', NULL),
(46, 51, 1, '2025-07-15', 'presente', '', NULL),
(47, 52, 1, '2025-07-15', 'presente', '', NULL),
(48, 53, 1, '2025-07-15', 'presente', '', NULL),
(49, 54, 1, '2025-07-15', 'presente', '', NULL),
(50, 55, 1, '2025-07-15', 'presente', '', NULL),
(51, 56, 1, '2025-07-15', 'presente', '', NULL),
(52, 57, 1, '2025-07-15', 'presente', '', NULL),
(53, 58, 1, '2025-07-15', 'presente', '', NULL),
(54, 59, 1, '2025-07-15', 'presente', '', NULL),
(55, 60, 1, '2025-07-15', 'presente', '', NULL),
(56, 61, 1, '2025-07-15', 'presente', '', NULL),
(57, 62, 1, '2025-07-15', 'presente', '', NULL),
(58, 63, 1, '2025-07-15', 'presente', '', NULL),
(59, 64, 1, '2025-07-15', 'presente', '', NULL),
(60, 65, 1, '2025-07-15', 'presente', '', NULL),
(61, 68, 1, '2025-07-15', 'presente', '', NULL),
(62, 69, 1, '2025-07-15', 'presente', '', NULL),
(63, 70, 1, '2025-07-15', 'presente', 'a', NULL),
(64, NULL, 1, '2025-07-22', '', '', NULL),
(65, NULL, 1, '2025-07-22', '', '', NULL),
(66, NULL, 1, '2025-07-22', '', '', NULL),
(67, NULL, 1, '2025-07-22', '', '', NULL),
(68, NULL, 1, '2025-07-22', '', '', NULL),
(69, NULL, 1, '2025-07-22', '', '', NULL),
(70, NULL, 1, '2025-07-22', '', '', NULL),
(71, NULL, 1, '2025-07-22', '', '', NULL),
(72, NULL, 1, '2025-07-22', '', '', NULL),
(73, NULL, 1, '2025-07-22', '', '', NULL),
(74, NULL, 1, '2025-07-22', '', '', NULL),
(75, NULL, 1, '2025-07-22', '', '', NULL),
(76, NULL, 1, '2025-07-22', '', '', NULL),
(77, NULL, 1, '2025-07-22', '', '', NULL),
(78, NULL, 1, '2025-07-22', '', '', NULL),
(79, 63, 1, '2025-07-22', '', '', NULL),
(80, NULL, 1, '2025-07-22', '', '', NULL),
(81, NULL, 1, '2025-07-22', '', '', NULL),
(82, NULL, 1, '2025-07-22', '', '', NULL),
(83, NULL, 1, '2025-07-22', '', '', NULL),
(84, NULL, 1, '2025-07-22', '', '', NULL),
(85, 48, 1, '2025-07-22', 'presente', '', NULL),
(86, 49, 1, '2025-07-22', 'presente', '', NULL),
(87, 50, 1, '2025-07-22', 'presente', '', NULL),
(88, 51, 1, '2025-07-22', 'presente', '', NULL),
(89, 52, 1, '2025-07-22', 'presente', '', NULL),
(90, 53, 1, '2025-07-22', 'presente', '', NULL),
(91, 54, 1, '2025-07-22', 'presente', '', NULL),
(92, 55, 1, '2025-07-22', 'presente', '', NULL),
(93, 56, 1, '2025-07-22', 'presente', '', NULL),
(94, 57, 1, '2025-07-22', 'presente', '', NULL),
(95, 58, 1, '2025-07-22', 'presente', '', NULL),
(96, 59, 1, '2025-07-22', 'presente', 'Bonito', NULL),
(97, 60, 1, '2025-07-22', 'presente', '', NULL),
(98, 61, 1, '2025-07-22', 'presente', '', NULL),
(99, 62, 1, '2025-07-22', 'presente', '', NULL),
(100, 64, 1, '2025-07-22', 'presente', '', NULL),
(101, 65, 1, '2025-07-22', 'presente', '', NULL),
(102, 68, 1, '2025-07-22', 'presente', '', NULL),
(103, 69, 1, '2025-07-22', 'presente', '', NULL),
(104, 70, 1, '2025-07-22', 'presente', '', NULL),
(105, NULL, 1, '2025-07-22', 'presente', '', NULL),
(106, NULL, 1, '2025-07-22', 'presente', '', NULL),
(107, NULL, 1, '2025-07-22', 'presente', '', NULL),
(108, NULL, 1, '2025-07-22', 'presente', '', NULL),
(109, NULL, 1, '2025-07-22', 'presente', '', NULL),
(110, NULL, 1, '2025-07-22', 'presente', '', NULL),
(111, NULL, 1, '2025-07-22', 'presente', '', NULL),
(112, NULL, 1, '2025-07-22', 'presente', '', NULL),
(113, NULL, 1, '2025-07-22', 'presente', '', NULL),
(114, NULL, 1, '2025-07-22', 'presente', '', NULL),
(115, NULL, 1, '2025-07-22', 'presente', '', NULL),
(116, NULL, 1, '2025-07-22', 'presente', '', NULL),
(117, NULL, 1, '2025-07-22', 'presente', '', NULL),
(118, NULL, 1, '2025-07-22', 'presente', '', NULL),
(119, NULL, 1, '2025-07-22', 'presente', '', NULL),
(120, NULL, 1, '2025-07-22', '', '', NULL),
(121, NULL, 1, '2025-07-22', 'presente', '', NULL),
(122, NULL, 1, '2025-07-22', 'presente', '', NULL),
(123, NULL, 1, '2025-07-22', 'presente', '', NULL),
(124, NULL, 1, '2025-07-22', 'presente', '', NULL),
(125, NULL, 1, '2025-07-22', 'presente', '', NULL),
(126, NULL, 1, '2025-07-22', 'presente', '', NULL),
(127, NULL, 1, '2025-07-22', 'presente', '', NULL),
(128, NULL, 1, '2025-07-22', 'presente', '', NULL),
(129, NULL, 1, '2025-07-22', 'presente', '', NULL),
(130, NULL, 1, '2025-07-22', 'presente', '', NULL),
(131, NULL, 1, '2025-07-22', 'presente', '', NULL),
(132, NULL, 1, '2025-07-22', 'presente', '', NULL),
(133, NULL, 1, '2025-07-22', 'presente', '', NULL),
(134, NULL, 1, '2025-07-22', 'presente', '', NULL),
(135, NULL, 1, '2025-07-22', 'presente', '', NULL),
(136, NULL, 1, '2025-07-22', 'presente', '', NULL),
(137, NULL, 1, '2025-07-22', 'presente', '', NULL),
(138, NULL, 1, '2025-07-22', 'presente', '', NULL),
(139, NULL, 1, '2025-07-22', 'presente', '', NULL),
(140, NULL, 1, '2025-07-22', 'presente', '', NULL),
(141, 63, 1, '2025-07-22', '', '', NULL),
(142, NULL, 1, '2025-07-22', 'presente', '', NULL),
(143, NULL, 1, '2025-07-22', 'presente', '', NULL),
(144, NULL, 1, '2025-07-22', 'presente', '', NULL),
(145, NULL, 1, '2025-07-22', 'presente', '', NULL),
(146, NULL, 1, '2025-07-22', 'presente', '', NULL),
(147, NULL, 1, '2025-07-22', 'presente', '', NULL),
(148, NULL, 1, '2025-07-22', 'presente', '', NULL),
(149, NULL, 1, '2025-07-22', 'presente', '', NULL),
(150, NULL, 1, '2025-07-22', 'presente', '', NULL),
(151, NULL, 1, '2025-07-22', 'presente', '', NULL),
(152, NULL, 1, '2025-07-22', 'presente', '', NULL),
(153, NULL, 1, '2025-07-22', 'presente', '', NULL),
(154, NULL, 1, '2025-07-22', 'presente', '', NULL),
(155, NULL, 1, '2025-07-22', 'presente', '', NULL),
(156, NULL, 1, '2025-07-22', 'presente', '', NULL),
(157, NULL, 1, '2025-07-22', 'presente', '', NULL),
(158, NULL, 1, '2025-07-22', 'presente', '', NULL),
(159, NULL, 1, '2025-07-22', 'presente', '', NULL),
(160, NULL, 1, '2025-07-22', 'presente', '', NULL),
(161, NULL, 1, '2025-07-22', 'presente', '', NULL),
(162, 63, 1, '2025-07-22', '', '', NULL),
(163, NULL, 1, '2025-07-22', 'presente', '', NULL),
(164, NULL, 1, '2025-07-22', 'presente', '', NULL),
(165, NULL, 1, '2025-07-22', 'presente', '', NULL),
(166, NULL, 1, '2025-07-22', 'presente', '', NULL),
(167, NULL, 1, '2025-07-22', 'presente', '', NULL),
(168, NULL, 1, '2025-07-22', 'presente', '', NULL),
(169, NULL, 1, '2025-07-22', 'presente', '', NULL),
(170, NULL, 1, '2025-07-22', 'presente', '', NULL),
(171, NULL, 1, '2025-07-22', 'presente', '', NULL),
(172, NULL, 1, '2025-07-22', 'presente', '', NULL),
(173, NULL, 1, '2025-07-22', 'presente', '', NULL),
(174, NULL, 1, '2025-07-22', 'presente', '', NULL),
(175, NULL, 1, '2025-07-22', 'presente', '', NULL),
(176, NULL, 1, '2025-07-22', 'presente', '', NULL),
(177, NULL, 1, '2025-07-22', 'presente', '', NULL),
(178, NULL, 1, '2025-07-22', 'presente', '', NULL),
(179, NULL, 1, '2025-07-22', 'presente', '', NULL),
(180, NULL, 1, '2025-07-22', 'presente', '', NULL),
(181, NULL, 1, '2025-07-22', 'presente', '', NULL),
(182, NULL, 1, '2025-07-22', 'presente', '', NULL),
(183, 63, 1, '2025-07-22', '', '', NULL),
(184, NULL, 1, '2025-07-22', 'presente', '', NULL),
(185, NULL, 1, '2025-07-22', 'presente', '', NULL),
(186, NULL, 1, '2025-07-22', 'presente', '', NULL),
(187, NULL, 1, '2025-07-22', 'presente', '', NULL),
(188, NULL, 1, '2025-07-22', 'presente', '', NULL),
(189, NULL, 1, '2025-07-22', 'presente', '', NULL),
(190, NULL, 1, '2025-07-22', 'presente', '', NULL),
(191, NULL, 1, '2025-07-22', 'presente', '', NULL),
(192, NULL, 1, '2025-07-22', 'presente', '', NULL),
(193, NULL, 1, '2025-07-22', 'presente', '', NULL),
(194, NULL, 1, '2025-07-22', 'presente', '', NULL),
(195, NULL, 1, '2025-07-22', 'presente', '', NULL),
(196, NULL, 1, '2025-07-22', 'presente', '', NULL),
(197, NULL, 1, '2025-07-22', 'presente', '', NULL),
(198, NULL, 1, '2025-07-22', 'presente', '', NULL),
(199, NULL, 1, '2025-07-22', 'presente', '', NULL),
(200, NULL, 1, '2025-07-22', 'presente', '', NULL),
(201, NULL, 1, '2025-07-22', 'presente', '', NULL),
(202, NULL, 1, '2025-07-22', 'presente', '', NULL),
(203, NULL, 1, '2025-07-22', 'presente', '', NULL),
(204, 63, 1, '2025-07-22', '', '', NULL),
(205, NULL, 1, '2025-07-22', 'presente', '', NULL),
(206, NULL, 1, '2025-07-22', 'presente', '', NULL),
(207, NULL, 1, '2025-07-22', 'presente', '', NULL),
(208, NULL, 1, '2025-07-22', 'presente', '', NULL),
(209, NULL, 1, '2025-07-22', 'presente', '', NULL),
(210, NULL, 1, '2025-07-28', '', '', NULL),
(211, NULL, 1, '2025-07-28', '', '', NULL),
(212, NULL, 1, '2025-07-28', '', '', NULL),
(213, NULL, 1, '2025-07-28', '', '', NULL),
(214, NULL, 1, '2025-07-28', '', '', NULL),
(215, NULL, 1, '2025-07-28', '', '', NULL),
(216, NULL, 1, '2025-07-28', '', '', NULL),
(217, 55, 1, '2025-07-28', '', '', NULL),
(218, NULL, 1, '2025-07-28', '', '', NULL),
(219, NULL, 1, '2025-07-28', '', '', NULL),
(220, NULL, 1, '2025-07-28', '', '', NULL),
(221, NULL, 1, '2025-07-28', '', '', NULL),
(222, NULL, 1, '2025-07-28', '', '', NULL),
(223, NULL, 1, '2025-07-28', '', '', NULL),
(224, NULL, 1, '2025-07-28', '', '', NULL),
(225, NULL, 1, '2025-07-28', '', '', NULL),
(226, NULL, 1, '2025-07-28', '', '', NULL),
(227, NULL, 1, '2025-07-28', '', '', NULL),
(228, NULL, 1, '2025-07-28', '', '', NULL),
(229, NULL, 1, '2025-07-28', '', '', NULL),
(230, NULL, 1, '2025-07-28', '', '', NULL),
(231, 48, 1, '2025-08-11', '', '', NULL),
(232, 49, 1, '2025-08-11', '', '', NULL),
(233, NULL, 1, '2025-08-11', '', '', NULL),
(234, NULL, 1, '2025-08-11', '', '', NULL),
(235, NULL, 1, '2025-08-11', '', '', NULL),
(236, NULL, 1, '2025-08-11', '', '', NULL),
(237, NULL, 1, '2025-08-11', '', '', NULL),
(238, NULL, 1, '2025-08-11', '', '', NULL),
(239, NULL, 1, '2025-08-11', '', '', NULL),
(240, NULL, 1, '2025-08-11', '', '', NULL),
(241, NULL, 1, '2025-08-11', '', '', NULL),
(242, NULL, 1, '2025-08-11', '', '', NULL),
(243, NULL, 1, '2025-08-11', '', '', NULL),
(244, NULL, 1, '2025-08-11', '', '', NULL),
(245, NULL, 1, '2025-08-11', '', '', NULL),
(246, NULL, 1, '2025-08-11', '', '', NULL),
(247, NULL, 1, '2025-08-11', '', '', NULL),
(248, NULL, 1, '2025-08-11', '', '', NULL),
(249, NULL, 1, '2025-08-11', '', '', NULL),
(250, NULL, 1, '2025-08-11', '', '', NULL),
(251, NULL, 1, '2025-08-11', '', '', NULL),
(252, 48, 1, '2025-08-18', 'presente', '', NULL),
(253, 49, 1, '2025-08-18', 'presente', '', NULL),
(254, 50, 1, '2025-08-18', 'presente', '', NULL),
(255, 51, 1, '2025-08-18', 'presente', '', NULL),
(256, 52, 1, '2025-08-18', 'presente', '', NULL),
(257, 53, 1, '2025-08-18', 'presente', '', NULL),
(258, 54, 1, '2025-08-18', 'presente', '', NULL),
(259, 55, 1, '2025-08-18', 'presente', '', NULL),
(260, 56, 1, '2025-08-18', 'presente', '', NULL),
(261, 57, 1, '2025-08-18', 'presente', '', NULL),
(262, 58, 1, '2025-08-18', 'presente', '', NULL),
(263, 59, 1, '2025-08-18', 'presente', '', NULL),
(264, 60, 1, '2025-08-18', 'presente', '', NULL),
(265, 61, 1, '2025-08-18', 'presente', '', NULL),
(266, 62, 1, '2025-08-18', 'presente', '', NULL),
(267, 63, 1, '2025-08-18', 'presente', '', NULL),
(268, 64, 1, '2025-08-18', 'presente', '', NULL),
(269, 65, 1, '2025-08-18', 'presente', '', NULL),
(270, 68, 1, '2025-08-18', 'presente', '', NULL),
(271, 69, 1, '2025-08-18', 'presente', '', NULL),
(272, 70, 1, '2025-08-18', 'presente', '', NULL),
(273, 48, 1, '2025-08-25', '', '', NULL),
(274, NULL, 1, '2025-08-25', '', '', NULL),
(275, NULL, 1, '2025-08-25', '', '', NULL),
(276, NULL, 1, '2025-08-25', '', '', NULL),
(277, NULL, 1, '2025-08-25', '', '', NULL),
(278, NULL, 1, '2025-08-25', '', '', NULL),
(279, NULL, 1, '2025-08-25', '', '', NULL),
(280, NULL, 1, '2025-08-25', '', '', NULL),
(281, NULL, 1, '2025-08-25', '', '', NULL),
(282, NULL, 1, '2025-08-25', '', '', NULL),
(283, NULL, 1, '2025-08-25', '', '', NULL),
(284, NULL, 1, '2025-08-25', '', '', NULL),
(285, NULL, 1, '2025-08-25', '', '', NULL),
(286, NULL, 1, '2025-08-25', '', '', NULL),
(287, NULL, 1, '2025-08-25', '', '', NULL),
(288, NULL, 1, '2025-08-25', '', '', NULL),
(289, NULL, 1, '2025-08-25', '', '', NULL),
(290, NULL, 1, '2025-08-25', '', '', NULL),
(291, NULL, 1, '2025-08-25', '', '', NULL),
(292, NULL, 1, '2025-08-25', '', '', NULL),
(293, NULL, 1, '2025-08-25', '', '', NULL),
(294, NULL, 1, '2025-08-25', '', '', NULL),
(295, NULL, 1, '2025-08-25', '', '', NULL),
(296, NULL, 1, '2025-08-25', '', '', NULL),
(297, NULL, 1, '2025-08-25', '', '', NULL),
(298, NULL, 1, '2025-08-25', '', '', NULL),
(299, NULL, 1, '2025-08-25', '', '', NULL),
(300, NULL, 1, '2025-08-25', '', '', NULL),
(301, NULL, 1, '2025-08-25', '', '', NULL),
(302, NULL, 1, '2025-08-25', '', '', NULL),
(303, NULL, 1, '2025-08-25', '', '', NULL),
(304, NULL, 1, '2025-08-25', '', '', NULL),
(305, NULL, 1, '2025-08-25', '', '', NULL),
(306, NULL, 1, '2025-08-25', '', '', NULL),
(307, NULL, 1, '2025-08-25', '', '', NULL),
(308, NULL, 1, '2025-08-25', '', '', NULL),
(309, NULL, 1, '2025-08-25', '', '', NULL),
(310, NULL, 1, '2025-08-25', '', '', NULL),
(311, NULL, 1, '2025-08-25', '', '', NULL),
(312, NULL, 1, '2025-08-25', '', '', NULL),
(313, NULL, 1, '2025-08-25', '', '', NULL),
(314, NULL, 1, '2025-08-25', '', '', NULL),
(315, 48, 1, '2025-08-25', '', '', NULL),
(316, NULL, 1, '2025-08-25', '', '', NULL),
(317, NULL, 1, '2025-08-25', '', '', NULL),
(318, NULL, 1, '2025-08-25', '', '', NULL),
(319, NULL, 1, '2025-08-25', '', '', NULL),
(320, NULL, 1, '2025-08-25', '', '', NULL),
(321, NULL, 1, '2025-08-25', '', '', NULL),
(322, NULL, 1, '2025-08-25', '', '', NULL),
(323, NULL, 1, '2025-08-25', '', '', NULL),
(324, NULL, 1, '2025-08-25', '', '', NULL),
(325, NULL, 1, '2025-08-25', '', '', NULL),
(326, NULL, 1, '2025-08-25', '', '', NULL),
(327, NULL, 1, '2025-08-25', '', '', NULL),
(328, NULL, 1, '2025-08-25', '', '', NULL),
(329, NULL, 1, '2025-08-25', '', '', NULL),
(330, NULL, 1, '2025-08-25', '', '', NULL),
(331, NULL, 1, '2025-08-25', '', '', NULL),
(332, NULL, 1, '2025-08-25', '', '', NULL),
(333, NULL, 1, '2025-08-25', '', '', NULL),
(334, NULL, 1, '2025-08-25', '', '', NULL),
(335, NULL, 1, '2025-08-25', '', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `representantes_turma`
--

CREATE TABLE `representantes_turma` (
  `id_representante_turma` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `representantes_turma`
--

INSERT INTO `representantes_turma` (`id_representante_turma`, `id_aluno`, `id_turma`, `id_usuario`, `data_inicio`, `data_fim`, `status`) VALUES
(1, 49, 1, 7, '2024-03-20', '2025-12-31', 'ativo'),
(2, 59, 1, 8, '2023-03-20', '2025-12-31', 'ativo');

--
-- Acionadores `representantes_turma`
--
DELIMITER $$
CREATE TRIGGER `verifica_aluno_turma` BEFORE INSERT ON `representantes_turma` FOR EACH ROW BEGIN
    DECLARE aluno_pertence_turma INT;
    
    SELECT COUNT(*) INTO aluno_pertence_turma
    FROM alunos
    WHERE id_aluno = NEW.id_aluno AND id_turma = NEW.id_turma;
    
    IF aluno_pertence_turma = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'O aluno deve pertencer à turma que está representando';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `id_turma` int(11) NOT NULL,
  `nome_turma` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL,
  `id_coordenador` int(11) DEFAULT NULL,
  `id_pedagogo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`id_turma`, `nome_turma`, `ano`, `id_coordenador`, `id_pedagogo`) VALUES
(1, '3ºJ DESENVOLVIMENTO DE SISTEMAS', 2025, 6, 9),
(2, '2ºJ DESENVOLVIMENTO DE SISTEMAS', 2025, 6, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` enum('adm','representante','pedagogo','coordenador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `nivel_acesso`) VALUES
(1, 'Administrador', 'admin@rlc.com', '$2y$12$jDTYMXofO2EHI7InXyUkL.fJIQPw8bjUnbPNX0aXbIvusc.q4Qg1K', 'adm'),
(2, 'Pedagogo', 'pedagogo@rlc.com', '$2y$12$j.BTxs/Pn.RTp/3X2t31OeL9r41ZtiSkYmjSd77T93rkpww8Ekzty', 'pedagogo'),
(3, 'Representante', 'representante@rlc.com', '$2y$12$yM4QZl7p4p3YcfZJnTy0fuMAzXzUvoVuyXjuQjeXZoPySIILiUM3W', 'representante'),
(6, 'Coordenador', 'coordenador@rlc.com', '$2y$12$7v6wQyX94wV.1JP7mYoBveGLZ7Rj6aj1.l1dj8F3aF2UuAfQqxGcO', 'coordenador'),
(7, 'Bruno otavio frederico trento ', 'trento.bruno@escola.pr.gov.br', '$2y$10$4Gg5/4TL1J6.qCqlLYUcN.GLkMrYp8fAFozvXPNv8oPONoGOxLc7i', 'representante'),
(8, 'Gabriel Henrique Gonçalves Moraes', 'gabriel.goncalves.moraes@escola.pr.gov.br', '$2y$10$SGvmZ9ifeRVAIafMjD9IYunMl5hD48j/rcp1Syh2KF0HnHMynIXMa', 'representante'),
(9, 'Lucilene', 'lucilene@rlc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pedagogo');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id_aluno`),
  ADD KEY `id_turma` (`id_turma`);

--
-- Índices de tabela `coordenadores`
--
ALTER TABLE `coordenadores`
  ADD PRIMARY KEY (`id_coordenador`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fk_coord_curso` (`id_curso`),
  ADD KEY `fk_coord_turma` (`id_turma`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Índices de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `pedagogos`
--
ALTER TABLE `pedagogos`
  ADD PRIMARY KEY (`id_pedagogo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `fk_pedag_curso` (`id_curso`),
  ADD KEY `fk_pedag_turma` (`id_turma`);

--
-- Índices de tabela `registros_presenca`
--
ALTER TABLE `registros_presenca`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_aluno` (`id_aluno`),
  ADD KEY `id_turma` (`id_turma`);

--
-- Índices de tabela `representantes_turma`
--
ALTER TABLE `representantes_turma`
  ADD PRIMARY KEY (`id_representante_turma`),
  ADD UNIQUE KEY `idx_aluno_turma_ativa` (`id_aluno`,`id_turma`,`status`),
  ADD UNIQUE KEY `idx_usuario_turma_ativa` (`id_usuario`,`id_turma`,`status`),
  ADD KEY `id_aluno` (`id_aluno`),
  ADD KEY `id_turma` (`id_turma`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id_turma`),
  ADD KEY `id_coordenador` (`id_coordenador`),
  ADD KEY `fk_turma_pedagogo` (`id_pedagogo`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `coordenadores`
--
ALTER TABLE `coordenadores`
  MODIFY `id_coordenador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de tabela `pedagogos`
--
ALTER TABLE `pedagogos`
  MODIFY `id_pedagogo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `registros_presenca`
--
ALTER TABLE `registros_presenca`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT de tabela `representantes_turma`
--
ALTER TABLE `representantes_turma`
  MODIFY `id_representante_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);

--
-- Restrições para tabelas `coordenadores`
--
ALTER TABLE `coordenadores`
  ADD CONSTRAINT `fk_coord_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `fk_coord_turma` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`),
  ADD CONSTRAINT `fk_coord_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_coordenador_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD CONSTRAINT `logs_acesso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `pedagogos`
--
ALTER TABLE `pedagogos`
  ADD CONSTRAINT `fk_pedag_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `fk_pedag_turma` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`),
  ADD CONSTRAINT `fk_pedag_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_pedagogo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `registros_presenca`
--
ALTER TABLE `registros_presenca`
  ADD CONSTRAINT `registros_presenca_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id_aluno`),
  ADD CONSTRAINT `registros_presenca_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);

--
-- Restrições para tabelas `representantes_turma`
--
ALTER TABLE `representantes_turma`
  ADD CONSTRAINT `fk_representante_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id_aluno`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_representante_turma` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_representante_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `fk_turma_pedagogo` FOREIGN KEY (`id_pedagogo`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  ADD CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`id_coordenador`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
