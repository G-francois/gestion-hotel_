-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 05 déc. 2023 à 13:09
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_hot`
--

-- --------------------------------------------------------

--
-- Structure de la table `accompagnateur`
--

DROP TABLE IF EXISTS `accompagnateur`;
CREATE TABLE IF NOT EXISTS `accompagnateur` (
  `num_acc` int(11) NOT NULL AUTO_INCREMENT,
  `nom_acc` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_acc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `accompagnateur`
--

INSERT INTO `accompagnateur` (`num_acc`, `nom_acc`, `contact`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'Adonis', '66191332', 1, 0, '2023-12-04 15:00:02', NULL),
(2, 'Fréjus', '62944133', 1, 0, '2023-12-04 15:00:02', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `num_chambre` int(11) NOT NULL AUTO_INCREMENT,
  `cod_typ` int(11) NOT NULL,
  `lib_typ` varchar(255) NOT NULL,
  `details` varchar(2000) DEFAULT 'Aucune_informations',
  `personnes` varchar(11) DEFAULT '0',
  `superficies` varchar(255) DEFAULT 'Aucune_informations',
  `pu` int(11) NOT NULL,
  `photos` varchar(255) DEFAULT 'Aucune_image',
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_chambre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`num_chambre`, `cod_typ`, `lib_typ`, `details`, `personnes`, `superficies`, `pu`, `photos`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo.jpg', 1, 0, '2023-10-13 17:47:09', '2023-12-04 14:00:18'),
(2, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles.jpg', 0, 0, '2023-10-13 17:53:03', '2023-12-04 14:00:18'),
(3, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples.jpg', 0, 0, '2023-10-13 17:53:23', '2023-12-04 14:00:18'),
(4, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/soutenance/public/images/upload/Suite/Suites.jpg', 1, 0, '2023-10-13 17:53:36', '2023-12-03 21:37:56'),
(5, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo2.jpg', 1, 0, '2023-10-13 17:55:01', '2023-12-03 21:41:21'),
(6, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles2.jpg', 1, 0, '2023-10-13 17:55:15', '2023-12-03 21:42:15'),
(7, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples3.jpg', 1, 0, '2023-10-13 17:57:14', '2023-12-03 21:44:15'),
(8, 4, 'Suite', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '5', '100m²', 50000, '/soutenance/public/images/upload/Triples/Suites3.jpg', 1, 0, '2023-10-13 17:57:29', '2023-12-03 21:46:04'),
(9, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo3.jpg', 1, 0, '2023-10-13 17:58:35', '2023-12-04 01:07:30'),
(10, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles3.jpg', 1, 0, '2023-10-13 17:59:56', '2023-12-04 01:07:30'),
(11, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples3.jpg', 1, 0, '2023-10-13 18:00:21', NULL),
(12, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/soutenance/public/images/upload/Suite/Suites3.jpg', 1, 0, '2023-10-13 18:00:34', NULL),
(13, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo4.jpg', 1, 0, '2023-10-13 18:00:47', NULL),
(14, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles5.jpg', 1, 0, '2023-10-13 18:10:34', NULL),
(15, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples4.jpg', 1, 0, '2023-10-13 18:10:54', NULL),
(16, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/soutenance/public/images/upload/Suite/Suites4.jpg', 1, 0, '2023-10-13 18:11:15', NULL),
(17, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo5.jpg', 1, 0, '2023-10-13 18:11:30', NULL),
(18, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles6.jpg', 1, 0, '2023-10-13 18:11:50', NULL),
(19, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples5.jpg', 1, 0, '2023-10-13 18:12:09', NULL),
(20, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/soutenance/public/images/upload/Suite/Suite5.jpg', 1, 0, '2023-10-13 18:12:28', NULL),
(21, 1, 'Solo', 'La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu\'un seul voyageur.', '1', '30m²', 15000, '/soutenance/public/images/upload/Solo/Solo6.jpg', 1, 0, '2023-10-13 18:13:43', NULL),
(22, 2, 'Double', 'Profitez du balcon et de la vue sur l\'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d\'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².', '2', '50m²', 25000, '/soutenance/public/images/upload/Doubles/Doubles4 (2).jpg', 1, 0, '2023-10-13 18:16:05', '2023-11-09 09:18:38'),
(23, 3, 'Triple', 'Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d\'une personne ou bien 1 lit double de 2 personnes et 1 d\'une personne avec un canapé et a une superficie de 70m².', '3', '70m²', 35000, '/soutenance/public/images/upload/Triples/Triples 5.jpg', 1, 0, '2023-10-13 18:17:01', NULL),
(24, 4, 'Suite', 'Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu\'à cinq voyageurs.', '5', '100m²', 50000, '/soutenance/public/images/upload/Suite/Suites5.jpg', 1, 0, '2023-10-13 18:17:29', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `num_cmd` int(11) NOT NULL AUTO_INCREMENT,
  `num_res` int(11) NOT NULL,
  `prix_total` int(11) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`num_cmd`),
  KEY `num_res` (`num_res`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `listes_accompagnateurs_reservation`
--

DROP TABLE IF EXISTS `listes_accompagnateurs_reservation`;
CREATE TABLE IF NOT EXISTS `listes_accompagnateurs_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) NOT NULL,
  `num_chambre` int(11) NOT NULL,
  `num_acc` int(11) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `num_res` (`num_res`),
  KEY `num_acc` (`num_acc`),
  KEY `liste_accompagnateurs_reservations_num_chambre` (`num_chambre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `listes_accompagnateurs_reservation`
--

INSERT INTO `listes_accompagnateurs_reservation` (`id`, `num_res`, `num_chambre`, `num_acc`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(3, 'SLC-1-23', 3, 1, 1, 0, '2023-12-04 15:00:18', NULL),
(4, 'SLC-1-23', 2, 2, 1, 0, '2023-12-04 15:00:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_clt` int(11) NOT NULL,
  `type_sujet` varchar(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plantes _utilisateur_id` (`num_clt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prix_chambres`
--

DROP TABLE IF EXISTS `prix_chambres`;
CREATE TABLE IF NOT EXISTS `prix_chambres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_chambre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `montant` int(11) NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `cod_repas` int(11) NOT NULL,
  `num_cmd` int(11) NOT NULL,
  `num_chambre` int(11) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  KEY `quantite_chambre _num_chambre` (`num_chambre`),
  KEY `quantite_commande _num_cmd` (`num_cmd`),
  KEY `quantite_repas_cod_repas` (`cod_repas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

DROP TABLE IF EXISTS `repas`;
CREATE TABLE IF NOT EXISTS `repas` (
  `cod_repas` int(11) NOT NULL AUTO_INCREMENT,
  `nom_repas` varchar(255) NOT NULL,
  `pu_repas` int(11) NOT NULL,
  `photos` varchar(255) DEFAULT 'Aucune image',
  `details` varchar(2000) DEFAULT 'Aucune information ',
  `est_actif` tinyint(4) NOT NULL DEFAULT '0',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cod_repas`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `repas`
--

INSERT INTO `repas` (`cod_repas`, `nom_repas`, `pu_repas`, `photos`, `details`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'Attiéké', 3500, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:03:58', NULL),
(2, 'Baril de pain', 4250, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:05:04', NULL),
(3, 'Gâtaeu au Crabe', 5000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:05:32', NULL),
(4, 'Selection de caesar', 5500, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:05:53', NULL),
(5, 'Grillarde Toscanes', 6200, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:06:17', NULL),
(6, 'Baton de Mozzarella', 3000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:07:01', NULL),
(7, 'Salade Grecque', 4200, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:07:30', NULL),
(8, 'Salade d\'épinards', 3000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:07:41', NULL),
(9, 'Rouleau de homard', 8000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:08:08', NULL),
(10, 'Riz Frit avec Côtelettes de Poulet aux Œufs Salés', 3000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:08:40', NULL),
(11, 'Les Nouilles', 2500, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:09:14', NULL),
(12, 'Plat de fruits', 4500, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:09:35', NULL),
(13, 'Dîner de Noël', 2000, 'no_image', 'Aucune information ', 1, 0, '2023-09-22 16:25:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) NOT NULL,
  `num_clt` int(11) NOT NULL,
  `prix_total` int(11) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_utilisateur_id` (`num_clt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `num_res`, `num_clt`, `prix_total`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'SLC-1-23', 1, 145000, 1, 0, '2023-12-04 15:00:02', '2023-12-04 15:00:18');

-- --------------------------------------------------------

--
-- Structure de la table `reservation_chambres`
--

DROP TABLE IF EXISTS `reservation_chambres`;
CREATE TABLE IF NOT EXISTS `reservation_chambres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_res` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_chambre` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `deb_occ` datetime NOT NULL,
  `fin_occ` datetime NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservation_chambres`
--

INSERT INTO `reservation_chambres` (`id`, `num_res`, `num_chambre`, `montant`, `deb_occ`, `fin_occ`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(3, 'SLC-1-23', 3, 70000, '2023-12-04 16:00:18', '2023-12-05 16:00:18', 1, 0, '2023-12-04 15:00:18', NULL),
(4, 'SLC-1-23', 2, 75000, '2023-12-12 16:00:18', '2023-12-14 16:00:18', 1, 0, '2023-12-04 15:00:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `est_actif` tinyint(4) NOT NULL DEFAULT '1',
  `est_supprimer` tinyint(4) DEFAULT '0',
  `créer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `sexe`, `telephone`, `email`, `nom_utilisateur`, `avatar`, `profil`, `mot_passe`, `est_actif`, `est_supprimer`, `creer_le`, `maj_le`) VALUES
(1, 'BESSAN', 'Fr&eacute;jus', NULL, NULL, 'frejusbessan@gmail.com', 'jow', 'Aucune_image', 'CLIENT', '940bc542597dee4c3d1df4353e92e8428a109202', 1, 0, '2023-12-01 21:01:25', '2023-12-01 20:07:47');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_reservations_num_res` FOREIGN KEY (`num_res`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `listes_accompagnateurs_reservation`
--
ALTER TABLE `listes_accompagnateurs_reservation`
  ADD CONSTRAINT `liste_accompagnateurs_reservations_num_acc` FOREIGN KEY (`num_acc`) REFERENCES `accompagnateur` (`num_acc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `liste_accompagnateurs_reservations_num_chambre` FOREIGN KEY (`num_chambre`) REFERENCES `chambre` (`num_chambre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `plantes _utilisateur_id` FOREIGN KEY (`num_clt`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
