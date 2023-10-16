-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Out-2023 às 22:06
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `pro_id` int(11) NOT NULL,
  `pro_nome` varchar(50) NOT NULL,
  `pro_descricao` varchar(200) NOT NULL,
  `pro_quantidade` int(11) NOT NULL,
  `pro_valor` double(10,2) NOT NULL,
  `pro_imagem` longblob NOT NULL,
  `pro_ativo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`pro_id`, `pro_nome`, `pro_descricao`, `pro_quantidade`, `pro_valor`, `pro_imagem`, `pro_ativo`) VALUES
(1, 'teste', 'teste teste', 1, 1000.00, '', 'n'),
(2, 'teste2', 'fazendo mais um teste', 8, 1111.00, '', 'n'),
(3, 'Bola RGB', 'Bola RGB, é caro pq dá mais fps', 24, 1234.00, '', 'n'),
(4, 'teste3', 'fazendo mais um teste novamente', 2, 1235.54, '', 'n'),
(5, 'aaaaaaaaaaaaa', 'afjasghlahsghag', 1, 1234.00, '', 'n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL,
  `usu_nome` varchar(50) NOT NULL,
  `usu_senha` varchar(50) NOT NULL,
  `usu_ativo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_nome`, `usu_senha`, `usu_ativo`) VALUES
(1, 'murilo', '123', 'n'),
(2, 'murilo', '123', 'n'),
(3, 'murilo', '123', 'n');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`pro_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
