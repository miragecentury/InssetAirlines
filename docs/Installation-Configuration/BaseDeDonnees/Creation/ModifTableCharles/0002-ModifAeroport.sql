-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 28 Novembre 2011 à 09:45
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Aeroport`
--

DROP TABLE IF EXISTS `Aeroport`;
CREATE TABLE IF NOT EXISTS `Aeroport` (
  `noAeroport` int(11) NOT NULL AUTO_INCREMENT,
  `labelAeroport` varchar(45) NOT NULL,
  `labelVille` varchar(50) NOT NULL,
  `labelPays` varchar(45) NOT NULL,
  PRIMARY KEY (`noAeroport`),
  KEY `noAeroport` (`noAeroport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Aeroport`
--

INSERT INTO `Aeroport` (`noAeroport`, `labelAeroport`, `labelVille`, `labelPays`) VALUES
(2, 'Madrid-Barajas', 'Madrid', 'Espagne'),
(3, 'Roissy', 'Paris', 'France'),
(4, 'JFK', 'New York', 'USA');
