-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 03 oct. 2020 à 17:01
-- Version du serveur :  8.0.21-0ubuntu0.20.04.4
-- Version de PHP : 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `imaneTChat`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_chatMessage`
--

CREATE TABLE `t_chatMessage` (
  `id` int NOT NULL,
  `to_user_id` int DEFAULT NULL,
  `from_user_id` int DEFAULT NULL,
  `chat_message` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_chatMessage`
--

INSERT INTO `t_chatMessage` (`id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `created`, `createdBy`, `updated`, `updatedBy`, `status`) VALUES
(1, 2, 1, 'ezrrezr', '2020-10-03 11:16:06', NULL, NULL, NULL, NULL, 0),
(2, 2, 1, 'ezrrezr', '2020-10-03 11:16:07', NULL, NULL, NULL, NULL, 0),
(3, 2, 1, 'dqsdqsdf', '2020-10-03 12:03:45', NULL, NULL, NULL, NULL, 0),
(4, 2, 1, 'erzer', '2020-10-03 12:05:03', NULL, NULL, NULL, NULL, 0),
(5, 2, 1, 'Hello', '2020-10-03 12:05:30', NULL, NULL, NULL, NULL, 0),
(6, 1, 2, 'Hello Yasine', '2020-10-03 12:06:01', NULL, NULL, NULL, NULL, 0),
(7, 2, 1, 'Salut Imane', '2020-10-03 12:07:30', NULL, NULL, NULL, NULL, 0),
(8, 1, 2, 'Hello Yassine', '2020-10-03 12:07:51', NULL, NULL, NULL, NULL, 0),
(9, 2, 1, 'qdq', '2020-10-03 12:30:48', NULL, NULL, NULL, NULL, 1),
(10, 2, 1, 'hhdzdz', '2020-10-03 12:32:28', NULL, NULL, NULL, NULL, 1),
(11, 2, 1, NULL, '2020-10-03 12:33:05', NULL, NULL, NULL, NULL, 1),
(12, 3, 1, NULL, '2020-10-03 12:33:13', NULL, NULL, NULL, NULL, 1),
(13, 2, 1, NULL, '2020-10-03 12:34:50', NULL, NULL, NULL, NULL, 1),
(14, 3, 1, 'Hello Zizo', '2020-10-03 12:45:04', NULL, NULL, NULL, NULL, 1),
(15, 2, 1, 'Hello Imane', '2020-10-03 12:48:04', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_loginDetails`
--

CREATE TABLE `t_loginDetails` (
  `user_id` int DEFAULT NULL,
  `latest_activity` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` varchar(50) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_type` enum('no','yes') NOT NULL,
  `login_details_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_loginDetails`
--

INSERT INTO `t_loginDetails` (`user_id`, `latest_activity`, `created`, `createdBy`, `updated`, `updatedBy`, `last_activity`, `is_type`, `login_details_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 02:04:47', 'no', NULL),
(2, NULL, NULL, NULL, NULL, NULL, '2020-10-03 02:05:36', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 02:08:43', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 09:43:00', 'no', NULL),
(2, NULL, NULL, NULL, NULL, NULL, '2020-10-03 12:05:52', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 12:07:13', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 13:26:19', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 13:34:16', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 13:40:06', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 13:42:27', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 14:29:25', 'no', NULL),
(5, NULL, NULL, NULL, NULL, NULL, '2020-10-03 14:32:25', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 14:44:18', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 14:44:39', 'no', NULL),
(1, NULL, NULL, NULL, NULL, NULL, '2020-10-03 14:45:08', 'no', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `id` int NOT NULL,
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `profil` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`id`, `login`, `password`, `profil`, `status`, `created`) VALUES
(1, 'sino', '$2y$10$qlDiaGWLqte//ABiFTYFquNoHSnos6Gm1srjmSnBGfP8Vl2VaiS7G', '', 1, '2020-10-02'),
(2, 'imane', '$2y$10$SiU9jSX5PNMHEABuOPSBguArFiT5jZj/Vvf88AQGW6Sep1XYMYaO2', '', 1, '2020-10-03'),
(3, 'zizo', '$2y$10$CndMHueF76nW5rfE3t/ZLOjWQOOBzitzMdYWsmoVP6CyWN6tvhAq6', '', 1, '2020-10-03'),
(4, 'hind', '$2y$10$6jfe9xySbRf4FOR3B9RhL.EkccKe8WGU8GRPhDdY9rmOBJV9rKBqu', '1', 1, '2020-10-03'),
(5, 'jamal', '$2y$10$OYAIyTe/sJIRu/OFcS/TNOjgSWOs9zG8mNavijBBIrVodKDECscMq', '', 1, '2020-10-03'),
(6, 'hind', '$2y$10$gpHLDKrhIg8JE.cL20FuMe3vNaE6.VEt4YOkWnEKIeASSr2JA1bUS', '1', 1, '2020-10-03');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_chatMessage`
--
ALTER TABLE `t_chatMessage`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_chatMessage`
--
ALTER TABLE `t_chatMessage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
