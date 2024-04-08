-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Tempo de geração: 07/04/2024 às 19:01
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
-- Banco de dados: `gpmil`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `circulos`
--

CREATE TABLE `circulos` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `circulos`
--

INSERT INTO `circulos` (`id`, `descricao`, `sigla`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Oficial General', 'Of Gen', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, 'Oficial Superior', 'Of Sup', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, 'Oficial Intermediário', 'Of Intr', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(4, 'Oficial Subalterno', 'Of Subt', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(6, 'Subtenente e Sargento', 'ST/Sgt', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(7, 'Cabo e Soldado', 'Cb/Sd', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(8, 'Servidor Civil', 'SC', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcoes`
--

CREATE TABLE `funcoes` (
  `id` int UNSIGNED NOT NULL,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `menu_id` int UNSIGNED DEFAULT NULL,
  `descricao` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ordem` tinyint DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `menus`
--

INSERT INTO `menus` (`id`, `menu_id`, `descricao`, `ordem`, `ativo`) VALUES
(1, NULL, 'Gestão de Pessoal', NULL, 'SIM'),
(2, 1, 'Plano de Chamada', NULL, 'SIM'),
(3, 1, 'Livro de Apresentações', NULL, 'SIM'),
(4, 1, 'Mapa da Força', NULL, 'SIM'),
(5, 1, 'Plano de Férias', NULL, 'SIM'),
(6, 1, 'Pessoal', NULL, 'SIM'),
(7, NULL, 'Administração', NULL, 'SIM'),
(8, 2, 'Painel de Controle', NULL, 'SIM'),
(9, 2, 'Cadastros', NULL, 'SIM'),
(10, 3, 'Qualificações', NULL, 'SIM'),
(11, 3, 'Círculos', NULL, 'SIM'),
(12, 3, 'Asse/Div/Seções/Cias/Pels', NULL, 'SIM'),
(13, 3, 'P/Graduações', NULL, 'SIM'),
(14, 3, 'Funções', NULL, 'SIM'),
(17, 3, 'Municípios', NULL, 'SIM');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel_acessos`
--

CREATE TABLE `nivel_acessos` (
  `id` int UNSIGNED NOT NULL,
  `nome` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `nivel_acessos`
--

INSERT INTO `nivel_acessos` (`id`, `nome`, `sigla`, `descricao`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'Admin', 'Tem acesso irrestrito a todos sistema.', 'SIM', NULL, NULL),
(2, 'Supervisor', 'Supv', 'Tem acesso de Supervisão Geral. Adequado ao Comandante/Chefe/Diretor/Encarregado de Pessoal.\r\nPode apenas visualizar os dados de todo efetivo da Organização.', 'SIM', NULL, NULL),
(3, 'Coordenador', 'Coord', 'Tem acesso de Supervisão. Adequado ao Comandante/Chefe de Divisão/Companhia/Seção.\r\nPode apenas visualizar os dados de todo efetivo de sua Div/Cia/Seç.', 'SIM', NULL, NULL),
(4, 'Gerente', 'Ger', 'Tem acesso de Gerência. Adequado ao Sargenteante da Divisão/Companhia/Seção.\r\nPode visualizar e manter os dados de todo efetivo de sua Div/Cia/Seç.\r\n', 'SIM', NULL, NULL),
(5, 'Usuário', 'User', 'Tem acesso de Usuário. Adequado ao Usuário da Divisão/Companhia/Seção. Visualiza e mantém apenas seus próprios dados.', 'SIM', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `organizacao`
--

CREATE TABLE `organizacao` (
  `id` int UNSIGNED NOT NULL,
  `codom` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sigla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `organizacao`
--

INSERT INTO `organizacao` (`id`, `codom`, `sigla`, `nome`, `ativo`, `created_at`, `updated_at`) VALUES
(1, '000000', 'SIGla', 'Nome completo da Organização Militar', 'SIM', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `id` int UNSIGNED NOT NULL,
  `pgrad_id` int UNSIGNED NOT NULL,
  `qualificacao_id` int UNSIGNED NOT NULL,
  `organizacao_id` int UNSIGNED NOT NULL DEFAULT '1',
  `secao_id` int UNSIGNED DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `status` enum('Ativa','Reserva','Civil') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Ativa',
  `pronto_sv` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `nome_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nome_guerra` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cpf` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `preccp` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `endereco` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `municipio_id` int UNSIGNED DEFAULT NULL,
  `uf` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cep` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone_ramal` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone_celular` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fone_emergencia` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `foto` blob,
  `segmento` enum('Masculino','Feminino') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Masculino',
  `lem` enum('Bélica','Técnica','Civil') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Bélica',
  `funcao` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `funcao_id` int UNSIGNED DEFAULT NULL,
  `nivelacesso_id` int UNSIGNED NOT NULL DEFAULT '4',
  `dt_praca` date DEFAULT NULL,
  `dt_apres_gu` date DEFAULT NULL,
  `dt_apres_om` date DEFAULT NULL,
  `dt_ult_promocao` date DEFAULT NULL,
  `antiguidade` smallint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pgrads`
--

CREATE TABLE `pgrads` (
  `id` int UNSIGNED NOT NULL,
  `circulo_id` int UNSIGNED DEFAULT NULL,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pgrads`
--

INSERT INTO `pgrads` (`id`, `circulo_id`, `descricao`, `sigla`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marechal', 'Mar', 'SIM', '2024-01-01 00:00:00', '2024-04-05 21:08:11'),
(2, 1, 'General-de-Exército', 'Gen Ex', 'SIM', '2024-01-01 00:00:00', '2024-04-05 21:08:17'),
(3, 1, 'General-de-Divisão', 'Gen Div', 'SIM', '2024-01-01 00:00:00', '2024-04-05 21:08:25'),
(4, 1, 'General-de-Brigada', 'Gen Bda', 'SIM', '2024-01-01 00:00:00', '2024-04-05 21:08:30'),
(11, 2, 'Coronel', 'Cel', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(12, 2, 'Tenente-Coronel', 'Ten Cel', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(13, 2, 'Major', 'Maj', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(15, 4, 'Capitão', 'Cap', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:03'),
(16, 4, 'Primeiro-Tenente', '1º Ten', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:14'),
(17, 4, 'Segundo-Tenente', '2º Ten', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:20'),
(18, 3, 'Aspirante-a-Oficial', 'Asp', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:34'),
(21, 6, 'Subtenente', 'S Ten', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:44'),
(22, 6, 'Primeiro-Sargento', '1º Sgt', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:02:49'),
(23, 6, 'Segundo-Sargento', '2º Sgt', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:04:21'),
(24, 6, 'Terceiro-Sargento', '3º Sgt', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:04:03'),
(42, 7, 'Cabo', 'Cb', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:05:04'),
(44, 7, 'Soldado', 'Sd', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:05:12'),
(49, 7, 'Soldado-Recruta', 'Sd Rcr', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:05:18'),
(51, 7, 'Taifeiro-Mor', 'T M', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:05:26'),
(52, 7, 'Taifeiro de Primeira Classe', 'T1', 'SIM', '2024-01-01 00:00:00', '2024-04-05 23:05:32'),
(53, 2, 'Taifeiro de Segunda Classe', 'T2', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(54, 2, 'Cadete de 1º ano', 'Cad 1º A', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(55, 2, 'Cadete de 2º ano', 'Cad 2º A', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(56, 2, 'Cadete de 3º ano', 'Cad 3º A', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(57, 2, 'Cadete de 4º ano', 'Cad 4º A', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(58, 2, 'Aluno CPOR/NPOR', 'Al', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(59, 3, 'Aluno IME 1º Ano', 'Al IME 1º', 'SIM', '2024-01-01 00:00:00', '2024-04-07 14:53:55'),
(60, 2, 'Aluno EsPCEx', 'Al EPC', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(61, 2, 'Aluno IME 2º Ano', 'Al IME 2º', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(62, 2, 'Aluno IME 3º Ano', 'Al IME 3º', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(63, 2, 'Aluno IME 4º Ano', 'Al IME 4º', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(64, 2, 'Aluno Esc Formação de Sargento', 'AlEsSgt', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(65, 2, 'Al Órgão Form Praças Reserva', 'AlFPrRe', 'SIM', '2024-01-01 00:00:00', '2024-03-29 19:40:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `qualificacoes`
--

CREATE TABLE `qualificacoes` (
  `id` int UNSIGNED NOT NULL,
  `codigo` char(4) DEFAULT NULL,
  `descricao` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `qualificacoes`
--

INSERT INTO `qualificacoes` (`id`, `codigo`, `descricao`, `sigla`, `ativo`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Manutenção de Comunicações', 'Mnt Com', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, NULL, 'Cavalaria', 'Cav', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, NULL, 'Quadro de Engenheiros Militares', 'QEM', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(4, NULL, 'Quadro Complementar de Oficiais', 'QCO', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(5, NULL, 'Engenharia', 'Eng', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(6, NULL, 'Artilharia', 'Art', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(7, NULL, 'Infantaria', 'Inf', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(8, NULL, 'Saúde', 'Sau', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(9, NULL, 'Material Bélico', 'Mat Bel', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(10, NULL, 'Intendência', 'Int', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(11, NULL, 'Comunicações', 'Com', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(12, NULL, 'Músico', 'Mus', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(13, NULL, 'Corneteiro / Clarim', 'Corn/Clar', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(14, NULL, 'Quadro Auxiliar de Oficiais', 'QAO', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(15, NULL, 'Topógrafo', 'Topo', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(16, NULL, 'Quadro Especial', 'QE', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(17, NULL, 'Singular', 'Sing', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(18, NULL, 'Quadro de Capelães Militares', 'QCM', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(19, NULL, 'Veterinária', 'Vet', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(21, NULL, 'Suprimento de Engenharia', 'Sup Eng', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(22, NULL, 'Suprimento de Material Bélico', 'Sup Mat Bel', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(23, NULL, 'Suprimento de Intendência', 'Sup Int', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(24, NULL, 'Suprimento de Comunicações', 'Sup Com', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(25, NULL, 'Auxiliar de Administração', 'Aux Adm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(26, NULL, 'Magistério', 'Mag', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(28, NULL, 'Atirador de Tiro de Guerra', 'At TG', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(31, NULL, 'Não Qualificado', 'NQ R2C', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(32, NULL, 'Combatente', 'Cmb ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(33, NULL, 'Engenheiro Militar', 'Eng Mil', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(36, NULL, 'Aviação / Manutenção', 'Av/Mnt', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(39, NULL, 'Aviação / Apoio', 'Av/Ap', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(40, NULL, 'Médico', 'Med', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(41, NULL, 'Dentista', 'Dent', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(42, NULL, 'Farmaceutico', 'Farm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(43, NULL, 'Auxiliar de Enfermagem', 'Aux Enf', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(44, NULL, 'Apoio', 'Ap', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(45, NULL, 'Material Bélico - Manutenção de Armamento', 'MB/Mnt Armt', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(46, NULL, 'Material Bélico - Manutenção de Viatura Auto', 'MB/Mnt VtrA', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(47, NULL, 'Material Bélico - Mecânico Operador', 'MB/Mec Op', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(48, NULL, 'Técnico', 'Tec', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(49, NULL, 'Quadro Complementar de Oficiais de Enfermagem', 'QCO Enf', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(50, NULL, 'Quadro Complementar de Oficiais de Veterinária', 'QCO Vet', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(51, NULL, 'Quadro de estado-maior da ativa', 'QEMA', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(52, NULL, 'Armas/QMB/Sv Int', 'A/QMB/S Int', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(53, NULL, 'Qualquer QMS', 'Qualquer QMS', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(54, NULL, 'QAO de Qualquer Categoria', 'QAO ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(60, NULL, 'Aprov no CA', 'Aprov no CA', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(61, NULL, 'Quadro Auxiliar de Oficiais - Administração Geral', 'QAO-Adm G', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(62, NULL, 'Quadro Auxiliar de Oficiais - Saúde', 'QAO-Sau', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(63, NULL, 'Quadro Auxiliar de Oficiais - Material Bélico', 'QAO-Mat Bel', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(64, NULL, 'Quadro Auxiliar de Oficiais - Topógrafo', 'QAO-Topo', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(65, NULL, 'Quadro Auxiliar de Oficiais - Músico', 'QAO-Mus', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(70, NULL, 'Qualquer QMS Exceto Singular', 'QMS Ex Sing', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(71, NULL, 'Qualquer Arma, Quadro ou Serviço', 'Qq A/Qd/Sv', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(72, NULL, 'Aviação', 'Av', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(73, NULL, 'Quadro Auxiliar de Oficiais - Manutenção de Com', 'QAO-Mnt Com', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(77, NULL, 'Estágio Básico de Cabo Temporário', 'EBCT', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(78, NULL, 'Quadro de Oficiais Temporários', 'Of Tmpr', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(79, NULL, 'Serviço Técnico Temporário', 'SvTT', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(80, NULL, 'Piloto', 'Piloto', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(86, NULL, 'Serviço de Assistência Religiosa do Exército', 'SAREx', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(90, NULL, 'Quadro Complementar de Oficiais de Psicologia', 'QCO Psico', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(91, NULL, 'Quadro Complementar de Oficiais de Pedagogia', 'QCO Ped', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(92, NULL, 'Quadro Complementar de Oficiais de Magistério', 'QCO Mag', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(93, NULL, 'Quadro Complementar de Oficiais de Comunicação Social', 'QCO Com S', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(94, NULL, 'General Intendente', 'Int ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(95, NULL, 'General Veterinário', 'Vet ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(96, NULL, 'General Combatente', 'Cmb', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(97, NULL, 'General Engenheiro Militar', 'Eng Mil ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(98, NULL, 'General Médico', 'Med ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(99, NULL, 'General do Quadro Especial (STM)', 'QE ', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(100, NULL, 'Oficial Técnico Temporário', 'OTT', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(101, NULL, 'Oficial Técnico Temporário - Administração', 'OTT Adm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(102, NULL, 'Oficial Técnico Temporário - Direito', 'OTT Dir', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(103, NULL, 'Oficial Técnico Temporário - Informática', 'OTT Infor', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(104, NULL, 'Oficial Técnico Temporário - Contabilidade', 'OTT Cont', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(108, NULL, 'Estágio de Adaptação ao Serviço', 'EAS', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(109, NULL, 'Estágio de Instrução e Serviço', 'EIS', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(110, NULL, 'Estágio de Adaptação ao Serviço - Médico', 'EAS Med', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(111, NULL, 'Estágio de Instrução e Serviço - Médico', 'EIS Med', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(112, NULL, 'Estágio de Adaptação ao Serviço - Dentista', 'EAS Dent', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(113, NULL, 'Estágio de Instrução e Serviço - Dentista', 'EIS Dent', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(114, NULL, 'Estágio de Adaptação ao Serviço - Farmaceútico', 'EAS Farm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(115, NULL, 'Estágio de Instrução e Serviço - Farmaceútico', 'EIS Farm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(116, NULL, 'Estágio de Adaptação ao Serviço - Veterinário', 'EAS Vet', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(117, NULL, 'Estágio de Instrução e Serviço - Veterinário', 'EIS Vet', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(118, NULL, 'Estágio de Serviço Técnico', 'EST', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(119, NULL, 'Estágio de Serviço Técnico - Magistério', 'EST Mag', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(120, NULL, 'Sargento Técnico Temporário', 'STT', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(121, NULL, 'Sargento Técnico Temporário - Administração', 'STT Adm', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(122, NULL, 'Sargento Técnico Temporário - Saúde', 'STT Sau', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(123, NULL, 'Sargento Técnico Temporário - Informática', 'STT Infor', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(124, NULL, 'Sargento Técnico Temporário - Contabilidade', 'STT Cont', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(125, NULL, 'Cabo Especialista Temporário', 'CET', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(126, NULL, 'Cabo Especialista Temporário - Motorista', 'CET Mot', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(127, NULL, 'Cabo Especialista Temporário - Mecânico', 'CET Mec', 'SIM', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `secoes`
--

CREATE TABLE `secoes` (
  `id` int UNSIGNED NOT NULL,
  `secao_id` int UNSIGNED DEFAULT NULL,
  `organizacao_id` int UNSIGNED NOT NULL DEFAULT '1',
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sigla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ativo` enum('SIM','NÃO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'SIM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `secoes`
--

INSERT INTO `secoes` (`id`, `secao_id`, `organizacao_id`, `descricao`, `sigla`, `ativo`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Gabinete do Comandante/Chefe/Diretor', 'Gab Cmt/Ch/Dir', 'SIM', NULL, NULL),
(2, 1, 1, 'Gabinete do Subcomandante/Subchefe/Subdiretor', 'Gab SCmt/SCh/SDir', 'SIM', NULL, NULL),
(3, 1, 1, 'Assessoria 1', 'Asse1', 'SIM', NULL, NULL),
(4, 1, 1, 'Assessoria 2', 'Asse2', 'SIM', NULL, NULL),
(5, 1, 1, 'Assessoria 3', 'Asse3', 'SIM', NULL, NULL),
(6, 1, 1, 'Assessoria 4', 'Asse4', 'SIM', NULL, NULL),
(7, 1, 1, 'Divisão 1', 'Div 1', 'SIM', NULL, NULL),
(8, 1, 1, 'Divisão 2', 'Div 2', 'SIM', NULL, NULL),
(9, 1, 1, 'Seção 1', 'Seç 1', 'SIM', NULL, NULL),
(10, 1, 1, 'Seção 2', 'Seç 2', 'SIM', NULL, NULL),
(11, 1, 1, 'Seção 3', 'Seç 3', 'SIM', NULL, NULL),
(12, 1, 1, 'Seção 4', 'Seç 4', 'SIM', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Emerson Vite Euzébio', 'emfeuzebio@hotmail.com', NULL, '$2y$12$ramex3HPgr45jvtgdo2oJO1eWV34.UH5sevzPgL9mY7B0/89CvQcS', NULL, '2024-03-28 22:39:55', '2024-03-28 22:39:55'),
(2, 'Liana Bode', 'hertha.halvorson@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LrKVDWswVe', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(3, 'Mrs. Zora Howe', 'rozella.gleason@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LiZuJBgr0c', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(4, 'Veronica Littel Sr.', 'konopelski.lucinda@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'wzutY181XF', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(5, 'Vaughn Collier', 'fskiles@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'K4u57O9Zy5', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(6, 'Prof. Drake Rippin', 'kaia92@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'oBAgzkMnDJ', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(7, 'Kobe Steuber', 'walter.emilio@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'RBi1IJTE8M', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(8, 'Mrs. Aaliyah Brown', 'bjones@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Hii7ZYMap8', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(9, 'Art Gutkowski', 'breanna14@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '565SpvcEZs', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(10, 'Alfredo Nitzsche', 'deshawn74@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Tn5pJczYGv', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(11, 'Arlie Kshlerin Jr.', 'rogahn.domingo@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'O1cqiXPkom', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(12, 'Zora Block', 'aracely08@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'XTCBIgNZ2T', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(13, 'Ms. Idella Huels', 'wehner.jerod@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Rw0MS6lYte', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(14, 'Suzanne Gulgowski II', 'tillman.roma@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'QDgwcPnxif', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(15, 'Dr. Koby Casper', 'laltenwerth@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'gXeQZaxdT1', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(16, 'Candace Wuckert', 'herzog.luciano@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'WeBYxAoYzR', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(17, 'Kieran Huels', 'brooklyn70@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'oNuiOYryvw', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(18, 'Xavier Padberg III', 'lisette11@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'eKb93RTu7Z', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(19, 'Margarita Jacobi', 'peyton.donnelly@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'uOFCMTKzSM', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(20, 'Hilario Purdy', 'araceli.smitham@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Sl5OPY7HJr', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(21, 'Lina Towne', 'rvandervort@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'dKlf5WT5Qk', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(22, 'Meredith Sporer', 'gnitzsche@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '644bDayTIH', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(23, 'Prof. Juliet Frami', 'darrel28@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Ot0uJCm7fJ', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(24, 'Tiara McLaughlin', 'simone.green@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'jTNiQ4BiT5', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(25, 'Mr. Elijah Ebert', 'jweimann@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'n56jFkl64a', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(26, 'Prof. Gussie Padberg', 'layne.toy@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '56SHDXB7JT', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(27, 'Mr. Wilton O\'Keefe I', 'mclaughlin.van@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'up037LJ2Ou', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(28, 'Aubree Stroman IV', 'felix13@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'NXAHRkIJGr', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(29, 'Randall Veum', 'langosh.aurore@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'sgVJnyEx4I', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(30, 'Caleb Rath', 'angie.trantow@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'rf8Z4qPa7y', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(31, 'Prof. Alanis Schoen', 'wunsch.velda@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'nS3K2wVD3g', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(32, 'Aubree Cormier', 'rupert15@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '4rNCnij1vj', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(33, 'Angelica Braun', 'wiza.lola@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'AR9cX3U3kf', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(34, 'Reinhold Walsh', 'nienow.carissa@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'n5eViKRVFy', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(35, 'Mr. Nestor Ziemann', 'lang.vern@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Fs3Jq8Tbyb', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(36, 'Krystal Zulauf', 'hunter.mertz@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'oLAhosqQBa', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(37, 'Gabe Ruecker', 'kaia96@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'i4boTf7xec', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(38, 'Mrs. Katharina Bogan', 'claudia97@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'ulVS1XCwU9', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(39, 'Jaqueline Jones I', 'jasen.emard@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'AsBG7mGm4A', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(40, 'Magnus Abshire', 'michael.auer@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'wSnCITjzoD', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(41, 'Liliane Fritsch Sr.', 'ruecker.uriah@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'GoeisxvlD5', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(42, 'Alan Dickinson IV', 'alvera44@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'iNqRBBKUgu', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(43, 'Mr. Ian Dietrich II', 'gaston81@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '4i72mVWIF7', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(44, 'Ward O\'Reilly', 'jgrimes@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'Fau9zbwIje', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(45, 'Maya Schiller', 'dana.spinka@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'rxmbJgJ7Am', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(46, 'Linnea Streich', 'qokon@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'gZJFXHyWVG', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(47, 'Derick Emmerich PhD', 'eichmann.renee@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '1DqrZKwNqC', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(48, 'Dr. Garfield Stehr', 'mcglynn.junius@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'XRmC8gPRZ8', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(49, 'Burnice Schmeler', 'wisoky.timmothy@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'twWPb5TA1N', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(50, 'Jalyn Blick V', 'quinn95@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'YPp97duNfe', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(51, 'Nannie Reichel', 'tevin94@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'bgsl6qqZnv', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(52, 'Trudie Graham', 'bertrand.hudson@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'cnfAzTQkNQ', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(53, 'Dr. Coty Friesen', 'johnston.verda@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'j7ii0u6AAW', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(54, 'Thurman Thiel', 'kallie.fay@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'kWdiMyZogd', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(55, 'Coby Hoppe', 'samir.rosenbaum@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '0rouGbS5Sp', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(56, 'Ms. Leanne Zulauf', 'dschumm@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'FMqW34n3q8', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(57, 'Guiseppe Spinka', 'bauch.jo@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'wVGYQZW6CG', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(58, 'Evelyn Wilderman I', 'pgislason@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'u8AtkXzLE2', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(59, 'Prof. Emelie Watsica', 'rodriguez.katelyn@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'NvzqjcsYLE', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(60, 'Ms. Minerva Dach DDS', 'gerhold.shanie@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'J0SBFbD8r0', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(61, 'Mr. Vern Thompson', 'bzieme@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'RhnUdi3MEA', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(62, 'Miss Anne Roob', 'mariane83@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'hLMgS0C7uy', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(63, 'Parker Dooley IV', 'carmel71@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '2W4ayxrAip', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(64, 'Eryn Goldner', 'pgutkowski@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'ap77hA8Mxb', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(65, 'Mr. Anthony Schaden', 'skyla92@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'wXuoVBbNpL', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(66, 'Dr. Shane Kassulke', 'ondricka.enoch@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'fFuNLyBGQ0', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(67, 'Shanny Labadie V', 'atremblay@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'JgUWvbEu7s', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(68, 'Jackeline Dooley DDS', 'tia38@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'GIqH5YudgS', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(69, 'Ashly Kautzer', 'jerde.elenor@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'pBvKtlIOj8', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(70, 'Mr. Cary Schuster IV', 'jessika.goodwin@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'B0kFWxyqxz', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(71, 'Jalen Raynor', 'aurelie.fisher@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LYY8QTWsEz', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(72, 'Orrin Abshire', 'ekiehn@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '9emQjAodmq', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(73, 'Raul Schultz', 'nprice@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'dS5yIvC3ao', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(74, 'Dr. Gerard Terry II', 'rolando.lebsack@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'nw229Pqs8N', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(75, 'Reyna Murray', 'percy.hermann@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'sUoPj6JWth', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(76, 'Dr. Macey Wehner', 'christop.moen@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'hOyvbakArT', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(77, 'Maggie Luettgen', 'srosenbaum@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'jKerU7kAiN', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(78, 'Mia Boehm', 'frieda47@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'KzvgB7nGB7', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(79, 'Cortney McGlynn', 'mratke@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'MxOrv5PSRS', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(80, 'Prof. Dana Daugherty', 'ondricka.genesis@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'hhtqKDixZ5', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(81, 'Mr. Brooks Hirthe V', 'mcollier@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'FEaO6eWrTI', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(82, 'Prof. Fannie Hyatt', 'joshuah.schuppe@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'mMWMvk8eTG', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(83, 'Prof. Ruth Kris IV', 'leannon.tomasa@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'L4r0ZKGFXB', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(84, 'Dr. Devyn Waters V', 'gschneider@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'kpCkXADfQG', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(85, 'Aleen Welch', 'gprice@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LL9Xfgl0Gb', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(86, 'Gerald Dietrich', 'joana70@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'xHyX9IP6eo', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(87, 'Marjory Bode', 'casper.reed@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'eTYfSgHBHQ', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(88, 'Ms. Lois Breitenberg V', 'adrien32@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'qphQKguldF', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(89, 'Miracle Rohan', 'rice.emerald@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '9YY8R891sg', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(90, 'Mable Lind', 'emma.hodkiewicz@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'FwFJ949CDI', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(91, 'Kiarra Rosenbaum V', 'cletus82@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'gxGnJlTkOM', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(92, 'Mr. Tyson Kessler III', 'misael.hyatt@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'OVEaLsZPqa', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(93, 'Prof. Ari Lueilwitz MD', 'adam.gerhold@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'qy1n0XAgEQ', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(94, 'Adelbert Wisozk', 'bernhard63@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', '5WHCtga1Dt', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(95, 'Cary Leannon', 'ustamm@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'rfLwA0inF4', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(96, 'Claudia Kohler', 'hermann35@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'xtgiqDLrW0', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(97, 'Rae Spencer DDS', 'bartoletti.avery@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'GVcmN2sRcL', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(98, 'Jake Okuneva', 'nboehm@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'ozoVado13r', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(99, 'Marjolaine Howell', 'alysa96@example.net', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LlHR8b1xpr', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(100, 'Jermey Wisoky', 'chanelle17@example.com', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'SPUwE6ERTR', '2024-03-28 23:13:44', '2024-03-28 23:13:44'),
(101, 'Prof. Godfrey Kassulke V', 'imelda.bradtke@example.org', '2024-03-28 23:13:44', '$2y$12$GtOscH9yH7kIIW6S.ZTiSuAECOXeFyUYiqdGehrf8nFMSW9d4lCKm', 'LIho7RlCQ7', '2024-03-28 23:13:44', '2024-03-28 23:13:44');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `circulos`
--
ALTER TABLE `circulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `circulos_descricao_ukey` (`descricao`),
  ADD UNIQUE KEY `circulos_sigla_ukey` (`sigla`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `funcoes`
--
ALTER TABLE `funcoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `funcoes_descricao_ukey` (`descricao`),
  ADD UNIQUE KEY `funcoes_sigla_ukey` (`sigla`);

--
-- Índices de tabela `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_descricao_ukey` (`descricao`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `nivel_acessos`
--
ALTER TABLE `nivel_acessos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivelacessos_nome_ukey` (`nome`) USING BTREE,
  ADD UNIQUE KEY `nivelacessos_sigla_ukey` (`sigla`);

--
-- Índices de tabela `organizacao`
--
ALTER TABLE `organizacao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organizacao_sigla_ukey` (`sigla`),
  ADD UNIQUE KEY `organizacao_nome_ukey` (`nome`),
  ADD UNIQUE KEY `organizacao_codom_ukey` (`codom`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pessoa_nome_completo_ukey` (`nome_completo`),
  ADD UNIQUE KEY `pessoa_cpf_ukey` (`cpf`),
  ADD KEY `pessoa_pgrad_id_key` (`pgrad_id`),
  ADD KEY `pessoa_qualificacao_id_key` (`qualificacao_id`),
  ADD KEY `pessoa_organizacao_id_key` (`organizacao_id`),
  ADD KEY `pessoa_secao_id_key` (`secao_id`),
  ADD KEY `pessoa_funcao_id_key` (`funcao_id`),
  ADD KEY `pessoa_municipio_id_key` (`municipio_id`),
  ADD KEY `pessoa_nivelacesso_id_key` (`nivelacesso_id`);

--
-- Índices de tabela `pgrads`
--
ALTER TABLE `pgrads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pgrads_descricao_ukey` (`descricao`),
  ADD UNIQUE KEY `pgrads_sigla_ukey` (`sigla`),
  ADD KEY `pgrads_circulo_id_ukey` (`circulo_id`);

--
-- Índices de tabela `qualificacoes`
--
ALTER TABLE `qualificacoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qualificacoes_descricao_ukey` (`descricao`),
  ADD UNIQUE KEY `qualificacoes_sigla_ukey` (`sigla`),
  ADD UNIQUE KEY `qualificacoes_codigo_ukey` (`codigo`);

--
-- Índices de tabela `secoes`
--
ALTER TABLE `secoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `secao_descricao_ukey` (`descricao`),
  ADD UNIQUE KEY `secao_sigla_ukey` (`sigla`),
  ADD KEY `secao_organizacao_id_key` (`organizacao_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `circulos`
--
ALTER TABLE `circulos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcoes`
--
ALTER TABLE `funcoes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `nivel_acessos`
--
ALTER TABLE `nivel_acessos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `organizacao`
--
ALTER TABLE `organizacao`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
