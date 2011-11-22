-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 21 Novembre 2011 à 09:47
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
-- Structure de la table `Adresse`
--

DROP TABLE IF EXISTS `Adresse`;
CREATE TABLE IF NOT EXISTS `Adresse` (
  `noAdresse` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) NOT NULL,
  `porte` varchar(45) DEFAULT NULL COMMENT '				',
  `adresse` varchar(200) NOT NULL,
  `etage` varchar(45) DEFAULT NULL,
  `immeuble` varchar(45) DEFAULT NULL,
  `commentaire` varchar(200) DEFAULT NULL,
  `codepostal` varchar(45) DEFAULT NULL,
  `etatProvince` varchar(50) DEFAULT NULL,
  `labelVille` varchar(50) NOT NULL,
  `labelPays` varchar(45) NOT NULL,
  PRIMARY KEY (`noAdresse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `Agence_has_Telephone`
--

DROP TABLE IF EXISTS `Agence_has_Telephone`;
CREATE TABLE IF NOT EXISTS `Agence_has_Telephone` (
  `Agence_noAgence` int(10) unsigned NOT NULL,
  `Telephone_noTelephone` int(10) unsigned NOT NULL,
  `LabelTelephone_label` varchar(50) NOT NULL,
  PRIMARY KEY (`Agence_noAgence`,`Telephone_noTelephone`,`LabelTelephone_label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Annee_Exploitation`
--

DROP TABLE IF EXISTS `Annee_Exploitation`;
CREATE TABLE IF NOT EXISTS `Annee_Exploitation` (
  `idAnnee` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idAnnee`),
  KEY `idAnnee` (`idAnnee`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `Avion`
--

DROP TABLE IF EXISTS `Avion`;
CREATE TABLE IF NOT EXISTS `Avion` (
  `noAvion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nbPlaceMax` int(10) unsigned NOT NULL COMMENT '- Nombre de place maximum, fixé à la mise en service de l''avion.',
  `nbHeureVol` float unsigned NOT NULL DEFAULT '0' COMMENT '- nombre d''heure total de l''avion\n- Alimente la gestion des maintenance\n- Est alimenté par l''objet vol (temps de vol)',
  `nbIncident` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- Incrémenter à chaque incident.\n- Alimenté par le service d''exploitation\n',
  `label` varchar(25) NOT NULL COMMENT '- Nom de l''appareil visible ',
  `dateMiseService` datetime NOT NULL COMMENT '- Renseigné par le service maintenance lors de la mise en service de l''avion',
  `dateHorsService` datetime DEFAULT NULL COMMENT '- date previsionnelle de mise hors service de l''appareil',
  `enService` tinyint(1) NOT NULL DEFAULT '1' COMMENT '- simplifie la recherche d''appareil en service\n(optimisation) \n- peut etre remplacé par un conditionnel sur la date de mise hors service.',
  `labelModele` varchar(25) NOT NULL COMMENT '- FK\n- Model de l''avion',
  PRIMARY KEY (`noAvion`),
  UNIQUE KEY `noAvion_UNIQUE` (`noAvion`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet représentant un avion, avec un modèle précis\n\nSugestio' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `CommandeNourriture`
--

DROP TABLE IF EXISTS `CommandeNourriture`;
CREATE TABLE IF NOT EXISTS `CommandeNourriture` (
  `noCommandeNourriture` int(11) NOT NULL,
  `dateLivraison` date NOT NULL,
  `dateCommande` date NOT NULL,
  `labelAeroportLivraison` varchar(45) NOT NULL,
  PRIMARY KEY (`noCommandeNourriture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Conge`
--

DROP TABLE IF EXISTS `Conge`;
CREATE TABLE IF NOT EXISTS `Conge` (
  `noConge` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `valider` tinyint(1) NOT NULL DEFAULT '0',
  `enAttentedeTraitement` tinyint(1) NOT NULL DEFAULT '1',
  `motif` varchar(200) NOT NULL,
  `labelTypeConge` varchar(45) NOT NULL,
  `noPersonne` int(10) unsigned NOT NULL,
  `dateDebut_Annee` date NOT NULL,
  PRIMARY KEY (`noConge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Constructeur`
--

DROP TABLE IF EXISTS `Constructeur`;
CREATE TABLE IF NOT EXISTS `Constructeur` (
  `idConstructeur` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  `noAdresse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idConstructeur`),
  KEY `idConstructeur` (`idConstructeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant le constructeur' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `DemandeLigne`
--

DROP TABLE IF EXISTS `DemandeLigne`;
CREATE TABLE IF NOT EXISTS `DemandeLigne` (
  `noDemandeLigne` int(11) NOT NULL,
  `labelAeroportDeco` varchar(45) NOT NULL,
  `labelAeroportAtte` varchar(45) NOT NULL,
  `Motif` varchar(500) NOT NULL,
  PRIMARY KEY (`noDemandeLigne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Employe`
--

DROP TABLE IF EXISTS `Employe`;
CREATE TABLE IF NOT EXISTS `Employe` (
  `Personne_noPersonne` int(10) unsigned NOT NULL,
  `labelMetier` varchar(45) NOT NULL,
  PRIMARY KEY (`Personne_noPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Employe_has_Annee_Exploitation`
--

DROP TABLE IF EXISTS `Employe_has_Annee_Exploitation`;
CREATE TABLE IF NOT EXISTS `Employe_has_Annee_Exploitation` (
  `Employe_Personne_noPersonne` int(10) unsigned NOT NULL,
  `Annee_Exploitation_dateDebut` date NOT NULL,
  PRIMARY KEY (`Employe_Personne_noPersonne`,`Annee_Exploitation_dateDebut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EnVol`
--

DROP TABLE IF EXISTS `EnVol`;
CREATE TABLE IF NOT EXISTS `EnVol` (
  `noVol` int(10) unsigned NOT NULL,
  `noEmploye` int(10) unsigned NOT NULL,
  `equipageSecours` tinyint(1) NOT NULL DEFAULT '0',
  `heureStart` datetime NOT NULL,
  `heureEnd` datetime DEFAULT NULL,
  PRIMARY KEY (`noVol`,`noEmploye`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EstCommande`
--

DROP TABLE IF EXISTS `EstCommande`;
CREATE TABLE IF NOT EXISTS `EstCommande` (
  `labelMenu` varchar(45) NOT NULL,
  `noCommandeNourriture` int(11) NOT NULL,
  PRIMARY KEY (`labelMenu`,`noCommandeNourriture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EtudeMarche`
--

DROP TABLE IF EXISTS `EtudeMarche`;
CREATE TABLE IF NOT EXISTS `EtudeMarche` (
  `noEtudeMarche` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelTypeEtudeMarche` varchar(45) NOT NULL,
  `Ligne_noLigne` int(10) unsigned NOT NULL,
  `noDemandeLigne` int(11) NOT NULL,
  PRIMARY KEY (`noEtudeMarche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Habilitation`
--

DROP TABLE IF EXISTS `Habilitation`;
CREATE TABLE IF NOT EXISTS `Habilitation` (
  `noHabilitation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelHabilitation` varchar(45) NOT NULL,
  `labelMetier` varchar(45) NOT NULL,
  `Modele_label` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`noHabilitation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `Incident`
--

DROP TABLE IF EXISTS `Incident`;
CREATE TABLE IF NOT EXISTS `Incident` (
  `noIncident` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateIncident` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `labelAeroportArriNextIncident` varchar(45) NOT NULL,
  `noVol` int(10) unsigned NOT NULL,
  `labelTypeIncident` varchar(45) NOT NULL,
  PRIMARY KEY (`noIncident`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Structure de la table `Incompatible`
--

DROP TABLE IF EXISTS `Incompatible`;
CREATE TABLE IF NOT EXISTS `Incompatible` (
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  `labelMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`labelRegimeAlimentaire`,`labelMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `LabelTelephone`
--

DROP TABLE IF EXISTS `LabelTelephone`;
CREATE TABLE IF NOT EXISTS `LabelTelephone` (
  `noLabel` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`noLabel`),
  KEY `noLabel` (`noLabel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `Ligne`
--

DROP TABLE IF EXISTS `Ligne`;
CREATE TABLE IF NOT EXISTS `Ligne` (
  `noLigne` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jours` int(11) DEFAULT NULL,
  `semaines` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annees` int(11) DEFAULT NULL,
  `labelAeroportDeco` varchar(45) NOT NULL,
  `labelAeroportAtte` varchar(45) NOT NULL,
  PRIMARY KEY (`noLigne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `Menu`
--

DROP TABLE IF EXISTS `Menu`;
CREATE TABLE IF NOT EXISTS `Menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `labelMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Metier`
--

DROP TABLE IF EXISTS `Metier`;
CREATE TABLE IF NOT EXISTS `Metier` (
  `idMetier` int(11) NOT NULL AUTO_INCREMENT,
  `labelMetier` varchar(45) NOT NULL,
  PRIMARY KEY (`idMetier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `Modele`
--

DROP TABLE IF EXISTS `Modele`;
CREATE TABLE IF NOT EXISTS `Modele` (
  `idModele` int(11) NOT NULL,
  `label` varchar(25) NOT NULL COMMENT '- Appelation du modele\n- PK',
  `rayonAction` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- rayon d''action max du modele\n(en KM) > Avec un plein de kerozen et de passagers',
  `distMinAtt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- Longueur de la piste minimum pour l''atterissage\nen M',
  `distMinDec` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- - Longueur de la piste minimum pour le decollage\nen M',
  `dateLancement` year(4) NOT NULL COMMENT '- Année de lancement du model',
  `labelConstructeur` varchar(25) NOT NULL COMMENT '- FK\n- Constructeur du modele'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet representant un modèle d''avion, lié à un constructeur,';

-- --------------------------------------------------------

--
-- Structure de la table `Pays`
--

DROP TABLE IF EXISTS `Pays`;
CREATE TABLE IF NOT EXISTS `Pays` (
  `noPays` int(11) NOT NULL AUTO_INCREMENT,
  `labelPays` varchar(45) NOT NULL,
  `localize` varchar(2) NOT NULL COMMENT 'fr,...',
  PRIMARY KEY (`noPays`),
  KEY `noPays` (`noPays`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

DROP TABLE IF EXISTS `Personne`;
CREATE TABLE IF NOT EXISTS `Personne` (
  `noPersonne` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `prenom2` varchar(45) DEFAULT NULL,
  `prenom3` varchar(45) DEFAULT NULL,
  `dateNaissance` date NOT NULL,
  `responsableLegal` int(11) DEFAULT NULL,
  `noINSEE` int(11) NOT NULL,
  `noAdresse` int(10) unsigned NOT NULL,
  `labelPays` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` varchar(45) NOT NULL DEFAULT 'Inv',
  `password` varchar(32) NOT NULL,
  `password_salt` varchar(32) NOT NULL,
  PRIMARY KEY (`noPersonne`),
  UNIQUE KEY `noPersonne_UNIQUE` (`noPersonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Structure de la table `Personne_has_RegimeAlimentaire`
--

DROP TABLE IF EXISTS `Personne_has_RegimeAlimentaire`;
CREATE TABLE IF NOT EXISTS `Personne_has_RegimeAlimentaire` (
  `noPersonne` int(10) unsigned NOT NULL,
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  PRIMARY KEY (`noPersonne`,`labelRegimeAlimentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Personne_has_Telephone`
--

DROP TABLE IF EXISTS `Personne_has_Telephone`;
CREATE TABLE IF NOT EXISTS `Personne_has_Telephone` (
  `noPersonne` int(10) unsigned NOT NULL,
  `noTelephone` int(10) unsigned NOT NULL,
  `labelTelephone` varchar(50) NOT NULL,
  PRIMARY KEY (`noPersonne`,`noTelephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Place`
--

DROP TABLE IF EXISTS `Place`;
CREATE TABLE IF NOT EXISTS `Place` (
  `noPlace` int(11) NOT NULL,
  `noAgence` int(10) unsigned NOT NULL,
  `Personne_noPersonne` int(10) unsigned NOT NULL,
  `noVol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noPlace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Qualification`
--

DROP TABLE IF EXISTS `Qualification`;
CREATE TABLE IF NOT EXISTS `Qualification` (
  `Employe_Personne_noPersonne` int(10) unsigned NOT NULL,
  `Habilitation_noHabilitation` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Employe_Personne_noPersonne`,`Habilitation_noHabilitation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `RegimeAlimentaire`
--

DROP TABLE IF EXISTS `RegimeAlimentaire`;
CREATE TABLE IF NOT EXISTS `RegimeAlimentaire` (
  `noRegimeAlimentaire` int(11) NOT NULL,
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  PRIMARY KEY (`noRegimeAlimentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TacheMaintenance`
--

DROP TABLE IF EXISTS `TacheMaintenance`;
CREATE TABLE IF NOT EXISTS `TacheMaintenance` (
  `noMaintenance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateDebut` datetime NOT NULL COMMENT '- Fixée par le service maintenance',
  `dateFin` datetime NOT NULL COMMENT '- Générer automatiquement par le type de maintenance',
  `retard` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- le retard est en heure\n- le retard se rajoute à la date de fin\n(fixée à la base par le type de \nmaintenance)\n',
  `labelTypeMaintenance` varchar(25) NOT NULL COMMENT '- FK\n- Specifie le type de maintenance',
  `noAvion` int(10) unsigned NOT NULL COMMENT '- FK\n- Avion sujet de la maintenance',
  PRIMARY KEY (`noMaintenance`),
  UNIQUE KEY `noMaintenance_UNIQUE` (`noMaintenance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet représentant une tache de maintenance, sur un avion av' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Telephone`
--

DROP TABLE IF EXISTS `Telephone`;
CREATE TABLE IF NOT EXISTS `Telephone` (
  `noTelephone` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numTelephone` varchar(45) NOT NULL,
  PRIMARY KEY (`noTelephone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Structure de la table `Telephone_has_Aeroport`
--

DROP TABLE IF EXISTS `Telephone_has_Aeroport`;
CREATE TABLE IF NOT EXISTS `Telephone_has_Aeroport` (
  `Telephone_noTelephone` int(10) unsigned NOT NULL,
  `Aeroport_labelAeroport` varchar(45) NOT NULL,
  `LabelTelephone_label` varchar(50) NOT NULL,
  PRIMARY KEY (`Telephone_noTelephone`,`Aeroport_labelAeroport`,`LabelTelephone_label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Telephone_has_Constructeur`
--

DROP TABLE IF EXISTS `Telephone_has_Constructeur`;
CREATE TABLE IF NOT EXISTS `Telephone_has_Constructeur` (
  `noTelephone` int(10) unsigned NOT NULL,
  `labelConstructeur` varchar(25) NOT NULL,
  `labelTelephone` varchar(50) NOT NULL,
  PRIMARY KEY (`noTelephone`,`labelConstructeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TypeConge`
--

DROP TABLE IF EXISTS `TypeConge`;
CREATE TABLE IF NOT EXISTS `TypeConge` (
  `labelTypeConge` varchar(45) NOT NULL,
  PRIMARY KEY (`labelTypeConge`),
  UNIQUE KEY `labelTypeConge_UNIQUE` (`labelTypeConge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TypeEtudeMarche`
--

DROP TABLE IF EXISTS `TypeEtudeMarche`;
CREATE TABLE IF NOT EXISTS `TypeEtudeMarche` (
  `idTypeEtudeMarche` int(11) NOT NULL AUTO_INCREMENT,
  `labelTypeEtudeMarche` varchar(45) NOT NULL,
  PRIMARY KEY (`idTypeEtudeMarche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `TypeIncident`
--

DROP TABLE IF EXISTS `TypeIncident`;
CREATE TABLE IF NOT EXISTS `TypeIncident` (
  `idTypeIncident` int(11) NOT NULL AUTO_INCREMENT,
  `labelTypeIncident` varchar(45) NOT NULL,
  PRIMARY KEY (`idTypeIncident`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `TypeMaintenance`
--

DROP TABLE IF EXISTS `TypeMaintenance`;
CREATE TABLE IF NOT EXISTS `TypeMaintenance` (
  `idTypeMaintenance` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  `dureeMaintenance` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idTypeMaintenance`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant les differentes maintenances possibles, e' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `Ville`
--

DROP TABLE IF EXISTS `Ville`;
CREATE TABLE IF NOT EXISTS `Ville` (
  `idVille` int(11) NOT NULL AUTO_INCREMENT,
  `labelVille` varchar(50) NOT NULL,
  `labelPays` varchar(45) NOT NULL,
  PRIMARY KEY (`idVille`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `Vol`
--

DROP TABLE IF EXISTS `Vol`;
CREATE TABLE IF NOT EXISTS `Vol` (
  `noVol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelvol` varchar(45) NOT NULL,
  `labelAeroportAtte` varchar(45) NOT NULL,
  `labelAeroportDeco` varchar(45) NOT NULL,
  `noAvion` int(10) unsigned NOT NULL,
  `noLigne` int(10) unsigned DEFAULT NULL,
  `heureDecollage` datetime NOT NULL,
  `heureAtterissage` datetime NOT NULL,
  PRIMARY KEY (`noVol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



ALTER TABLE `CommandeNourriture` CHANGE `noCommandeNourriture` `noCommandeNourriture` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `RegimeAlimentaire` CHANGE `noRegimeAlimentaire` `noRegimeAlimentaire` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `Place` CHANGE `noPlace` `noPlace` INT( 11 ) NOT NULL AUTO_INCREMENT 