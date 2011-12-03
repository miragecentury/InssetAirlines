-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 28 Novembre 2011 à 09:47
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `CommandeNourriture`
--

DROP TABLE IF EXISTS `CommandeNourriture`;
CREATE TABLE IF NOT EXISTS `CommandeNourriture` (
  `noCommandeNourriture` int(11) NOT NULL AUTO_INCREMENT,
  `dateLivraison` date NOT NULL,
  `dateCommande` date NOT NULL,
  `idAeroportLivraison` int(11) NOT NULL,
  PRIMARY KEY (`noCommandeNourriture`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `CommandeNourriture`
--

INSERT INTO `CommandeNourriture` (`noCommandeNourriture`, `dateLivraison`, `dateCommande`, `idAeroportLivraison`) VALUES
(2, '0000-00-00', '0000-00-00', 1),
(4, '0000-00-00', '0000-00-01', 2),
(5, '0000-00-00', '0000-00-02', 2),
(6, '0000-00-00', '0000-00-05', 1),
(7, '0000-00-00', '0000-00-09', 2),
(8, '0000-00-00', '0000-00-00', 3);

-- --------------------------------------------------------

--
-- Structure de la table `Menu`
--

DROP TABLE IF EXISTS `Menu`;
CREATE TABLE IF NOT EXISTS `Menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `labelMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Menu`
--

INSERT INTO `Menu` (`idMenu`, `labelMenu`) VALUES
(5, 'Vegetarien');

-- --------------------------------------------------------

--
-- Structure de la table `RegimeAlimentaire`
--

DROP TABLE IF EXISTS `RegimeAlimentaire`;
CREATE TABLE IF NOT EXISTS `RegimeAlimentaire` (
  `noRegimeAlimentaire` int(11) NOT NULL AUTO_INCREMENT,
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  PRIMARY KEY (`noRegimeAlimentaire`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `RegimeAlimentaire`
--

INSERT INTO `RegimeAlimentaire` (`noRegimeAlimentaire`, `labelRegimeAlimentaire`) VALUES
(5, 'dfgdsf'),
(7, 'dgfg');
