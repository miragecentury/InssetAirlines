-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 07 Décembre 2011 à 18:13
-- Version du serveur: 5.1.54
-- Version de PHP: 5.3.5-1ubuntu7.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_AirlinesV3`
--

-- --------------------------------------------------------

--
-- Structure de la table `Avion`
--

DROP TABLE IF EXISTS `Avion`;
CREATE TABLE IF NOT EXISTS `Avion` (
  `noAvion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nbPlaceMax` int(10) unsigned NOT NULL COMMENT '- Nombre de place maximum, fixÃ© Ã  la mise en service de l''avion.',
  `nbHeureVol` float unsigned NOT NULL DEFAULT '0' COMMENT '- nombre d''heure total de l''avion\n- Alimente la gestion des maintenance\n- Est alimentÃ© par l''objet vol (temps de vol)',
  `calcDate` datetime NOT NULL,
  `nbIncident` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- IncrÃ©menter Ã  chaque incident.\n- AlimentÃ© par le service d''exploitation\n',
  `label` varchar(25) NOT NULL COMMENT '- Nom de l''appareil visible ',
  `dateMiseService` datetime NOT NULL COMMENT '- RenseignÃ© par le service maintenance lors de la mise en service de l''avion',
  `dateHorsService` datetime DEFAULT NULL COMMENT '- date previsionnelle de mise hors service de l''appareil',
  `enService` tinyint(1) NOT NULL DEFAULT '1' COMMENT '- simplifie la recherche d''appareil en service\n(optimisation) \n- peut etre remplacÃ© par un conditionnel sur la date de mise hors service.',
  `noModele` int(11) unsigned NOT NULL COMMENT '- FK- Model de l''avion',
  PRIMARY KEY (`noAvion`),
  UNIQUE KEY `noAvion_UNIQUE` (`noAvion`),
  UNIQUE KEY `label_UNIQUE` (`label`),
  KEY `noModele` (`noModele`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet reprÃ©sentant un avion, avec un modÃ¨le prÃ©cis\n\nSuges' AUTO_INCREMENT=1 ;
