-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.17-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para exercicio
CREATE DATABASE IF NOT EXISTS `exercicio` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `exercicio`;

-- Copiando estrutura para tabela exercicio.cidade
CREATE TABLE IF NOT EXISTS `cidade` (
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  UNIQUE KEY `cidade` (`cidade`,`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela exercicio.cidade: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
INSERT INTO `cidade` (`cidade`, `estado`) VALUES
	('cidade 1', 'estado 1'),
	('cidade 2', 'estado 2'),
	('cidade 3', 'estado 3');
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;

-- Copiando estrutura para tabela exercicio.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cep` varchar(50) DEFAULT NULL,
  `usr_representante` varchar(50) NOT NULL,
  UNIQUE KEY `cpf` (`cpf`,`usr_representante`),
  KEY `fk_representante` (`usr_representante`),
  KEY `fk_cidade` (`cidade`),
  CONSTRAINT `fk_cidade` FOREIGN KEY (`cidade`) REFERENCES `cidade` (`cidade`),
  CONSTRAINT `fk_representante` FOREIGN KEY (`usr_representante`) REFERENCES `usuario` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela exercicio.cliente: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`cpf`, `nome`, `sobrenome`, `email`, `endereco`, `cidade`, `estado`, `cep`, `usr_representante`) VALUES
	('111.111.111-11', 'João Pinto', 'Limão', 'joao@email.com', 'rua 1', 'cidade 1', 'estado 1', '11.111-111', 'admin@email.com'),
	('222.222.222-22', 'Maria', 'Pera', 'maria@email.com', 'rua 2', 'cidade 2', 'estado 2', '22.222-222', 'gerente@email.com'),
	('333.333.333-33', 'Marcio', 'Melão', 'marcio@email.com', 'rua 3', 'cidade 3', 'estado 3', '33.333-333', 'admin@email.com');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Copiando estrutura para tabela exercicio.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `email` varchar(50) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela exercicio.usuario: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`email`, `nome`, `senha`) VALUES
	('admin@email.com', 'Administrador', '123'),
	('gerente@email.com', 'Gerente', '123');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
