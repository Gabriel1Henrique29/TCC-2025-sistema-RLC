-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/06/2025 às 01:58
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
(70, 'Vinícius Rafael Ribeiro de Morais', 1, 23, 'matricula');

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
(53, 7, '2025-06-03 20:58:11', 'Login realizado');

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
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '3ºJ DESENVOLVIMENTO DE SISTEMAS', 2025, 6, 2);

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
(7, 'Bruno otavio frederico trento ', 'trento.bruno@escola.pr.gov.br', '$2y$10$4Gg5/4TL1J6.qCqlLYUcN.GLkMrYp8fAFozvXPNv8oPONoGOxLc7i', 'representante');

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
-- Índices de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `registros_presenca`
--
ALTER TABLE `registros_presenca`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_aluno` (`id_aluno`),
  ADD KEY `id_turma` (`id_turma`);

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
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `registros_presenca`
--
ALTER TABLE `registros_presenca`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id_turma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_1` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);

--
-- Restrições para tabelas `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD CONSTRAINT `logs_acesso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Restrições para tabelas `registros_presenca`
--
ALTER TABLE `registros_presenca`
  ADD CONSTRAINT `registros_presenca_ibfk_1` FOREIGN KEY (`id_aluno`) REFERENCES `alunos` (`id_aluno`),
  ADD CONSTRAINT `registros_presenca_ibfk_2` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id_turma`);

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
