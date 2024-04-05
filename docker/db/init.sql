CREATE DATABASE IF NOT EXISTS gpmil;
USE gpmil;



-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_lab
-- Tempo de geração: 23/03/2024 às 18:18
-- Versão do servidor: 8.1.0
-- Versão do PHP: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `laravel_lab`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `doa_deposito`
--

CREATE TABLE doa_deposito IF NOT EXISTS (
  `id_deposito` int UNSIGNED NOT NULL,
  `organizacao_id` int UNSIGNED NOT NULL,
  `sigla` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doa_deposito`
--

INSERT INTO `doa_deposito` (`id_deposito`, `organizacao_id`, `sigla`, `descricao`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 1, 'DEP 1', 'Depósito 4', 'SIM', '2023-11-23 00:14:42', '2023-11-23 00:14:42'),
(2, 1, 'DEP 8', 'Depósito 4', 'SIM', '2023-11-23 00:14:42', '2023-11-23 00:14:42'),
(3, 1, 'DEP 3', 'Depósito 1', 'SIM', '2023-11-23 00:14:42', '2023-11-23 00:14:42'),
(4, 1, 'DEP 9', 'Depósito 9', 'SIM', '2023-11-23 00:14:42', '2023-11-23 00:14:42'),
(5, 1, 'DEP 0', 'Depósito 1', 'SIM', '2023-11-23 00:14:42', '2023-11-23 00:14:42'),
(6, 3, 'aaaa', 'dsadasdas', 'SIM', '2024-03-11 21:41:19', '2024-03-11 21:41:19');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `doa_deposito`
--
ALTER TABLE `doa_deposito`
  ADD PRIMARY KEY (`id_deposito`),
  ADD KEY `doa_deposito_organizacao_id_foreign` (`organizacao_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `doa_deposito`
--
ALTER TABLE `doa_deposito`
  MODIFY `id_deposito` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `doa_deposito`
--
ALTER TABLE `doa_deposito`
  ADD CONSTRAINT `doa_deposito_organizacao_id_foreign` FOREIGN KEY (`organizacao_id`) REFERENCES `acl_organizacao` (`id_organizacao`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;