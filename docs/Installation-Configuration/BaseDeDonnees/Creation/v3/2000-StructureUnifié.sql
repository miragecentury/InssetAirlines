-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 07 Décembre 2011 à 17:37
-- Version du serveur: 5.1.54
-- Version de PHP: 5.3.5-1ubuntu7.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `INSSET_AirlinesV3`
--

-- --------------------------------------------------------

--
-- Structure de la table `Adresse`
--

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

CREATE TABLE IF NOT EXISTS `Aeroport` (
  `noAeroport` int(11) NOT NULL AUTO_INCREMENT,
  `labelAeroport` varchar(45) NOT NULL,
  `labelVille` varchar(50) NOT NULL,
  `labelPays` varchar(45) NOT NULL,
  PRIMARY KEY (`noAeroport`),
  KEY `noAeroport` (`noAeroport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `Agence`
--

CREATE TABLE IF NOT EXISTS `Agence` (
  `noAgence` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelAgence` varchar(45) NOT NULL,
  `dateLancement` date NOT NULL,
  `dateCloture` date DEFAULT NULL,
  `accesExtranet` tinyint(1) NOT NULL DEFAULT '0',
  `noAdresse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noAgence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Agence_has_Telephone`
--

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

CREATE TABLE IF NOT EXISTS `Annee_Exploitation` (
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`dateDebut`),
  UNIQUE KEY `dateDebut_UNIQUE` (`dateDebut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Avion`
--

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
  `labelModele` varchar(25) NOT NULL COMMENT '- FK\n- Model de l''avion',
  PRIMARY KEY (`noAvion`),
  UNIQUE KEY `noAvion_UNIQUE` (`noAvion`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet reprÃ©sentant un avion, avec un modÃ¨le prÃ©cis\n\nSuges' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `CommandeNourriture`
--

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

CREATE TABLE IF NOT EXISTS `Constructeur` (
  `noConstructeur` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  `noAdresse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noConstructeur`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant le constructeur' AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `DemandeLigne`
--

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

CREATE TABLE IF NOT EXISTS `Employe` (
  `Personne_noPersonne` int(10) unsigned NOT NULL,
  `labelMetier` varchar(45) NOT NULL,
  PRIMARY KEY (`Personne_noPersonne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Employe_has_Annee_Exploitation`
--

CREATE TABLE IF NOT EXISTS `Employe_has_Annee_Exploitation` (
  `Employe_Personne_noPersonne` int(10) unsigned NOT NULL,
  `Annee_Exploitation_dateDebut` date NOT NULL,
  PRIMARY KEY (`Employe_Personne_noPersonne`,`Annee_Exploitation_dateDebut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EnVol`
--

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

CREATE TABLE IF NOT EXISTS `EstCommande` (
  `labelMenu` varchar(45) NOT NULL,
  `noCommandeNourriture` int(11) NOT NULL,
  PRIMARY KEY (`labelMenu`,`noCommandeNourriture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EtudeMarche`
--

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

CREATE TABLE IF NOT EXISTS `Incident` (
  `noIncident` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateIncident` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noAeroportArriNextIncident` int(11) NOT NULL,
  `noVol` int(10) unsigned NOT NULL,
  `idTypeIncident` int(11) NOT NULL,
  PRIMARY KEY (`noIncident`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Structure de la table `Incompatible`
--

CREATE TABLE IF NOT EXISTS `Incompatible` (
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  `labelMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`labelRegimeAlimentaire`,`labelMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `LabelTelephone`
--

CREATE TABLE IF NOT EXISTS `LabelTelephone` (
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`label`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Ligne`
--

CREATE TABLE IF NOT EXISTS `Ligne` (
  `noLigne` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jours` int(11) DEFAULT NULL,
  `semaines` int(11) DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annees` int(11) DEFAULT NULL,
  `noAeroportDeco` int(11) NOT NULL,
  `noAeroportAtte` int(11) NOT NULL,
  `etat` int(2) unsigned NOT NULL,
  PRIMARY KEY (`noLigne`),
  KEY `etat` (`etat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `labelMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`labelMenu`),
  UNIQUE KEY `labelMenu_UNIQUE` (`labelMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Metier`
--

CREATE TABLE IF NOT EXISTS `Metier` (
  `labelMetier` varchar(45) NOT NULL,
  PRIMARY KEY (`labelMetier`),
  UNIQUE KEY `labelMetier_UNIQUE` (`labelMetier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Modele`
--

CREATE TABLE IF NOT EXISTS `Modele` (
  `noModele` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL COMMENT '- Appelation du modele\n- PK',
  `rayonAction` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- rayon d''action max du modele\n(en KM) > Avec un plein de kerozen et de passagers',
  `distMinAtt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- Longueur de la piste minimum pour l''atterissage\nen M',
  `distMinDec` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- - Longueur de la piste minimum pour le decollage\nen M',
  `dateLancement` year(4) NOT NULL COMMENT '- AnnÃ©e de lancement du model',
  `noConstructeur` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noModele`),
  UNIQUE KEY `label_UNIQUE` (`label`),
  KEY `fk_Modele_Constructeur1` (`noConstructeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Objet representant un modÃ¨le d''avion, liÃ© Ã  un constructe' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `Pays`
--

CREATE TABLE IF NOT EXISTS `Pays` (
  `labelPays` varchar(45) NOT NULL,
  `localize` varchar(2) NOT NULL COMMENT 'fr,...',
  PRIMARY KEY (`labelPays`),
  UNIQUE KEY `labelPays_UNIQUE` (`labelPays`),
  UNIQUE KEY `localize_UNIQUE` (`localize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

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
-- Doublure de structure pour la vue `PersonneView`
--
CREATE TABLE IF NOT EXISTS `PersonneView` (
`noPersonne` int(10) unsigned
,`labelTelephone` varchar(50)
,`noTelephone` int(10) unsigned
,`numTelephone` varchar(45)
);
-- --------------------------------------------------------

--
-- Structure de la table `Personne_has_RegimeAlimentaire`
--

CREATE TABLE IF NOT EXISTS `Personne_has_RegimeAlimentaire` (
  `noPersonne` int(10) unsigned NOT NULL,
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  PRIMARY KEY (`noPersonne`,`labelRegimeAlimentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Personne_has_Telephone`
--

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

CREATE TABLE IF NOT EXISTS `Qualification` (
  `Employe_Personne_noPersonne` int(10) unsigned NOT NULL,
  `Habilitation_noHabilitation` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Employe_Personne_noPersonne`,`Habilitation_noHabilitation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `RegimeAlimentaire`
--

CREATE TABLE IF NOT EXISTS `RegimeAlimentaire` (
  `labelRegimeAlimentaire` varchar(45) NOT NULL,
  PRIMARY KEY (`labelRegimeAlimentaire`),
  UNIQUE KEY `LabelRegimeAlimentaire_UNIQUE` (`labelRegimeAlimentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TacheMaintenance`
--

CREATE TABLE IF NOT EXISTS `TacheMaintenance` (
  `noMaintenance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateDebut` datetime NOT NULL COMMENT '- FixÃ©e par le service maintenance',
  `dateFin` datetime NOT NULL COMMENT '- GÃ©nÃ©rer automatiquement par le type de maintenance',
  `retard` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '- le retard est en heure\n- le retard se rajoute Ã  la date de fin\n(fixÃ©e Ã  la base par le type de \nmaintenance)\n',
  `noTypeMaintenance` int(10) unsigned NOT NULL,
  `noAvion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noMaintenance`),
  UNIQUE KEY `noMaintenance_UNIQUE` (`noMaintenance`),
  KEY `fk_TacheMaintenance_TypeMaintenance` (`noTypeMaintenance`),
  KEY `fk_TacheMaintenance_Avion1` (`noAvion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet reprÃ©sentant une tache de maintenance, sur un avion a' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Telephone`
--

CREATE TABLE IF NOT EXISTS `Telephone` (
  `noTelephone` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numTelephone` varchar(45) NOT NULL,
  PRIMARY KEY (`noTelephone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Telephone_has_Aeroport`
--

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

CREATE TABLE IF NOT EXISTS `TypeConge` (
  `labelTypeConge` varchar(45) NOT NULL,
  PRIMARY KEY (`labelTypeConge`),
  UNIQUE KEY `labelTypeConge_UNIQUE` (`labelTypeConge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TypeEtudeMarche`
--

CREATE TABLE IF NOT EXISTS `TypeEtudeMarche` (
  `labelTypeEtudeMarche` varchar(45) NOT NULL,
  PRIMARY KEY (`labelTypeEtudeMarche`),
  UNIQUE KEY `labelTypeEtudeMarche_UNIQUE` (`labelTypeEtudeMarche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TypeIncident`
--

CREATE TABLE IF NOT EXISTS `TypeIncident` (
  `idTypeIncident` int(11) NOT NULL AUTO_INCREMENT,
  `labelTypeIncident` varchar(45) NOT NULL,
  `dureeTypeIncident` int(11) NOT NULL,
  PRIMARY KEY (`idTypeIncident`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `TypeMaintenance`
--

CREATE TABLE IF NOT EXISTS `TypeMaintenance` (
  `noTypeMaintenance` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(25) NOT NULL,
  `dureeMaintenance` int(10) unsigned NOT NULL,
  `periode` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noTypeMaintenance`),
  UNIQUE KEY `label_UNIQUE` (`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objet representant les differentes maintenances possibles, e' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Ville`
--

CREATE TABLE IF NOT EXISTS `Ville` (
  `labelVille` varchar(50) NOT NULL,
  `labelPays` varchar(45) NOT NULL,
  PRIMARY KEY (`labelVille`,`labelPays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Vol`
--

CREATE TABLE IF NOT EXISTS `Vol` (
  `noVol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labelvol` varchar(45) NOT NULL,
  `noAeroportAtte` int(11) NOT NULL,
  `noAeroportDeco` int(11) NOT NULL,
  `noAvion` int(10) unsigned NOT NULL,
  `noLigne` int(10) unsigned DEFAULT NULL,
  `heureDecollage` datetime NOT NULL,
  `heureAtterissage` datetime NOT NULL,
  `etat` int(2) unsigned NOT NULL,
  PRIMARY KEY (`noVol`),
  KEY `etat` (`etat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Vol_has_Agence`
--

CREATE TABLE IF NOT EXISTS `Vol_has_Agence` (
  `idVolHasAgence` int(11) NOT NULL AUTO_INCREMENT,
  `Vol_noVol` int(10) unsigned NOT NULL,
  `Agence_noAgence` int(10) unsigned NOT NULL,
  `nbReservation` int(10) unsigned NOT NULL,
  `enAttentedeTraitement` tinyint(1) NOT NULL DEFAULT '1',
  `valider` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVolHasAgence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la vue `PersonneView`
--
DROP TABLE IF EXISTS `PersonneView`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `PersonneView` AS select `p`.`noPersonne` AS `noPersonne`,`pt`.`labelTelephone` AS `labelTelephone`,`pt`.`noTelephone` AS `noTelephone`,`t`.`numTelephone` AS `numTelephone` from ((`Personne` `p` join `Personne_has_Telephone` `pt` on((`p`.`noPersonne` = `pt`.`noPersonne`))) join `Telephone` `t` on((`pt`.`noTelephone` = `t`.`noTelephone`)));

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Modele`
--
ALTER TABLE `Modele`
  ADD CONSTRAINT `fk_Modele_Constructeur1` FOREIGN KEY (`noConstructeur`) REFERENCES `Constructeur` (`noConstructeur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `TacheMaintenance`
--
ALTER TABLE `TacheMaintenance`
  ADD CONSTRAINT `fk_TacheMaintenance_TypeMaintenance` FOREIGN KEY (`noTypeMaintenance`) REFERENCES `TypeMaintenance` (`noTypeMaintenance`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TacheMaintenance_Avion1` FOREIGN KEY (`noAvion`) REFERENCES `Avion` (`noAvion`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
