-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 08 déc. 2024 à 21:05
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ice_invst`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `solde` decimal(10,2) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `id_utilisateur`, `solde`, `date_creation`) VALUES
(1, 1, 1000.00, '2024-12-08 17:16:43');

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

DROP TABLE IF EXISTS `depots`;
CREATE TABLE IF NOT EXISTS `depots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compte` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_depots` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `investissement`
--

DROP TABLE IF EXISTS `investissement`;
CREATE TABLE IF NOT EXISTS `investissement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_projet` int DEFAULT NULL,
  `id_compte` int DEFAULT NULL,
  `montant_investi` decimal(10,2) DEFAULT NULL,
  `date_investissement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_projet` (`id_projet`),
  KEY `id_compte` (`id_compte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parrainages`
--

DROP TABLE IF EXISTS `parrainages`;
CREATE TABLE IF NOT EXISTS `parrainages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_parrain` int DEFAULT NULL,
  `id_invite` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_parrain` (`id_parrain`),
  KEY `id_invite` (`id_invite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(244) DEFAULT NULL,
  `description` text,
  `montant_necessaire` decimal(10,2) DEFAULT NULL,
  `date_debut` timestamp NULL DEFAULT NULL,
  `date_fin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `retraits`
--

DROP TABLE IF EXISTS `retraits`;
CREATE TABLE IF NOT EXISTS `retraits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compte` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_retrait` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transaction_log`
--

DROP TABLE IF EXISTS `transaction_log`;
CREATE TABLE IF NOT EXISTS `transaction_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compte` int DEFAULT NULL,
  `type_transaction` varchar(20) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_transaction` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `mots_de_pass` varchar(277) DEFAULT NULL,
  `numero` varchar(9) DEFAULT NULL,
  `solde` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `mots_de_pass`, `numero`, `solde`) VALUES
(1, 'LUVIC', '$2y$10$l.Qmab5slv7uAQMLtua/keJa5xmN5caT7Cx7X.ETGplXyDtVy/Xc.', '654568728', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
