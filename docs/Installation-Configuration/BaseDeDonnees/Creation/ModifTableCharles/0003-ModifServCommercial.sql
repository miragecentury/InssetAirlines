-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 28 Novembre 2011 à 09:48
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Agence`
--

DROP TABLE IF EXISTS `Agence`;
CREATE TABLE IF NOT EXISTS `Agence` (
  `noAgence` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelAgence` varchar(45) NOT NULL,
  `dateLancement` date NOT NULL,
  `dateCloture` date DEFAULT NULL,
  `accesExtranet` tinyint(1) NOT NULL DEFAULT '0',
  `noAdresse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noAgence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `Agence`
--

INSERT INTO `Agence` (`noAgence`, `labelAgence`, `dateLancement`, `dateCloture`, `accesExtranet`, `noAdresse`) VALUES
(5, 'ThomasCook', '2005-12-05', NULL, 1, 5),
(6, 'dsf', '0000-00-00', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Place`
--

DROP TABLE IF EXISTS `Place`;
CREATE TABLE IF NOT EXISTS `Place` (
  `noPlace` int(11) NOT NULL AUTO_INCREMENT,
  `noAgence` int(10) unsigned NOT NULL,
  `Personne_noPersonne` int(10) unsigned NOT NULL,
  `noVol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noPlace`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `Place`
--

INSERT INTO `Place` (`noPlace`, `noAgence`, `Personne_noPersonne`, `noVol`) VALUES
(10, 5, 1, 2),
(11, 5, 0, 0),
(12, 6, 0, 0),
(13, 6, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Vol_has_Agence`
--

DROP TABLE IF EXISTS `Vol_has_Agence`;
CREATE TABLE IF NOT EXISTS `Vol_has_Agence` (
  `Vol_noVol` int(10) unsigned NOT NULL,
  `Agence_noAgence` int(10) unsigned NOT NULL,
  `nbReservation` int(10) unsigned NOT NULL,
  `enAttentedeTraitement` tinyint(1) NOT NULL DEFAULT '1',
  `valider` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Vol_noVol`,`Agence_noAgence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Vol_has_Agence`
--

INSERT INTO `Vol_has_Agence` (`Vol_noVol`, `Agence_noAgence`, `nbReservation`, `enAttentedeTraitement`, `valider`) VALUES
(1, 10, 98, 1, 0);
