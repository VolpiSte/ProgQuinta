-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 09, 2024 alle 12:58
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
(1, 'admin', 'admin', 'admin', 'admina@a.dmin', 'dbf0f084e80f24e0dbc76285e654082633c281cb37b08ac564832de19662110fa537e8c593a8b10983bf32f636a9b1174c1af1f6ab08a3f97e3936f888a9971b', '8fba33d35410cde2c6d8fcfee13351ffb3a0894c9f84168064e3c124175d9d67', '0001-01-01', 3505, 22, 'admin', 'admin', 3, 'fProfile/IMG_0617.webp', 1),
(6, 'simone', 'arzuffi', 'Contravvenzione', 'arzu@email.com', '845fc7102bc8f8d52e6014dec3ce2cad7f9285f57f39b6cc3ecfb2fcd79620334031f77ee22b8fac0500f2cf2829af4c2012a2b508e18bcced907d16de03a361', '47446ba20e6200062c5b5d262f2f5d5f292618277af4726698d0f43bc1a4d42d', '2005-05-08', 3505, 22, 'Zanica', 'Studente sottopagato', 1, 'fProfile/IMG_0632.webp', 1),
(7, 'polpo', 'polpo', 'polpaccio', 'polpo@email.com', '1735706d1210ed5f6542f3aeb5eace819e5a7f810d2a8828f502746c28b907df57312869beab6cf1fe6096d083ade7fecb9b94cae8fa0d6432ffd322c5858168', '92e9a69f9711a048c2c06e99647d9936294dda81677af6d19df558416a01f180', '2005-12-27', 3505, 22, 'Locatello', 'NO', 1, 'fProfile/IMG_0017.webp', 1),
(8, 'marco', 'montanelli', 'smonta', 'smonta@email.com', '8385f99c43b85b8441573a137ef455b37bb08c211a7ec932c55b7589f9dec69448d65d7a081a1fde0d60c6f4ce8453b5950010be64be6b8e3d02298211fd4983', '81dfe6b1a89086155cfe8465999289a483962bd503c7b65c81388edae964e0f2', '2005-03-29', 1901, 5, 'Casa', 'Studente', 1, NULL, 1);

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

--
-- Dump dei dati per la tabella `comment`
--

INSERT INTO `comment` (`id`, `text`, `post_id`, `account_id`) VALUES
(4, 'Bella macchina (REAL)', 3, 1),
(5, 'Ciao da Locatello', 3, 7),
(6, 'Foto inappropriata (by Admin)', 4, 1),
(7, 'Woo, in chiamata col Drago!!!🔥🔥', 4, 6);

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
(18, 3, 8),
(19, 4, 8);

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
(3, 'fPostS/IMG_0634.webp', 'downloads/IMG_0634.JPG', NULL, 'Osti che bella macchina (la mia)', 6),
(4, 'fPostS/IMG_0621.webp', 'downloads/IMG_0621.JPG', NULL, 'Myself (beautiful)', 8);

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
(1, 1, 'user'),
(2, 2, 'admin'),
(3, 3, 'Admin'),
(4, 4, 'blocked'),
(5, 5, 'banned');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
