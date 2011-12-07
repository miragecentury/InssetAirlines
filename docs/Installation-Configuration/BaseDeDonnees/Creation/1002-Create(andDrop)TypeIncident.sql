-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 06 Décembre 2011 à 17:43
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `TypeIncident`
--

DROP TABLE IF EXISTS `TypeIncident`;
CREATE TABLE IF NOT EXISTS `TypeIncident` (
  `idTypeIncident` int(11) NOT NULL AUTO_INCREMENT,
  `labelTypeIncident` varchar(45) NOT NULL,
  `dureeTypeIncident` int(11) NOT NULL,
  PRIMARY KEY (`idTypeIncident`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `TypeIncident`
--

INSERT INTO `TypeIncident` (`idTypeIncident`, `labelTypeIncident`, `dureeTypeIncident`) VALUES
(7, 'Maladie', 0),
(15, 'Intemperie', 1),
(16, 'Panne Mecanique', 1);
