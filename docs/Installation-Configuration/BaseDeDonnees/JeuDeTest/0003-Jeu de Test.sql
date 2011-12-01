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

--
-- Contenu de la table `Adresse`
--

INSERT INTO `Adresse` (`noAdresse`, `numero`, `porte`, `adresse`, `etage`, `immeuble`, `commentaire`, `codepostal`, `etatProvince`, `labelVille`, `labelPays`) VALUES
(1, '1', NULL, 'place fayette', '3', NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(2, '7', '', 'rue raspail', NULL, NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(3, '5', NULL, 'camille moulin', '2', NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(4, '9', NULL, 'rue du wÃ©', NULL, NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(5, '1', NULL, 'avanue des champs Ã©lysÃ©e', NULL, NULL, NULL, '75000', 'Region Parisienne', 'Paris', 'France'),
(6, '1', NULL, 'avanue des champs Ã©lysÃ©e', NULL, NULL, NULL, '75000', 'Region Parisienne', 'Paris', 'France'),
(7, '1', NULL, 'place fayette', '3', NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France');

--
-- Contenu de la table `Aeroport`
--

INSERT INTO `Aeroport` (`noAeroport`, `labelAeroport`, `labelVille`, `labelPays`) VALUES
(1, 'JFK', 'New York', 'USA'),
(2, 'Madrid-Barajas', 'Madrid', 'Espagne'),
(3, 'Roissy', 'Paris', 'France');

--
-- Contenu de la table `Agence`
--

INSERT INTO `Agence` (`noAgence`, `labelAgence`, `dateLancement`, `dateCloture`, `accesExtranet`, `noAdresse`) VALUES
(1, 'ThomasCook', '2005-10-05', NULL, 1, 6),
(2, 'Nouvelle frontiere', '2008-10-16', NULL, 1, 7);

--
-- Contenu de la table `Agence_has_Telephone`
--

INSERT INTO `Agence_has_Telephone` (`Agence_noAgence`, `Telephone_noTelephone`, `LabelTelephone_label`) VALUES
(1, 6, 'Bureau'),
(2, 7, 'Bureau');

--
-- Contenu de la table `Annee_Exploitation`
--

INSERT INTO `Annee_Exploitation` (`idAnnee`, `dateDebut`, `dateFin`) VALUES
(1, '2004-10-01', '2005-09-30'),
(2, '2005-10-01', '2006-09-30'),
(3, '2006-10-01', '2007-09-30'),
(4, '2007-10-01', '2008-09-30'),
(5, '2008-10-01', '2009-09-30'),
(6, '2009-10-01', '2010-09-30'),
(7, '2010-10-01', '2011-09-30'),
(8, '2011-10-01', '2012-09-30');

--
-- Contenu de la table `Avion`
--

INSERT INTO `Avion` (`noAvion`, `nbPlaceMax`, `nbHeureVol`, `nbIncident`, `label`, `dateMiseService`, `dateHorsService`, `enService`, `labelModele`) VALUES
(1, 150, 150, 1, 'Airbus A350-800/1', '2010-10-06 00:00:00', NULL, 1, 'Airbus A350-800'),
(2, 150, 200, 1, 'Airbus A350-800/2', '2010-10-12 00:00:00', NULL, 1, 'Airbus A350-800'),
(3, 200, 100, 0, 'Boeing 747-8 Freighter/1', '2009-10-13 00:00:00', NULL, 1, 'Boeing 747-8 Freighter'),
(4, 150, 1000, 5, 'Boeing 777-200ER/1', '2001-10-02 00:00:00', '2008-10-15 00:00:00', 0, 'Boeing 777-200ER');

--
-- Contenu de la table `CommandeNourriture`
--

INSERT INTO `CommandeNourriture` (`noCommandeNourriture`, `dateLivraison`, `dateCommande`, `labelAeroportLivraison`) VALUES
(0, '0000-00-00', '0000-00-00', 'JFK');

--
-- Contenu de la table `Constructeur`
--

INSERT INTO `Constructeur` (`idConstructeur`, `label`, `noAdresse`) VALUES
(1, 'Airbus', 0),
(2, 'Boeing', 0);

--
-- Contenu de la table `Employe`
--

INSERT INTO `Employe` (`Personne_noPersonne`, `labelMetier`) VALUES
(20, 'Pilote');

--
-- Contenu de la table `Habilitation`
--

INSERT INTO `Habilitation` (`noHabilitation`, `labelHabilitation`, `labelMetier`, `Modele_label`) VALUES
(1, 'Airbus A350-800', 'Pilote', 'Airbus A350-800'),
(2, 'Airbus A350-1000', 'Pilote', 'Airbus A350-1000'),
(3, 'Boeing 747-8 Freighter', 'Pilote', 'Boeing 747-8 Freighter'),
(4, 'Boeing 777-300', 'Pilote', 'Boeing 777-300'),
(5, 'Boeing 777-200ER', 'Pilote', 'Boeing 777-200ER');

--
-- Contenu de la table `Incident`
--

INSERT INTO `Incident` (`noIncident`, `dateIncident`, `labelAeroportArriNextIncident`, `noVol`, `labelTypeIncident`) VALUES
(9, '0000-00-00 00:00:00', 'Madrid-Barajas', 1, 'Malade'),
(10, '0000-00-00 00:00:00', 'JFK', 1, 'Crash'),
(11, '0000-00-00 00:00:00', 'JFK', 2, 'Test');

--
-- Contenu de la table `LabelTelephone`
--

INSERT INTO `LabelTelephone` (`noLabel`, `label`) VALUES
(1, 'Bureau'),
(2, 'Maison'),
(3, 'Portable');

--
-- Contenu de la table `Ligne`
--

INSERT INTO `Ligne` (`noLigne`, `jours`, `semaines`, `mois`, `annees`, `labelAeroportDeco`, `labelAeroportAtte`) VALUES
(1, 3, NULL, NULL, NULL, 'New York', 'Paris'),
(2, NULL, 1, NULL, NULL, 'New York', 'Madrid');

--
-- Contenu de la table `Metier`
--

INSERT INTO `Metier` (`idMetier`, `labelMetier`) VALUES
(1, 'Pilote');

--
-- Contenu de la table `Modele`
--

INSERT INTO `Modele` (`idModele`, `label`, `rayonAction`, `distMinAtt`, `distMinDec`, `dateLancement`, `labelConstructeur`) VALUES
(0, 'Airbus A350-1000', 14800, 1200, 2400, 2006, 'Airbus'),
(0, 'Airbus A350-800', 15400, 1500, 3000, 2006, 'Airbus'),
(0, 'Boeing 747-8 Freighter', 8130, 900, 1600, 2005, 'Boeing'),
(0, 'Boeing 777-200ER', 14305, 1500, 2200, 1997, 'Boeing'),
(0, 'Boeing 777-300', 11120, 1200, 2200, 1998, 'Boeing');

--
-- Contenu de la table `Pays`
--

INSERT INTO `Pays` (`noPays`, `labelPays`, `localize`) VALUES
(1, 'USA', 'en'),
(2, 'Espagne', 'es'),
(3, 'France', 'fr');

--
-- Contenu de la table `Personne`
--

INSERT INTO `Personne` (`noPersonne`, `nom`, `prenom`, `prenom2`, `prenom3`, `dateNaissance`, `responsableLegal`, `noINSEE`, `noAdresse`, `labelPays`, `email`, `role`, `password`, `password_salt`) VALUES
(1, 'Serv', 'DRH', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_DRH', 'Serv_DRH', 'Serv_DRH', 'Serv_DRH'),
(2, 'Serv', 'DRH', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_DRH_Adm', 'Serv_DRH_Adm', 'Serv_DRH_Adm', 'Serv_DRH_Adm'),
(3, 'Serv', 'Com', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Com', 'Serv_Com', 'Serv_Com', 'Serv_Com'),
(4, 'Serv', 'Com', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Com_Adm', 'Serv_Com_Adm', 'Serv_Com_Adm', 'Serv_Com_Adm'),
(5, 'Serv', 'Stra', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Stra', 'Serv_Stra', 'Serv_Stra', 'Serv_Stra'),
(6, 'Serv', 'Stra', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Stra_Adm', 'Serv_Stra_Adm', 'Serv_Stra_Adm', 'Serv_Stra_Adm'),
(7, 'Serv', 'Exp', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Exp', 'Serv_Exp', 'Serv_Exp', 'Serv_Exp'),
(8, 'Serv', 'Exp', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Exp_Adm', 'Serv_Exp_Adm', 'Serv_Exp_Adm', 'Serv_Exp_Adm'),
(9, 'Serv', 'Plan', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Plan', 'Serv_Plan', 'Serv_Plan', 'Serv_Plan'),
(10, 'Serv', 'Plan', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Plan_Adm', 'Serv_Plan_Adm', 'Serv_Plan_Adm', 'Serv_Plan_Adm'),
(11, 'Serv', 'Maint', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Maint', 'Serv_Maint', 'Serv_Maint', 'Serv_Maint'),
(12, 'Serv', 'Maint', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Maint_Adm', 'Serv_Maint_Adm', 'Serv_Maint_Adm', 'Serv_Maint_Adm'),
(13, 'Serv', 'Log', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Log', 'Serv_Log', 'Serv_Log', 'Serv_Log'),
(14, 'Serv', 'Log', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Log_Adm', 'Serv_Log_Adm', 'Serv_Log_Adm', 'Serv_Log_Adm'),
(15, 'Serv', 'Ag', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Ag', 'Serv_Ag', 'Serv_Ag', 'Serv_Ag'),
(16, 'Serv', 'Ag', 'Adm', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Serv_Ag_Adm', 'Serv_Ag_Adm', 'Serv_Ag_Adm', 'Serv_Ag_Adm'),
(17, 'Adm', '', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Adm', 'Adm', 'Adm', 'Adm'),
(18, 'Inv', '', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Inv', 'Inv', 'Inv', 'Inv'),
(19, 'Auth', '', '', '', '1981-06-17', NULL, 2147483647, 0, 'France', 'Auth', 'Auth', 'Auth', 'Auth'),
(20, 'Pilote', 'Claude', '', '', '1981-06-03', NULL, 2147483647, 1, 'France', 'Pilote', 'Auth', 'Pilote', 'Pilote');

--
-- Contenu de la table `Personne_has_Telephone`
--

INSERT INTO `Personne_has_Telephone` (`noPersonne`, `noTelephone`, `labelTelephone`) VALUES
(1, 1, 'Bureau'),
(1, 2, 'Bureau'),
(20, 8, 'Portable');

--
-- Contenu de la table `Place`
--

INSERT INTO `Place` (`noPlace`, `noAgence`, `Personne_noPersonne`, `noVol`) VALUES
(1, 1, 21, 1),
(2, 1, 22, 1),
(3, 1, 23, 1),
(4, 1, 24, 1),
(5, 2, 25, 1);

--
-- Contenu de la table `Qualification`
--

INSERT INTO `Qualification` (`Employe_Personne_noPersonne`, `Habilitation_noHabilitation`) VALUES
(20, 3),
(20, 4);

--
-- Contenu de la table `Telephone`
--

INSERT INTO `Telephone` (`noTelephone`, `numTelephone`) VALUES
(1, '+33678542438'),
(2, '+33678542438'),
(3, '+33678542438'),
(4, '+33678542438'),
(5, '+33678542438'),
(6, '+33678542438'),
(7, '+33678542438'),
(8, '+33678542438');

--
-- Contenu de la table `Telephone_has_Aeroport`
--

INSERT INTO `Telephone_has_Aeroport` (`Telephone_noTelephone`, `Aeroport_labelAeroport`, `LabelTelephone_label`) VALUES
(3, 'Madrid-Barajas', 'Bureau'),
(4, 'Roissy', 'Bureau'),
(5, 'JFK', 'Bureau');

--
-- Contenu de la table `Telephone_has_Constructeur`
--

INSERT INTO `Telephone_has_Constructeur` (`noTelephone`, `labelConstructeur`, `labelTelephone`) VALUES
(1, 'Boeing', 'Bureau'),
(2, 'Airbus', 'Bureau');

--
-- Contenu de la table `TypeIncident`
--

INSERT INTO `TypeIncident` (`idTypeIncident`, `labelTypeIncident`) VALUES
(1, 'Crash'),
(2, 'Crash2'),
(3, 'Crash3'),
(4, 'Malade'),
(5, 'test');

--
-- Contenu de la table `TypeMaintenance`
--

INSERT INTO `TypeMaintenance` (`idTypeMaintenance`, `label`, `dureeMaintenance`) VALUES
(1, 'Maintenance Courte', 2),
(2, 'Maintenance Longue', 10);

--
-- Contenu de la table `Ville`
--

INSERT INTO `Ville` (`idVille`, `labelVille`, `labelPays`) VALUES
(1, 'Madrid', 'Espagne'),
(2, 'New York', 'USA'),
(3, 'Paris', 'France'),
(4, 'Saint Quentin', 'France');

--
-- Contenu de la table `Vol`
--

INSERT INTO `Vol` (`noVol`, `labelvol`, `labelAeroportAtte`, `labelAeroportDeco`, `noAvion`, `noLigne`, `heureDecollage`, `heureAtterissage`) VALUES
(1, 'New York - Paris', 'Roissy', 'JFK', 1, 1, '2011-10-24 08:27:12', '2011-10-24 23:24:25'),
(2, 'New York - Madrid', 'Madrid-Barajas', 'JFK', 2, 2, '2011-10-25 00:00:00', '2011-10-25 09:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
