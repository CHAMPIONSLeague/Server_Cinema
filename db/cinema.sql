-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 14, 2022 alle 23:33
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `film`
--

CREATE TABLE `film` (
  `codice_film` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `durata` time NOT NULL,
  `descrizione` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `palinsesto` (
  `id` int(11) NOT NULL,
  `codice_spettacolo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `palinsesto`
--

INSERT INTO `palinsesto` (`id`, `codice_spettacolo`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `codice_prenotazione` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `codice_film` int(11) NOT NULL,
  `data_ora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`codice_prenotazione`, `username`, `codice_film`, `data_ora`) VALUES
(1, 'test.user', 1, '2022-05-08 19:58:30'),
(2, 'test.user', 2, '2022-05-08 19:58:30'),
(3, 'test.user', 2, '2022-05-09 15:05:48'),
(4, 'test.user', 1, '2022-05-13 21:21:18'),
(5, 'test.user', 1, '2022-05-13 21:25:38');

-- --------------------------------------------------------

--
-- Struttura della tabella `sala`
--

CREATE TABLE `sala` (
  `codice_sala` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dim_sala` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `spettacolo` (
  `codice_spettacolo` int(11) NOT NULL,
  `codice_sala` int(11) NOT NULL,
  `codice_film` int(11) NOT NULL,
  `data_ora` datetime NOT NULL,
  `p_occupati` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `spettacolo`
--

INSERT INTO `spettacolo` (`codice_spettacolo`, `codice_sala`, `codice_film`, `data_ora`, `p_occupati`) VALUES
(1, 1, 1, '2022-05-08 19:57:27', 30),
(2, 2, 2, '2022-05-08 19:57:27', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username` varchar(30) NOT NULL,
  `email` varchar(319) NOT NULL,
  `password` varchar(100) NOT NULL,
  `privilegi` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `email`, `password`, `privilegi`) VALUES
('test.admin', 'test.admin@gmail.com', 'test.admin', 1),
('test.user', 'test.user@gmail.com', 'test.user', 0),
('test.utente', 'test.utente@gmail.com', 'test.utente', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`codice_film`);

--
-- Indici per le tabelle `palinsesto`
--
ALTER TABLE `palinsesto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_spettacolo` (`codice_spettacolo`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`codice_prenotazione`),
  ADD KEY `utenteKey-prenotazioneutente` (`username`),
  ADD KEY `filmKey-prenotazionefilm` (`codice_film`);

--
-- Indici per le tabelle `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`codice_sala`);

--
-- Indici per le tabelle `spettacolo`
--
ALTER TABLE `spettacolo`
  ADD PRIMARY KEY (`codice_spettacolo`),
  ADD KEY `salaKey-spettacolosala` (`codice_sala`),
  ADD KEY `filmKey-spettacolofilm` (`codice_film`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `film`
--
ALTER TABLE `film`
  MODIFY `codice_film` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `palinsesto`
--
ALTER TABLE `palinsesto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `codice_prenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `sala`
--
ALTER TABLE `sala`
  MODIFY `codice_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `spettacolo`
--
ALTER TABLE `spettacolo`
  MODIFY `codice_spettacolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `palinsesto`
--
ALTER TABLE `palinsesto`
  ADD CONSTRAINT `cod_spettacolo` FOREIGN KEY (`codice_spettacolo`) REFERENCES `spettacolo` (`codice_spettacolo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `filmKey-prenotazionefilm` FOREIGN KEY (`codice_film`) REFERENCES `film` (`codice_film`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `utenteKey-prenotazioneutente` FOREIGN KEY (`username`) REFERENCES `utente` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `spettacolo`
--
ALTER TABLE `spettacolo`
  ADD CONSTRAINT `filmKey-spettacolofilm` FOREIGN KEY (`codice_film`) REFERENCES `film` (`codice_film`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `salaKey-spettacolosala` FOREIGN KEY (`codice_sala`) REFERENCES `sala` (`codice_sala`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
