-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 04 déc. 2024 à 19:12
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`id`, `id_utilisateur`, `solde`, `date_creation`) VALUES
(1, 1, 1000000.00, '2024-12-01 20:42:25'),
(2, 2, 1000.00, '2024-12-01 20:54:08'),
(3, 3, 1000.00, '2024-12-04 12:56:05');

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
-- Structure de la table `packs`
--

DROP TABLE IF EXISTS `packs`;
CREATE TABLE IF NOT EXISTS `packs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `description` text,
  `prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `packs`
--

INSERT INTO `packs` (`id`, `nom`, `description`, `prix`) VALUES
(3, 'ice A', 'Pack gratuit avec un revenu quotidien de 100XAF pendant 13 jours', 0.00),
(4, 'ice D', 'Pack premium avec un revenu de 500XAF/jour pendant 20 jours', 5000.00),
(5, 'ice CF', 'Pack premium avec un revenu de 900XAF/jour pendant 20 jours', 10000.00),
(6, 'ice H', 'Pack premium avec un revenu de 1200XAF/jour pendant 20 jours', 15000.00),
(7, 'ice G', 'Pack premium avec un revenu de 3500XAF/jour pendant 20 jours', 40000.00),
(8, 'ice V', 'Pack premium avec un revenu de 4000XAF/jour pendant 20 jours', 50000.00),
(9, 'ice V+', 'Pack premium avec un revenu de 5000XAF/jour pendant 20 jours', 80000.00),
(10, 'ice A', 'Pack premium avec un revenu de 10000XAF/jour pendant 20 jours', 120000.00);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `mots_de_pass`, `numero`, `solde`) VALUES
(1, 'LUVIC', '$2y$10$hFwxJ3YZlTftCemXGrmYDOIujJcGpDiiqQgIGASVm60sttww2sOb6', '654568728', NULL),
(2, 'BORIS', '$2y$10$D3oDTwA.cTG0Mto2M5uA/uV1vektT9PVdSKGf1/b.KS2A.BNig6iy', '653530198', NULL),
(3, 'harrys', '$2y$10$q1PQH.wCPn6pklRpd3.FheTXz8Uun25UXczfrhsAuVFdNlPcN6tke', '673081959', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
