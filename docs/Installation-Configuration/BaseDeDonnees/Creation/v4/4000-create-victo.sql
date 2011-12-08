-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 08 Décembre 2011 à 14:32
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `ApplicationVar`
--

DROP TABLE IF EXISTS `ApplicationVar`;
CREATE TABLE IF NOT EXISTS `ApplicationVar` (
  `var` varchar(500) NOT NULL,
  `id` varchar(25) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 08 Décembre 2011 à 14:43
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Constructeur`
--

DROP TABLE IF EXISTS `Constructeur`;
CREATE TABLE IF NOT EXISTS `Constructeur` (
  `noConstructeur` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  `noAdresse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noConstructeur`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant le constructeur' AUTO_INCREMENT=27 ;

--
-- Contenu de la table `Constructeur`
--

INSERT INTO `Constructeur` (`noConstructeur`, `label`, `noAdresse`) VALUES
(1, 'AirBus', 1),
(2, 'Boeing', 2),
(21, 'Bombardier', 1),
(22, 'Cessna', 1),
(23, 'Dassault Aviation', 1),
(24, 'Dassault Falcon', 1),
(25, 'Eclipse Aerospace', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 08 Décembre 2011 à 14:45
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Modele`
--

DROP TABLE IF EXISTS `Modele`;
CREATE TABLE IF NOT EXISTS `Modele` (
  `noModele` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL COMMENT '- Appelation du modele\n- PK',
  `rayonAction` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- rayon d''action max du modele\n(en KM) > Avec un plein de kerozen et de passagers',
  `distMinAtt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- Longueur de la piste minimum pour l''atterissage\nen M',
  `distMinDec` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- - Longueur de la piste minimum pour le decollage\nen M',
  `dateLancement` year(4) NOT NULL COMMENT '- Année de lancement du model',
  `noConstructeur` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noModele`),
  UNIQUE KEY `label_UNIQUE` (`label`),
  KEY `fk_Modele_Constructeur1` (`noConstructeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant un modèle d''avion, lié à un constructeur,' AUTO_INCREMENT=36 ;

--
-- Contenu de la table `Modele`
--

INSERT INTO `Modele` (`noModele`, `label`, `rayonAction`, `distMinAtt`, `distMinDec`, `dateLancement`, `noConstructeur`) VALUES
(3, '737-100', 3300, 2000, 3000, 2010, 2),
(4, '747', 3300, 2000, 3000, 2010, 2),
(5, '767', 3300, 2000, 3000, 2010, 2),
(6, '777', 3300, 2000, 3000, 2010, 2),
(7, '787 Dreamliner', 3300, 2000, 3000, 2010, 2),
(8, 'CSeries', 3300, 2000, 3000, 2010, 21),
(9, 'CRJ NextGen', 3300, 2000, 3000, 2010, 21),
(10, 'Q400 NextGen', 3300, 2000, 3000, 2010, 21),
(11, 'LearJet', 3300, 2000, 3000, 2010, 21),
(12, 'Challenger', 3300, 2000, 3000, 2010, 21),
(13, 'Global', 3300, 2000, 3000, 2010, 21),
(14, 'ACJ318', 3300, 2000, 3000, 2010, 1),
(15, 'ACJ330', 3300, 2000, 3000, 2010, 1),
(16, 'Corporate Jet Centre', 3300, 2000, 3000, 2010, 1),
(17, 'A330-200F', 3300, 2000, 3000, 2010, 1),
(18, 'A380F', 3300, 2000, 3000, 2010, 1),
(19, 'Beluga', 3300, 2000, 3000, 2010, 1),
(20, 'A320', 3300, 2000, 3000, 2010, 1),
(21, 'A330', 3300, 2000, 3000, 2010, 1),
(22, 'A340', 3300, 2000, 3000, 2010, 1),
(23, 'A350', 3300, 2000, 3000, 2010, 1),
(24, 'A380', 3300, 2000, 3000, 2010, 1),
(25, 'CJ2', 3300, 2000, 3000, 2010, 22),
(26, 'CJ3', 3300, 2000, 3000, 2010, 22),
(27, 'Sovereign', 3300, 2000, 3000, 2010, 22),
(28, 'XLS', 3300, 2000, 3000, 2010, 21),
(29, 'Falcon 7X', 3300, 2000, 3000, 2010, 24),
(30, 'Falcon 900LX', 3300, 2000, 3000, 2010, 24),
(31, 'Falcon 900EX', 3300, 2000, 3000, 2010, 24),
(32, 'Falcon 2000LX', 3300, 2000, 3000, 2010, 24),
(33, 'Falcon 2000S', 3300, 2000, 3000, 2010, 24),
(34, 'The Eclipse 550', 3300, 2000, 3000, 2010, 25),
(35, 'Total Eclipse', 3300, 2000, 3000, 2010, 25);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Modele`
--
ALTER TABLE `Modele`
  ADD CONSTRAINT `fk_Modele_Constructeur1` FOREIGN KEY (`noConstructeur`) REFERENCES `Constructeur` (`noConstructeur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 08 Décembre 2011 à 14:45
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Modele`
--

DROP TABLE IF EXISTS `Modele`;
CREATE TABLE IF NOT EXISTS `Modele` (
  `noModele` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL COMMENT '- Appelation du modele\n- PK',
  `rayonAction` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- rayon d''action max du modele\n(en KM) > Avec un plein de kerozen et de passagers',
  `distMinAtt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- Longueur de la piste minimum pour l''atterissage\nen M',
  `distMinDec` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- - Longueur de la piste minimum pour le decollage\nen M',
  `dateLancement` year(4) NOT NULL COMMENT '- Année de lancement du model',
  `noConstructeur` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noModele`),
  UNIQUE KEY `label_UNIQUE` (`label`),
  KEY `fk_Modele_Constructeur1` (`noConstructeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant un modèle d''avion, lié à un constructeur,' AUTO_INCREMENT=36 ;

--
-- Contenu de la table `Modele`
--

INSERT INTO `Modele` (`noModele`, `label`, `rayonAction`, `distMinAtt`, `distMinDec`, `dateLancement`, `noConstructeur`) VALUES
(3, '737-100', 3300, 2000, 3000, 2010, 2),
(4, '747', 3300, 2000, 3000, 2010, 2),
(5, '767', 3300, 2000, 3000, 2010, 2),
(6, '777', 3300, 2000, 3000, 2010, 2),
(7, '787 Dreamliner', 3300, 2000, 3000, 2010, 2),
(8, 'CSeries', 3300, 2000, 3000, 2010, 21),
(9, 'CRJ NextGen', 3300, 2000, 3000, 2010, 21),
(10, 'Q400 NextGen', 3300, 2000, 3000, 2010, 21),
(11, 'LearJet', 3300, 2000, 3000, 2010, 21),
(12, 'Challenger', 3300, 2000, 3000, 2010, 21),
(13, 'Global', 3300, 2000, 3000, 2010, 21),
(14, 'ACJ318', 3300, 2000, 3000, 2010, 1),
(15, 'ACJ330', 3300, 2000, 3000, 2010, 1),
(16, 'Corporate Jet Centre', 3300, 2000, 3000, 2010, 1),
(17, 'A330-200F', 3300, 2000, 3000, 2010, 1),
(18, 'A380F', 3300, 2000, 3000, 2010, 1),
(19, 'Beluga', 3300, 2000, 3000, 2010, 1),
(20, 'A320', 3300, 2000, 3000, 2010, 1),
(21, 'A330', 3300, 2000, 3000, 2010, 1),
(22, 'A340', 3300, 2000, 3000, 2010, 1),
(23, 'A350', 3300, 2000, 3000, 2010, 1),
(24, 'A380', 3300, 2000, 3000, 2010, 1),
(25, 'CJ2', 3300, 2000, 3000, 2010, 22),
(26, 'CJ3', 3300, 2000, 3000, 2010, 22),
(27, 'Sovereign', 3300, 2000, 3000, 2010, 22),
(28, 'XLS', 3300, 2000, 3000, 2010, 21),
(29, 'Falcon 7X', 3300, 2000, 3000, 2010, 24),
(30, 'Falcon 900LX', 3300, 2000, 3000, 2010, 24),
(31, 'Falcon 900EX', 3300, 2000, 3000, 2010, 24),
(32, 'Falcon 2000LX', 3300, 2000, 3000, 2010, 24),
(33, 'Falcon 2000S', 3300, 2000, 3000, 2010, 24),
(34, 'The Eclipse 550', 3300, 2000, 3000, 2010, 25),
(35, 'Total Eclipse', 3300, 2000, 3000, 2010, 25);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Modele`
--
ALTER TABLE `Modele`
  ADD CONSTRAINT `fk_Modele_Constructeur1` FOREIGN KEY (`noConstructeur`) REFERENCES `Constructeur` (`noConstructeur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Jeu 08 Décembre 2011 à 14:43
-- Version du serveur: 5.1.58
-- Version de PHP: 5.3.6-13ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_Airlines`
--

-- --------------------------------------------------------

--
-- Structure de la table `Vol`
--

DROP TABLE IF EXISTS `Vol`;
CREATE TABLE IF NOT EXISTS `Vol` (
  `noVol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etat` int(11) NOT NULL DEFAULT '0',
  `labelvol` varchar(45) NOT NULL,
  `noAeroportAtte` int(11) NOT NULL,
  `noAeroportDeco` int(11) NOT NULL,
  `noAvion` int(10) unsigned DEFAULT NULL,
  `noLigne` int(10) unsigned DEFAULT NULL,
  `heureDecollage` datetime NOT NULL,
  `heureAtterissage` datetime NOT NULL,
  PRIMARY KEY (`noVol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Vol`
--

INSERT INTO `Vol` (`noVol`, `etat`, `labelvol`, `noAeroportAtte`, `noAeroportDeco`, `noAvion`, `noLigne`, `heureDecollage`, `heureAtterissage`) VALUES
(3, 0, 'TestFOrCalc', 2, 3, 5, NULL, '2011-12-08 08:22:00', '2011-12-08 12:00:00'),
(4, 0, 'TestFOrCalc 1', 13, 2, 5, NULL, '2011-12-08 23:00:00', '2011-12-09 04:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
