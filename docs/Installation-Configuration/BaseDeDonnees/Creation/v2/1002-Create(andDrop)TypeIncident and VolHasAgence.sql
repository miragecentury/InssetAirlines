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

-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 07 Décembre 2011 à 15:23
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Vol_has_Agence`
--

DROP TABLE IF EXISTS `Vol_has_Agence`;
CREATE TABLE IF NOT EXISTS `Vol_has_Agence` (
  `idVolHasAgence` int(11) NOT NULL AUTO_INCREMENT,
  `Vol_noVol` int(10) unsigned NOT NULL,
  `Agence_noAgence` int(10) unsigned NOT NULL,
  `nbReservation` int(10) unsigned NOT NULL,
  `enAttentedeTraitement` tinyint(1) NOT NULL DEFAULT '1',
  `valider` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVolHasAgence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Vol_has_Agence`
--

INSERT INTO `Vol_has_Agence` (`idVolHasAgence`, `Vol_noVol`, `Agence_noAgence`, `nbReservation`, `enAttentedeTraitement`, `valider`) VALUES
(3, 1, 9, 15, 1, 1),
(4, 1, 9, 10, 0, 0);
