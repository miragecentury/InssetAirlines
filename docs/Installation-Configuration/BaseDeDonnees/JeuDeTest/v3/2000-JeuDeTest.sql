-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 07 Décembre 2011 à 18:04
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

--
-- Contenu de la table `Adresse`
--

INSERT INTO `Adresse` (`noAdresse`, `numero`, `porte`, `adresse`, `etage`, `immeuble`, `commentaire`, `codepostal`, `etatProvince`, `labelVille`, `labelPays`) VALUES
(1, '1', 'Porte 2', 'place fayette', '3', 'Les Bleuets', NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(2, '7', 'Porte 012', 'rue raspail', '03', NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(3, '5', 'porte 105', 'camille moulin', '2', 'Les Violettes', NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(4, '9', NULL, 'rue du wéé', NULL, NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France'),
(5, '1', NULL, 'avanue des champs Elysée', NULL, NULL, NULL, '75000', 'Region Parisienne', 'Paris', 'France'),
(6, '1', NULL, 'avenue des champs Elysée', NULL, NULL, NULL, '75000', 'Region Parisienne', 'Paris', 'France'),
(7, '1', NULL, 'place fayette', '3', NULL, NULL, '02100', 'Picardie', 'Saint Quentin', 'France');

--
-- Contenu de la table `Aeroport`
--

INSERT INTO `Aeroport` (`noAeroport`, `labelAeroport`, `labelVille`, `labelPays`) VALUES
(2, 'Madrid-Barajas', 'Madrid', 'Espagne'),
(3, 'Roissy', 'Paris', 'France'),
(4, 'JFK', 'New York', 'USA');

--
-- Contenu de la table `Agence`
--

INSERT INTO `Agence` (`noAgence`, `labelAgence`, `dateLancement`, `dateCloture`, `accesExtranet`, `noAdresse`) VALUES
(1, 'Nouvelles Frontières', '2011-12-01', NULL, 0, 7),
(2, 'Tourisme', '2008-12-07', '2009-12-31', 0, 3);

--
-- Contenu de la table `Agence_has_Telephone`
--

INSERT INTO `Agence_has_Telephone` (`Agence_noAgence`, `Telephone_noTelephone`, `LabelTelephone_label`) VALUES
(1, 1, 'Bureau'),
(2, 2, 'Bureau');

--
-- Contenu de la table `Annee_Exploitation`
--


--
-- Contenu de la table `Avion`
--


--
-- Contenu de la table `CommandeNourriture`
--


--
-- Contenu de la table `Conge`
--


--
-- Contenu de la table `Constructeur`
--

INSERT INTO `Constructeur` (`noConstructeur`, `label`, `noAdresse`) VALUES
(1, 'AirBus', 1),
(2, 'Boeing', 2),
(14, 'Dassault', 1);

--
-- Contenu de la table `DemandeLigne`
--


--
-- Contenu de la table `Employe`
--

INSERT INTO `Employe` (`Personne_noPersonne`, `labelMetier`) VALUES
(20, 'Pilote');

--
-- Contenu de la table `Employe_has_Annee_Exploitation`
--


--
-- Contenu de la table `EnVol`
--


--
-- Contenu de la table `EstCommande`
--


--
-- Contenu de la table `EtudeMarche`
--


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

INSERT INTO `Incident` (`noIncident`, `dateIncident`, `noAeroportArriNextIncident`, `noVol`, `idTypeIncident`) VALUES
(14, '2011-11-30 00:00:00', 2, 1, 1),
(15, '2011-12-02 00:00:00', 1, 1, 6),
(16, '2011-12-05 00:00:00', 3, 1, 1);

--
-- Contenu de la table `Incompatible`
--


--
-- Contenu de la table `LabelTelephone`
--


--
-- Contenu de la table `Ligne`
--

INSERT INTO `Ligne` (`noLigne`, `jours`, `semaines`, `mois`, `annees`, `noAeroportDeco`, `noAeroportAtte`, `etat`) VALUES
(1, 2, NULL, NULL, NULL, 4, 3, 3),
(2, NULL, 3, NULL, NULL, 2, 3, 3),
(3, NULL, NULL, 10, NULL, 4, 2, 3),
(4, NULL, NULL, NULL, 11, 2, 3, 3);

--
-- Contenu de la table `Menu`
--


--
-- Contenu de la table `Metier`
--


--
-- Contenu de la table `Modele`
--

INSERT INTO `Modele` (`noModele`, `label`, `rayonAction`, `distMinAtt`, `distMinDec`, `dateLancement`, `noConstructeur`) VALUES
(1, 'A380', 1800, 2500, 2000, 2010, 1),
(2, '747-400', 9800, 2000, 1500, 2001, 2);

--
-- Contenu de la table `Pays`
--


--
-- Contenu de la table `Personne`
--

INSERT INTO `Personne` (`noPersonne`, `nom`, `prenom`, `prenom2`, `prenom3`, `dateNaissance`, `responsableLegal`, `noINSEE`, `noAdresse`, `labelPays`, `email`, `role`, `password`, `password_salt`) VALUES
(1, 'Serv', 'DRH', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServDRH@inssetairlines.fr', 'Serv_DRH', 'ServDRH@inssetairlines.fr', 'ServDRH@inssetairlines.fr'),
(2, 'Serv', 'DRH', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServDRHAdm@inssetairlines.fr', 'Serv_DRH_Adm', 'ServDRHAdm@inssetairlines.fr', 'ServDRHAdm@inssetairlines.fr'),
(3, 'Serv', 'Com', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServCom@inssetairlines.fr', 'Serv_Com', 'ServCom@inssetairlines.fr', 'ServCom@inssetairlines.fr'),
(4, 'Serv', 'Com', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServComAdm@inssetairlines.fr', 'Serv_Com_Adm', 'ServComAdm@inssetairlines.fr', 'ServComAdm@inssetairlines.fr'),
(5, 'Serv', 'Stra', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServStrat@inssetairlines.fr', 'Serv_Strat', 'ServStrat@inssetairlines.fr', 'ServStrat@inssetairlines.fr'),
(6, 'Serv', 'Stra', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServStratAdm@inssetairlines.fr', 'Serv_Strat_Adm', 'ServStratAdm@inssetairlines.fr', 'ServStratAdm@inssetairlines.fr'),
(7, 'Serv', 'Exp', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServExp@inssetairlines.fr', 'Serv_Exp', 'ServExp@inssetairlines.fr', 'ServExp@inssetairlines.fr'),
(8, 'Serv', 'Exp', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServExpAdm@inssetairlines.fr', 'Serv_Exp_Adm', 'ServExpAdm@inssetairlines.fr', 'ServExpAdm@inssetairlines.fr'),
(9, 'Serv', 'Plan', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServPlan@inssetairlines.fr', 'Serv_Plan', 'ServPlan@inssetairlines.fr', 'ServPlan@inssetairlines.fr'),
(10, 'Serv', 'Plan', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServPlanAdm@inssetairlines.fr', 'Serv_Plan_Adm', 'ServPlanAdm@inssetairlines.fr', 'ServPlanAdm@inssetairlines.fr'),
(11, 'Serv', 'Maint', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServMaint@inssetairlines.fr', 'Serv_Maint', 'ServMaint@inssetairlines.fr', 'ServMaint@inssetairlines.fr'),
(12, 'Serv', 'Maint', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServMaintAdm@inssetairlines.fr', 'Serv_Maint_Adm', 'ServMaintAdm@inssetairlines.fr', 'ServMaintAdm@inssetairlines.fr'),
(13, 'Serv', 'Log', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServLog@inssetairlines.fr', 'Serv_Log', 'ServLog@inssetairlines.fr', 'ServLog@inssetairlines.fr'),
(14, 'Serv', 'Log', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServLogAdm@inssetairlines.fr', 'Serv_Log_Adm', 'ServLogAdm@inssetairlines.fr', 'ServLogAdm@inssetairlines.fr'),
(15, 'Serv', 'Ag', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServAg@inssetairlines.fr', 'Serv_Ag', 'ServAg@inssetairlines.fr', 'ServAg@inssetairlines.fr'),
(16, 'Serv', 'Ag', 'Adm', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'ServAgAdm@inssetairlines.fr', 'Serv_Ag_Adm', 'ServAgAdm@inssetairlines.fr', 'ServAgAdm@inssetairlines.fr'),
(17, 'Adm', '', '', '', '1981-06-17', NULL, 2147483647, 1, 'France', 'Adm@inssetairlines.fr', 'Adm', 'Adm@inssetairlines.fr', 'Adm@inssetairlines.fr'),
(20, 'Pilote', 'Claude', '', '', '1981-06-03', NULL, 2147483647, 1, 'France', 'Pilote@inssetairlines.fr', 'Auth', 'Pilote@inssetairlines.fr', 'Pilote@inssetairlines.fr');

--
-- Contenu de la table `Personne_has_RegimeAlimentaire`
--


--
-- Contenu de la table `Personne_has_Telephone`
--


--
-- Contenu de la table `Place`
--


--
-- Contenu de la table `Qualification`
--

INSERT INTO `Qualification` (`Employe_Personne_noPersonne`, `Habilitation_noHabilitation`) VALUES
(20, 3),
(20, 4);

--
-- Contenu de la table `RegimeAlimentaire`
--


--
-- Contenu de la table `TacheMaintenance`
--


--
-- Contenu de la table `Telephone`
--

INSERT INTO `Telephone` (`noTelephone`, `numTelephone`) VALUES
(1, '0235986122'),
(2, '+33688412896'),
(3, '0568748922'),
(4, '+33625986321');

--
-- Contenu de la table `Telephone_has_Aeroport`
--


--
-- Contenu de la table `Telephone_has_Constructeur`
--


--
-- Contenu de la table `TypeConge`
--


--
-- Contenu de la table `TypeEtudeMarche`
--


--
-- Contenu de la table `TypeIncident`
--

INSERT INTO `TypeIncident` (`idTypeIncident`, `labelTypeIncident`, `dureeTypeIncident`) VALUES
(7, 'Maladie', 0),
(15, 'Intemperie', 1),
(16, 'Panne Mecanique', 1);

--
-- Contenu de la table `TypeMaintenance`
--


--
-- Contenu de la table `Ville`
--


--
-- Contenu de la table `Vol`
--


--
-- Contenu de la table `Vol_has_Agence`
--

INSERT INTO `Vol_has_Agence` (`idVolHasAgence`, `Vol_noVol`, `Agence_noAgence`, `nbReservation`, `enAttentedeTraitement`, `valider`) VALUES
(3, 1, 9, 15, 1, 1),
(4, 1, 9, 10, 0, 0);
