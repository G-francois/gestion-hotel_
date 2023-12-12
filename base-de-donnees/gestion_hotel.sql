-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 12 déc. 2023 à 14:04
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_hotel`
--

-- --------------------------------------------------------

--
-- Structure de la table `accompagnateur`
--

DROP TABLE IF EXISTS `accompagnateur`;
CREATE TABLE IF NOT EXISTS `accompagnateur` (
  `num_acc` int NOT NULL AUTO_INCREMENT,
  `nom_acc` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_acc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `accompagnateur`
--

INSERT INTO `accompagnateur` (`num_acc`, `nom_acc`, `contact`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'Abdias', '123456', 1, 0, '2023-12-11 13:46:54', NULL),
(2, 'a', '1', 1, 0, '2023-12-11 20:16:12', NULL),
(3, 'b', '2', 1, 0, '2023-12-11 20:16:12', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `num_chambre` int NOT NULL AUTO_INCREMENT,
  `cod_typ` int NOT NULL,
  `lib_typ` varchar(255) NOT NULL,
  `details` varchar(2000) DEFAULT 'Aucune_informations',
  `personnes` varchar(11) DEFAULT '0',
  `superficies` varchar(255) DEFAULT 'Aucune_informations',
  `pu` int NOT NULL,
  `photos` varchar(255) DEFAULT 'Aucune_image',
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_chambre`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`num_chambre`, `cod_typ`, `lib_typ`, `details`, `personnes`, `superficies`, `pu`, `photos`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo.jpg', 0, 0, '2023-12-11 10:54:20', '2023-12-12 11:18:23'),
(2, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles.jpg', 0, 0, '2023-12-11 10:54:34', '2023-12-12 11:19:12'),
(3, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples.jpg', 0, 0, '2023-12-11 10:55:23', '2023-12-12 11:19:12'),
(4, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites.jpg', 1, 0, '2023-12-11 10:55:38', '2023-12-11 21:20:50'),
(5, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo2.jpg', 1, 0, '2023-12-11 10:56:04', '2023-12-12 08:09:10'),
(6, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles2.jpg', 1, 0, '2023-12-11 10:56:16', '2023-12-12 08:09:10'),
(7, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples2.jpg', 1, 0, '2023-12-11 10:56:39', NULL),
(8, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites2.jpg', 1, 0, '2023-12-11 10:56:52', NULL),
(9, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo3.jpg', 1, 0, '2023-12-11 10:57:19', NULL),
(10, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles3.jpg', 1, 0, '2023-12-11 11:57:08', NULL),
(11, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples3.jpg', 1, 0, '2023-12-11 11:57:25', NULL),
(12, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites3.jpg', 1, 0, '2023-12-11 11:57:40', NULL),
(13, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo4.jpg', 1, 0, '2023-12-11 11:57:55', NULL),
(14, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles4.jpg', 1, 0, '2023-12-11 11:59:05', NULL),
(15, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples4.jpg', 1, 0, '2023-12-11 11:59:23', '2023-12-11 12:32:19'),
(16, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites4.jpg', 1, 0, '2023-12-11 11:59:40', '2023-12-11 12:42:40'),
(17, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo5.jpg', 1, 0, '2023-12-11 11:59:54', NULL),
(18, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles5.jpg', 1, 0, '2023-12-11 12:06:31', NULL),
(19, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples5.jpg', 1, 0, '2023-12-11 12:06:53', NULL),
(20, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites5.jpg', 1, 0, '2023-12-11 12:07:11', NULL),
(21, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo6.jpg', 1, 0, '2023-12-11 12:07:24', NULL),
(22, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles6.jpg', 1, 0, '2023-12-11 12:17:13', NULL),
(23, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples6.jpg', 1, 0, '2023-12-11 12:17:58', NULL),
(24, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites6.jpg', 1, 0, '2023-12-11 12:18:26', NULL),
(25, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo7.jpg', 1, 0, '2023-12-12 08:41:30', NULL),
(26, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles7.jpg', 1, 0, '2023-12-12 08:55:58', NULL),
(27, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples7.jpg', 1, 0, '2023-12-12 08:56:12', NULL),
(28, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites7.jpg', 1, 0, '2023-12-12 08:56:28', NULL),
(29, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/gestion-hotel/public/images/upload/Chambres/Solo/Solo8.jpg', 1, 0, '2023-12-12 08:56:54', NULL),
(30, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/gestion-hotel/public/images/upload/Chambres/Double/Doubles8.jpg', 1, 0, '2023-12-12 08:57:06', NULL),
(31, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/gestion-hotel/public/images/upload/Chambres/Triple/Triples8.jpg', 1, 0, '2023-12-12 08:57:20', NULL),
(32, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/gestion-hotel/public/images/upload/Chambres/Suite/Suites8.jpg', 1, 0, '2023-12-12 08:57:32', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `num_cmd` int NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) NOT NULL,
  `num_chambre` int NOT NULL,
  `prix_total` int NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_cmd`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`num_cmd`, `num_res`, `num_chambre`, `prix_total`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(2, 'SLC-1-23', 0, 4250, 1, 0, '2023-12-12 13:15:21', NULL),
(3, 'SLC-1-23', 1, 10500, 1, 0, '2023-12-12 13:29:56', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_clt` int NOT NULL,
  `type_sujet` varchar(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plantes _utilisateur_id` (`num_clt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `num_clt`, `type_sujet`, `messages`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 1, 'réservation 4 ', ' NCVBB HHJBKJBKJ', 1, 0, '2023-12-05 14:04:12', '2023-12-05 13:04:49');

-- --------------------------------------------------------

--
-- Structure de la table `listes_accompagnateurs_reservation`
--

DROP TABLE IF EXISTS `listes_accompagnateurs_reservation`;
CREATE TABLE IF NOT EXISTS `listes_accompagnateurs_reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) NOT NULL,
  `num_chambre` int NOT NULL,
  `num_acc` int NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `num_res` (`num_res`),
  KEY `num_acc` (`num_acc`),
  KEY `liste_accompagnateurs_reservations_num_chambre` (`num_chambre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `listes_accompagnateurs_reservation`
--

INSERT INTO `listes_accompagnateurs_reservation` (`id`, `num_res`, `num_chambre`, `num_acc`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(5, 'SLC-2-23', 2, 1, 1, 0, '2023-12-12 12:19:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `prix_chambres`
--

DROP TABLE IF EXISTS `prix_chambres`;
CREATE TABLE IF NOT EXISTS `prix_chambres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_chambre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `montant` int NOT NULL,
  `est_actif` int NOT NULL DEFAULT '1',
  `est_supprimer` int NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `prix_chambres`
--

INSERT INTO `prix_chambres` (`id`, `type_chambre`, `montant`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'Solo', 15000, 1, 0, '2023-12-02 15:22:34', NULL),
(2, 'Double', 25000, 1, 0, '2023-12-02 15:22:34', NULL),
(3, 'Triple', 35000, 1, 0, '2023-12-02 15:22:34', NULL),
(4, 'Suite', 50000, 1, 0, '2023-12-02 15:22:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `quantite`
--

DROP TABLE IF EXISTS `quantite`;
CREATE TABLE IF NOT EXISTS `quantite` (
  `cod_repas` int NOT NULL,
  `num_cmd` int NOT NULL,
  `num_chambre` int NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  KEY `quantite_chambre _num_chambre` (`num_chambre`),
  KEY `quantite_commande _num_cmd` (`num_cmd`),
  KEY `quantite_repas_cod_repas` (`cod_repas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `quantite`
--

INSERT INTO `quantite` (`cod_repas`, `num_cmd`, `num_chambre`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(3, 3, 1, 1, 0, '2023-12-12 13:29:57', NULL),
(4, 3, 1, 1, 0, '2023-12-12 13:29:58', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas` (
  `cod_repas` int NOT NULL AUTO_INCREMENT,
  `nom_repas` varchar(255) NOT NULL,
  `pu_repas` int NOT NULL,
  `categorie` varchar(255) NOT NULL DEFAULT 'Aucune_information ',
  `photos` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Aucune_image',
  `descriptions` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'Aucune_information ',
  `est_actif` tinyint NOT NULL DEFAULT '0',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cod_repas`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `repas`
--

INSERT INTO `repas` (`cod_repas`, `nom_repas`, `pu_repas`, `categorie`, `photos`, `descriptions`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'Attiéké/Poisson', 3500, 'Entrees', '/gestion-hotel/public/images/upload/repas/Entrees/L\'attiéké.jpg', 'L\'attiéké est un couscous traditionnel ivoirien composé de tubercule de manioc fermentées et moulues. Il est généralement accompagné d\'oignons émincés, de tomates, de poulet grillé ou de poisson frit.', 1, 0, '2023-12-05 14:29:16', '2023-12-05 17:14:47'),
(2, 'Baril de pain', 4250, 'Specialites', '/gestion-hotel/public/images/upload/repas/Specialites/bread-barrel.jpg', 'Le pain maison est un acte de simplicité volontaire.', 1, 0, '2023-12-05 14:31:21', NULL),
(3, 'Gâteau au Crabe', 5000, 'Entrees', '/gestion-hotel/public/images/upload/repas/Entrees/cake.jpg', 'Un gâteau de crabe délicat servi sur un petit pain grillé avec de la laitue et de la sauce tartare.', 1, 0, '2023-12-05 14:37:55', NULL),
(4, 'Sélection de César', 5500, 'Salades', '/gestion-hotel/public/images/upload/repas/Salades/caesar.jpg', 'Un ensemble de plat collectionné composé de viandes et de légumes verts dans une sauce à base de tomates.', 1, 0, '2023-12-05 14:39:09', NULL),
(5, 'Grillade Toscanes', 6200, 'Specialites', '/gestion-hotel/public/images/upload/repas/Specialites/tuscan-grilled.jpg', 'Poulet grillé avec provolone, cœurs d\'artichauts et pesto rouge rôti.', 1, 0, '2023-12-05 14:40:19', NULL),
(6, 'Bâton de Mozzarella', 3000, 'Entrees', '/gestion-hotel/public/images/upload/repas/Entrees/mozzarella.jpg', 'Les bâtonnets de mozzarella sont une collation frite populaire composée de longues tranches de fromage mozzarella garni de chapelure assaisonnée et frite jusqu’à ce qu’elle soit dorée et fondue à l’intérieur.', 1, 0, '2023-12-05 14:41:04', NULL),
(7, 'Salade Grecque', 4200, 'Salades', '/gestion-hotel/public/images/upload/repas/Salades/greek-salad.jpg', 'Épinards frais, romaine croustillante, tomates et olives grecques.', 1, 0, '2023-12-05 14:42:09', NULL),
(8, 'Salade d\'épinards', 3000, 'Salades', '/gestion-hotel/public/images/upload/repas/Salades/spinach-salad.jpg', 'Épinards frais aux champignons, œuf dur et vinaigrette chaude au bacon.', 1, 0, '2023-12-05 14:43:13', NULL),
(9, 'Rouleau de homard', 8000, 'Specialites', '/gestion-hotel/public/images/upload/repas//lobster-roll.jpg', 'Chair de homard dodue, mayonnaise et laitue croustillante sur un gros pain grillé.', 1, 0, '2023-12-05 14:44:03', '2023-12-06 09:11:56');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) NOT NULL,
  `num_clt` int NOT NULL,
  `prix_total` int NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'En cours de validation',
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_utilisateur_id` (`num_clt`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `num_res`, `num_clt`, `prix_total`, `statut`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(6, 'SLC-1-23', 3, 30000, 'En cours de validation', 1, 0, '2023-12-12 12:18:24', NULL),
(7, 'SLC-2-23', 3, 155000, 'En cours de validation', 1, 0, '2023-12-12 12:19:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservation_chambres`
--

DROP TABLE IF EXISTS `reservation_chambres`;
CREATE TABLE IF NOT EXISTS `reservation_chambres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `num_chambre` int NOT NULL,
  `montant` int NOT NULL,
  `deb_occ` datetime NOT NULL,
  `fin_occ` datetime NOT NULL,
  `est_actif` int NOT NULL DEFAULT '1',
  `est_supprimer` int NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `reservation_chambres`
--

INSERT INTO `reservation_chambres` (`id`, `num_res`, `num_chambre`, `montant`, `deb_occ`, `fin_occ`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(9, 'SLC-1-23', 1, 30000, '2023-12-12 13:18:23', '2023-12-13 13:18:23', 1, 0, '2023-12-12 12:18:25', NULL),
(10, 'SLC-2-23', 2, 50000, '2023-12-12 13:19:12', '2023-12-13 13:19:12', 1, 0, '2023-12-12 12:19:13', NULL),
(11, 'SLC-2-23', 3, 105000, '2023-12-13 13:19:12', '2023-12-15 13:19:12', 1, 0, '2023-12-12 12:19:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `est_actif` tinyint NOT NULL DEFAULT '1',
  `est_supprimer` tinyint DEFAULT '0',
  `créer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `token`
--

INSERT INTO `token` (`id`, `user_id`, `type`, `token`, `est_actif`, `est_supprimer`, `créer_le`, `maj_le`) VALUES
(1, 1, 'VALIDATION_COMPTE', '656a49a535bd9', 0, 1, '2023-12-01 21:01:25', '2023-12-01 20:07:47');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` varchar(11) DEFAULT NULL,
  `telephone` varchar(8) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `nom_utilisateur` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'Aucune_image',
  `profil` varchar(255) NOT NULL,
  `mot_passe` varchar(255) DEFAULT NULL,
  `est_actif` tinyint(1) NOT NULL DEFAULT '0',
  `est_supprimer` tinyint(1) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `email`, `nom_utilisateur`, `avatar`, `profil`, `mot_passe`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'BESSAN', 'Fr&eacute;jus', NULL, NULL, 'frejusbessan@gmail.com', 'jow', 'Aucune_image', 'CLIENT', '940bc542597dee4c3d1df4353e92e8428a109202', 1, 0, '2023-12-01 21:01:25', '2023-12-11 09:53:47'),
(2, 'GNONHOUE', 'François ', 'Masculin', '98999900', 'francois.gnonhoue@gmail.com', 'FRANCHESCO', 'Aucune_image', 'ADMINISTRATEUR', 'f840a916ffd473dd637aa23000691527d1d2231c', 1, 0, '2023-12-05 13:53:23', '2023-12-08 06:51:26'),
(3, 'DUPONT', 'DE TARSE', 'Féminin', '1', 'ranco@gmail.com', 'G. Christina', 'Aucune_image', 'CLIENT', 'b41238934314fae676bb84c941f013a42e36ae68', 1, 0, '2023-12-08 22:50:11', '2023-12-11 09:18:43');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `listes_accompagnateurs_reservation`
--
ALTER TABLE `listes_accompagnateurs_reservation`
  ADD CONSTRAINT `liste_accompagnateurs_reservations_num_acc` FOREIGN KEY (`num_acc`) REFERENCES `accompagnateur` (`num_acc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `liste_accompagnateurs_reservations_num_chambre` FOREIGN KEY (`num_chambre`) REFERENCES `chambre` (`num_chambre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quantite`
--
ALTER TABLE `quantite`
  ADD CONSTRAINT `quantite_chambre _num_chambre` FOREIGN KEY (`num_chambre`) REFERENCES `chambre` (`num_chambre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quantite_commande _num_cmd` FOREIGN KEY (`num_cmd`) REFERENCES `commande` (`num_cmd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quantite_repas_cod_repas` FOREIGN KEY (`cod_repas`) REFERENCES `repas` (`cod_repas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_utilisateur_id` FOREIGN KEY (`num_clt`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
