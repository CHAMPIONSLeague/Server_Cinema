-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 17, 2022 alle 12:25
-- Versione del server: 8.0.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_clowncinema`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `film`
--

CREATE TABLE IF NOT EXISTS `film` (
  `codice_film` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `durata` time NOT NULL,
  `descrizione` varchar(300) NOT NULL,
  PRIMARY KEY (`codice_film`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `film`
--

INSERT INTO `film` (`codice_film`, `nome`, `durata`, `descrizione`) VALUES
(1, 'Doctor Strange nel Multiverso della Follia', '00:00:00', 'Il dottor Stephen Strange continua le sue ricerche sul Time Stone. Tuttavia, un vecchio amico trasformatosi in nemico cerca di distruggere tutti gli stregoni sulla Terra, scherzando con il piano di Strange.'),
(2, 'Uncharted', '00:00:00', 'Nathan Drake e il suo compagno di avventure Sully si lanciano in una pericolosa ricerca per trovare il più grande tesoro perduto, mentre seguono anche gli indizi che potrebbero portare al fratello di Nathan, scomparso da tempo.');

-- --------------------------------------------------------

--
-- Struttura della tabella `palinsesto`
--

CREATE TABLE IF NOT EXISTS `palinsesto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codice_spettacolo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_spettacolo` (`codice_spettacolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `palinsesto`
--

INSERT INTO `palinsesto` (`id`, `codice_spettacolo`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE IF NOT EXISTS `prenotazione` (
  `codice_prenotazione` int NOT NULL AUTO_INCREMENT,
  `id` int NOT NULL,
  `codice_spettacolo` int NOT NULL,
  `data_ora` datetime NOT NULL,
  PRIMARY KEY (`codice_prenotazione`),
  KEY `utenteKey-prenotazioneutente` (`id`),
  KEY `filmKey-prenotazionefilm` (`codice_spettacolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `sala`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `codice_sala` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `dim_sala` int NOT NULL,
  PRIMARY KEY (`codice_sala`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `sala`
--

INSERT INTO `sala` (`codice_sala`, `nome`, `dim_sala`) VALUES
(1, 'sala_1', 30),
(2, 'sala_2', 30);

-- --------------------------------------------------------

--
-- Struttura della tabella `spettacolo`
--

CREATE TABLE IF NOT EXISTS `spettacolo` (
  `codice_spettacolo` int NOT NULL AUTO_INCREMENT,
  `codice_sala` int NOT NULL,
  `codice_film` int NOT NULL,
  `data_ora` datetime NOT NULL,
  `p_occupati` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`codice_spettacolo`),
  KEY `salaKey-spettacolosala` (`codice_sala`),
  KEY `filmKey-spettacolofilm` (`codice_film`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `spettacolo`
--

INSERT INTO `spettacolo` (`codice_spettacolo`, `codice_sala`, `codice_film`, `data_ora`, `p_occupati`) VALUES
(1, 1, 1, '2022-05-08 19:57:27', 12),
(2, 2, 2, '2022-05-08 19:57:27', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(319) NOT NULL,
  `password` varchar(100) NOT NULL,
  `privilegi` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `username`, `email`, `password`, `privilegi`) VALUES
(1, 'test.admin', 'test.admin@gmail.com', 'test.admin', 1),
(2, 'test.user', 'test.user@gmail.com', 'test.user', 0),
(3, 'test.utente', 'test.utente@gmail.com', 'test.utente', 0);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `palinsesto`
--
ALTER TABLE `palinsesto`
  ADD CONSTRAINT `cod_spettacolo` FOREIGN KEY (`codice_spettacolo`) REFERENCES `spettacolo` (`codice_spettacolo`);

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_cod_spettacolo` FOREIGN KEY (`codice_spettacolo`) REFERENCES `spettacolo` (`codice_spettacolo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prenotazione_id_user` FOREIGN KEY (`id`) REFERENCES `utente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limiti per la tabella `spettacolo`
--
ALTER TABLE `spettacolo`
  ADD CONSTRAINT `filmKey-spettacolofilm` FOREIGN KEY (`codice_film`) REFERENCES `film` (`codice_film`),
  ADD CONSTRAINT `salaKey-spettacolosala` FOREIGN KEY (`codice_sala`) REFERENCES `sala` (`codice_sala`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
