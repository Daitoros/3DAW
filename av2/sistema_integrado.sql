-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2025 às 08:27
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
-- Banco de dados: `sistema_integrado`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `telefone_cliente` varchar(20) NOT NULL,
  `servico_desejado` varchar(255) NOT NULL,
  `nome_profissional` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `data_hora_agendamento` datetime NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `nome_cliente`, `telefone_cliente`, `servico_desejado`, `nome_profissional`, `valor`, `forma_pagamento`, `data_hora_agendamento`, `id_cliente`, `data_criacao`) VALUES
(1, 'tsdef', 'dfds', 'Hidratação Capilar', 'Ana Silva', 120.00, 'Cartão', '2026-01-01 00:00:00', NULL, '2025-11-13 21:58:50'),
(2, 'Davi Aires Bastos Medeiros', '21965386105', 'dfd', '', 0.00, '', '2026-09-12 00:01:00', 2, '2025-11-13 22:23:10'),
(3, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva (Especialista em Cortes)', 80.00, 'Pix', '2025-11-11 23:37:00', 2, '2025-11-13 22:37:50'),
(4, 'dssfd', 'dfsdd', 'Corte Feminino', 'Carlos Souza', 80.00, 'Dinheiro', '0001-01-01 00:00:00', NULL, '2025-11-13 23:03:44'),
(5, 'dssfd', 'dfsdd', 'Corte Feminino', 'Carlos Souza', 80.00, 'Dinheiro', '2025-11-28 20:04:00', NULL, '2025-11-13 23:04:22'),
(6, 'dssfd', 'dfsdd', 'Manicure', 'Ana Silva', 40.00, 'Dinheiro', '2025-11-27 20:09:00', NULL, '2025-11-13 23:09:49'),
(7, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva', 80.00, 'Dinheiro', '2025-11-29 20:27:00', 2, '2025-11-13 23:27:15'),
(8, 'Davi Aires Bastos Medeiros', '21965386105', 'Manicure', 'Ana Silva', 40.00, 'Dinheiro', '2025-11-26 20:30:00', 2, '2025-11-13 23:30:47'),
(10, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Masculino', 'Ana Silva', 50.00, 'Dinheiro', '2025-11-21 20:49:00', 2, '2025-11-13 23:49:46'),
(11, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva', 80.00, 'Dinheiro', '2025-11-12 20:59:00', 2, '2025-11-14 00:00:02'),
(12, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva (Especialista em Cortes)', 80.00, 'Cartão de Crédito', '2025-11-29 22:10:00', 2, '2025-11-14 01:10:51'),
(13, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva (Especialista em Cortes)', 80.00, 'Cartão de Crédito', '2025-11-29 22:10:00', 2, '2025-11-14 01:10:53'),
(14, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva (Especialista em Cortes)', 80.00, 'Cartão de Crédito', '2025-11-29 22:10:00', 2, '2025-11-14 01:10:53'),
(15, 'Davi Aires Bastos Medeiros', '21965386105', 'dfd', 'opuo', 0.00, 'Balcão', '2025-11-12 22:58:00', 2, '2025-11-14 01:58:52'),
(16, 'Davi Aires Bastos Medeiros', '21965386105', 'dfd', 'opuo', 0.00, 'Balcão', '2025-11-28 04:02:00', 2, '2025-11-17 07:02:35'),
(17, 'Davi Aires Bastos Medeiros', '21965386105', 'Corte Feminino', 'Ana Silva', 80.00, 'Cartão', '2025-10-31 04:09:00', 2, '2025-11-17 07:09:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `matricula` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `senha`, `data_criacao`) VALUES
(1, 'Davi Aires Bastos Medeiros', 'daviabmedeiros@gmail.com', '21965386105', '$2y$10$vGruQPEkdCvdakVCTLF58eRKwk1GQrgGO2ON3naCGnfE/VQ9MvxZC', '2025-11-13 22:22:07'),
(2, 'Davi Aires Bastos Medeiros', 'davixd9841@gmail.com', '21965386105', '$2y$10$vGruQPEkdCvdakVCTLF58eRKwk1GQrgGO2ON3naCGnfE/VQ9MvxZC', '2025-11-13 22:22:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `perguntas`
--

CREATE TABLE `perguntas` (
  `id` int(11) NOT NULL,
  `pergunta` text NOT NULL,
  `resp1` varchar(255) DEFAULT NULL,
  `resp2` varchar(255) DEFAULT NULL,
  `resp3` varchar(255) DEFAULT NULL,
  `respCerta` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `funcao` enum('gestor','atendente','profissional') NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`, `funcao`, `data_criacao`) VALUES
(1, 'admin', '$2y$10$L5sIH26uJeMTyj9rwTxpuuLN2.fg8zOETBFTjmO/S/9reGBGIEh9y', 'gestor', '2025-11-13 21:52:16'),
(5, 'recepcao', '$2y$10$vGruQPEkdCvdakVCTLF58eRKwk1GQrgGO2ON3naCGnfE/VQ9MvxZC', 'atendente', '2025-11-13 22:43:53'),
(6, 'Ana Silva', '$2y$10$vGruQPEkdCvdakVCTLF58eRKwk1GQrgGO2ON3naCGnfE/VQ9MvxZC', 'profissional', '2025-11-13 22:43:53'),
(7, 'Carlos Souza', '$2y$10$vGruQPEkdCvdakVCTLF58eRKwk1GQrgGO2ON3naCGnfE/VQ9MvxZC', 'profissional', '2025-11-13 22:43:53'),
(9, 'Izumi', '$2y$10$l96NvolRp1KIbo.kMOHzBuLcpUfTjwYstYgzPfaA6LXou333yXjQq', 'profissional', '2025-11-14 00:55:29');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_agendamento` (`id_cliente`);

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `perguntas`
--
ALTER TABLE `perguntas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `perguntas`
--
ALTER TABLE `perguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_cliente_agendamento` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
