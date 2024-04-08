-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 04, 2024 alle 11:27
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fotorum`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `account`
--
CREATE DATABASE IF NOT EXISTS `fotorum` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fotorum`;

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(42) DEFAULT NULL,
  `surname` varchar(26) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL CHECK (octet_length(`nickname`) >= 4),
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `dateBorn` date DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `pronoun` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `account`
--

INSERT INTO `account` (`id`, `name`, `surname`, `nickname`, `email`, `password`, `salt`, `dateBorn`, `sex`, `pronoun`, `location`, `work`, `role`, `photo`, `verified`) VALUES
(1, 'ciao', 'ciao', 'ciao', 'ciao@c.iao', '333b6722f8850df99849bb2dcb365d9ab16f5394368f4ae159575a762b695e92f28494e4d0b9ec758f5e0e02cc93600aaa814997ef02d2b3dc67770bf1d4ae4b', 'acfb774099276004c632bcac268051b7566c2fd6e135a11af0d5830e42f54c79', '2000-10-10', 3505, 22, 'ciao', 'ciao', 1, NULL, 1),
(2, 'franco', 'franchini', 'FRanC0', 'Franco@e.figo', 'ac8f56d15601bea6dc237f13957b3f32a02032e417f327bfe2a042b4441791b24acb1a891d5df029bd0a9c2a5622426105307522d076a02deedefb6c1f026aa6', '3fcbde0b4e6577029693860270e76ee8227e48742305c6c56438917579767644', '2000-02-20', 748, 45, 'Casa Sua', 'Studente sottomesso', 1, 'fProfile/IMG_2582-Edit-Edit.webp', 1),
(3, 'Filispo', 'Scanzsi', 'scanzi', 'scanzi@gmail.com', 'ae5f21f2eb6c635356d9f61eb2e589b74d9e603970741af63df89a82c5e6713f98be59a4302663a19d2f11c56ee8780dac16a81ba0acd5220ff35424ae4e6e41', '044da630ece6d2b7be97f4463741330a8e4a89a5d64afd53315745b5192e8aea', '2005-08-08', 3505, 22, 'Almenno', 'Studente', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `account_id`) VALUES
(3, 1, 2),
(4, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `original_photo` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`id`, `photo`, `original_photo`, `file`, `text`, `account_id`) VALUES
(1, 'fPostS/IMG_0071.webp', 'downloads/IMG_0071.JPG', NULL, 'Osti', 1),
(2, 'fPostS/IMG_3998-Enhanced-NR-2.webp', 'downloads/IMG_3998-Enhanced-NR-2.jpg', NULL, 'Bergamo Valverde', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `pronoun`
--

CREATE TABLE `pronoun` (
  `id` int(11) NOT NULL,
  `pronoun` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `pronoun`
--

INSERT INTO `pronoun` (`id`, `pronoun`) VALUES
(1, 'I'),
(2, 'me'),
(3, 'my'),
(4, 'mine'),
(5, 'myself'),
(6, 'we'),
(7, 'us'),
(8, 'our'),
(9, 'ours'),
(10, 'ourselves'),
(11, 'you'),
(12, 'your'),
(13, 'yours'),
(14, 'yourself'),
(15, 'thou'),
(16, 'thee'),
(17, 'thine'),
(18, 'thyself'),
(19, 'yo'),
(20, 'you all'),
(21, 'ye'),
(22, 'he'),
(23, 'him'),
(24, 'his'),
(25, 'himself'),
(26, 'she'),
(27, 'her'),
(28, 'hers'),
(29, 'herself'),
(30, 'it'),
(31, 'its'),
(32, 'itself'),
(33, 'they'),
(34, 'them'),
(35, 'their'),
(36, 'theirs'),
(37, 'themself'),
(38, 'themselves'),
(39, 'one'),
(40, 'oneself'),
(41, 'ae'),
(42, 'aer'),
(43, 'aerself'),
(44, 'co'),
(45, 'cos'),
(46, 'coself'),
(47, 'e'),
(48, 'em'),
(49, 'eir'),
(50, 'eirs'),
(51, 'emself'),
(52, 'ey'),
(53, 'eirself'),
(54, 'fae'),
(55, 'faer'),
(56, 'faerself'),
(57, 'fey'),
(58, 'fem'),
(59, 'feir'),
(60, 'feirs'),
(61, 'femself'),
(62, 'hu'),
(63, 'hum'),
(64, 'hus'),
(65, 'humself'),
(66, 'hy'),
(67, 'hym'),
(68, 'hys'),
(69, 'hymself'),
(70, 'kie'),
(71, 'kir'),
(72, 'kirs'),
(73, 'kirself'),
(74, 'mer'),
(75, 'mers'),
(76, 'merself'),
(77, 'ne'),
(78, 'nem'),
(79, 'nir'),
(80, 'nirs'),
(81, 'nemself'),
(82, 'nyself'),
(83, 'nirself'),
(84, 'nee'),
(85, 'ner'),
(86, 'ners'),
(87, 'nerself'),
(88, 'peh'),
(89, 'pehm'),
(90, 'pehs'),
(91, 'pehself'),
(92, 'per'),
(93, 'pers'),
(94, 'perself'),
(95, 'sie'),
(96, 'hir'),
(97, 'hirs'),
(98, 'hirself'),
(99, 'te'),
(100, 'tir'),
(101, 'tes'),
(102, 'tirself'),
(103, 'tey'),
(104, 'tem'),
(105, 'ter'),
(106, 'ters'),
(107, 'temself'),
(108, 'thon'),
(109, 'thons'),
(110, 'thonself'),
(111, 've'),
(112, 'ver'),
(113, 'vis'),
(114, 'verself'),
(115, 'xe'),
(116, 'xem'),
(117, 'xyr'),
(118, 'xyrs'),
(119, 'xemself'),
(120, 'ze'),
(121, 'zir'),
(122, 'zirs'),
(123, 'zirself');

-- --------------------------------------------------------

--
-- Struttura della tabella `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `role`
--

INSERT INTO `role` (`id`, `role`, `description`) VALUES
(1, 0, 'user'),
(2, 1, 'admin'),
(3, 2, 'Admin'),
(4, 3, 'blocked'),
(5, 4, 'banned');

-- --------------------------------------------------------

--
-- Struttura della tabella `sex`
--

CREATE TABLE `sex` (
  `id` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `verify`
--

CREATE TABLE `verify` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `verification_code` varchar(8) NOT NULL,
  `expiration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `sex` (`sex`),
  ADD KEY `pronoun` (`pronoun`),
  ADD KEY `role` (`role`);

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indici per le tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indici per le tabelle `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indici per le tabelle `pronoun`
--
ALTER TABLE `pronoun`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `pronoun`
--
ALTER TABLE `pronoun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT per la tabella `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `sex`
--
ALTER TABLE `sex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3620;

--
-- AUTO_INCREMENT per la tabella `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`sex`) REFERENCES `sex` (`id`),
  ADD CONSTRAINT `account_ibfk_2` FOREIGN KEY (`pronoun`) REFERENCES `pronoun` (`id`),
  ADD CONSTRAINT `account_ibfk_3` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

--
-- Limiti per la tabella `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `verify`
--
ALTER TABLE `verify`
  ADD CONSTRAINT `verify_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
