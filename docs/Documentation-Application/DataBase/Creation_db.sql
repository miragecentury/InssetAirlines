SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `INSSET_Airlines` DEFAULT CHARACTER SET utf8 ;
USE `INSSET_Airlines` ;

-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Pays`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Pays` (
  `labelPays` VARCHAR(45) NOT NULL ,
  `localize` VARCHAR(2) NOT NULL COMMENT 'fr,...' ,
  PRIMARY KEY (`labelPays`) ,
  UNIQUE INDEX `labelPays_UNIQUE` (`labelPays` ASC) ,
  UNIQUE INDEX `localize_UNIQUE` (`localize` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Ville`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Ville` (
  `labelVille` VARCHAR(50) NOT NULL ,
  `labelPays` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelVille`, `labelPays`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Adresse`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Adresse` (
  `noAdresse` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `numero` VARCHAR(45) NOT NULL ,
  `porte` VARCHAR(45) NULL COMMENT '				' ,
  `adresse` VARCHAR(200) NOT NULL ,
  `etage` VARCHAR(45) NULL ,
  `immeuble` VARCHAR(45) NULL ,
  `commentaire` VARCHAR(200) NULL ,
  `codepostal` VARCHAR(45) NULL ,
  `etatProvince` VARCHAR(50) NULL ,
  `labelVille` VARCHAR(50) NOT NULL ,
  `labelPays` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noAdresse`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Constructeur`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Constructeur` (
  `label` VARCHAR(25) NOT NULL ,
  `noAdresse` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`label`) ,
  UNIQUE INDEX `label_UNIQUE` (`label` ASC) )
ENGINE = InnoDB, 
COMMENT = 'Objet representant le constructeur' ;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Modele`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Modele` (
  `label` VARCHAR(25) NOT NULL COMMENT '- Appelation du modele\n- PK' ,
  `rayonAction` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- rayon d\'action max du modele\n(en KM) > Avec un plein de kerozen et de passagers' ,
  `distMinAtt` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- Longueur de la piste minimum pour l\'atterissage\nen M' ,
  `distMinDec` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- - Longueur de la piste minimum pour le decollage\nen M' ,
  `dateLancement` YEAR NOT NULL COMMENT '- Année de lancement du model' ,
  `labelConstructeur` VARCHAR(25) NOT NULL COMMENT '- FK\n- Constructeur du modele' ,
  PRIMARY KEY (`label`) ,
  UNIQUE INDEX `label_UNIQUE` (`label` ASC) )
ENGINE = InnoDB, 
COMMENT = 'Objet representant un modèle d\'avion, lié à un constructeur,' /* comment truncated */ ;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Avion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Avion` (
  `noAvion` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nbPlaceMax` INT UNSIGNED NOT NULL COMMENT '- Nombre de place maximum, fixé à la mise en service de l\'avion.' ,
  `nbHeureVol` FLOAT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- nombre d\'heure total de l\'avion\n- Alimente la gestion des maintenance\n- Est alimenté par l\'objet vol (temps de vol)' ,
  `nbIncident` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- Incrémenter à chaque incident.\n- Alimenté par le service d\'exploitation\n' ,
  `label` VARCHAR(25) NOT NULL COMMENT '- Nom de l\'appareil visible ' ,
  `dateMiseService` DATETIME NOT NULL COMMENT '- Renseigné par le service maintenance lors de la mise en service de l\'avion' ,
  `dateHorsService` DATETIME NULL COMMENT '- date previsionnelle de mise hors service de l\'appareil' ,
  `enService` TINYINT(1)  NOT NULL DEFAULT true COMMENT '- simplifie la recherche d\'appareil en service\n(optimisation) \n- peut etre remplacé par un conditionnel sur la date de mise hors service.' ,
  `labelModele` VARCHAR(25) NOT NULL COMMENT '- FK\n- Model de l\'avion' ,
  PRIMARY KEY (`noAvion`) ,
  UNIQUE INDEX `noAvion_UNIQUE` (`noAvion` ASC) ,
  UNIQUE INDEX `label_UNIQUE` (`label` ASC) )
ENGINE = InnoDB
COMMENT = 'Objet représentant un avion, avec un modèle précis\n\nSugestio' /* comment truncated */ ;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`TypeMaintenance`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`TypeMaintenance` (
  `label` VARCHAR(25) NOT NULL ,
  `dureeMaintenance` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`label`) ,
  UNIQUE INDEX `label_UNIQUE` (`label` ASC) )
ENGINE = InnoDB, 
COMMENT = 'Objet representant les differentes maintenances possibles, e' /* comment truncated */ ;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`TacheMaintenance`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`TacheMaintenance` (
  `noMaintenance` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dateDebut` DATETIME NOT NULL COMMENT '- Fixée par le service maintenance' ,
  `dateFin` DATETIME NOT NULL COMMENT '- Générer automatiquement par le type de maintenance' ,
  `retard` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '- le retard est en heure\n- le retard se rajoute à la date de fin\n(fixée à la base par le type de \nmaintenance)\n' ,
  `labelTypeMaintenance` VARCHAR(25) NOT NULL COMMENT '- FK\n- Specifie le type de maintenance' ,
  `noAvion` INT UNSIGNED NOT NULL COMMENT '- FK\n- Avion sujet de la maintenance' ,
  PRIMARY KEY (`noMaintenance`) ,
  UNIQUE INDEX `noMaintenance_UNIQUE` (`noMaintenance` ASC) )
ENGINE = InnoDB, 
COMMENT = 'Objet représentant une tache de maintenance, sur un avion av' /* comment truncated */ ;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Personne`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Personne` (
  `noPersonne` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nom` VARCHAR(45) NOT NULL ,
  `prenom` VARCHAR(45) NOT NULL ,
  `prenom2` VARCHAR(45) NULL ,
  `prenom3` VARCHAR(45) NULL ,
  `dateNaissance` DATE NOT NULL ,
  `responsableLegal` INT NULL ,
  `noINSEE` INT NOT NULL ,
  `noAdresse` INT UNSIGNED NOT NULL ,
  `labelPays` VARCHAR(50) NOT NULL ,
  `email` VARCHAR(200) NOT NULL ,
  `role` VARCHAR(45) NOT NULL DEFAULT 'Inv' ,
  `password` VARCHAR(32) NOT NULL ,
  `password_salt` VARCHAR(32) NOT NULL ,
  PRIMARY KEY (`noPersonne`) ,
  UNIQUE INDEX `noPersonne_UNIQUE` (`noPersonne` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Telephone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Telephone` (
  `noTelephone` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `numTelephone` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noTelephone`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`LabelTelephone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`LabelTelephone` (
  `label` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`label`) ,
  UNIQUE INDEX `label_UNIQUE` (`label` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Personne_has_Telephone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Personne_has_Telephone` (
  `noPersonne` INT UNSIGNED NOT NULL ,
  `noTelephone` INT UNSIGNED NOT NULL ,
  `labelTelephone` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`noPersonne`, `noTelephone`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Telephone_has_Constructeur`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Telephone_has_Constructeur` (
  `noTelephone` INT UNSIGNED NOT NULL ,
  `labelConstructeur` VARCHAR(25) NOT NULL ,
  `labelTelephone` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`noTelephone`, `labelConstructeur`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Metier`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Metier` (
  `labelMetier` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelMetier`) ,
  UNIQUE INDEX `labelMetier_UNIQUE` (`labelMetier` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Employe`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Employe` (
  `Personne_noPersonne` INT UNSIGNED NOT NULL ,
  `labelMetier` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`Personne_noPersonne`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Annee_Exploitation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Annee_Exploitation` (
  `dateDebut` DATE NOT NULL ,
  `dateFin` DATE NOT NULL ,
  PRIMARY KEY (`dateDebut`) ,
  UNIQUE INDEX `dateDebut_UNIQUE` (`dateDebut` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Employe_has_Annee_Exploitation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Employe_has_Annee_Exploitation` (
  `Employe_Personne_noPersonne` INT UNSIGNED NOT NULL ,
  `Annee_Exploitation_dateDebut` DATE NOT NULL ,
  PRIMARY KEY (`Employe_Personne_noPersonne`, `Annee_Exploitation_dateDebut`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`TypeConge`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`TypeConge` (
  `labelTypeConge` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelTypeConge`) ,
  UNIQUE INDEX `labelTypeConge_UNIQUE` (`labelTypeConge` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Conge`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Conge` (
  `noConge` INT NOT NULL ,
  `dateDebut` DATE NOT NULL ,
  `dateFin` DATE NOT NULL ,
  `valider` TINYINT(1)  NOT NULL DEFAULT false ,
  `enAttentedeTraitement` TINYINT(1)  NOT NULL DEFAULT true ,
  `motif` VARCHAR(200) NOT NULL ,
  `labelTypeConge` VARCHAR(45) NOT NULL ,
  `noPersonne` INT UNSIGNED NOT NULL ,
  `dateDebut_Annee` DATE NOT NULL ,
  PRIMARY KEY (`noConge`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Habilitation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Habilitation` (
  `noHabilitation` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `labelHabilitation` VARCHAR(45) NOT NULL ,
  `labelMetier` VARCHAR(45) NOT NULL ,
  `Modele_label` VARCHAR(25) NULL ,
  PRIMARY KEY (`noHabilitation`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Qualification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Qualification` (
  `Employe_Personne_noPersonne` INT UNSIGNED NOT NULL ,
  `Habilitation_noHabilitation` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`Employe_Personne_noPersonne`, `Habilitation_noHabilitation`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Agence`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Agence` (
  `noAgence` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `labelAgence` VARCHAR(45) NOT NULL ,
  `dateLancement` DATE NOT NULL ,
  `dateCloture` DATE NULL ,
  `accesExtranet` TINYINT(1)  NOT NULL DEFAULT false ,
  `noAdresse` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`noAgence`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Agence_has_Telephone`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Agence_has_Telephone` (
  `Agence_noAgence` INT UNSIGNED NOT NULL ,
  `Telephone_noTelephone` INT UNSIGNED NOT NULL ,
  `LabelTelephone_label` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`Agence_noAgence`, `Telephone_noTelephone`, `LabelTelephone_label`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Aeroport`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Aeroport` (
  `labelAeroport` VARCHAR(45) NOT NULL ,
  `labelVille` VARCHAR(50) NOT NULL ,
  `labelPays` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelAeroport`) ,
  UNIQUE INDEX `labelAeroport_UNIQUE` (`labelAeroport` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Ligne`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Ligne` (
  `noLigne` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `jours` INT NULL ,
  `semaines` INT NULL ,
  `mois` INT NULL ,
  `annees` INT NULL ,
  `labelAeroportDeco` VARCHAR(45) NOT NULL ,
  `labelAeroportAtte` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noLigne`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Vol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Vol` (
  `noVol` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `labelvol` VARCHAR(45) NOT NULL ,
  `labelAeroportAtte` VARCHAR(45) NOT NULL ,
  `labelAeroportDeco` VARCHAR(45) NOT NULL ,
  `noAvion` INT UNSIGNED NOT NULL ,
  `noLigne` INT UNSIGNED NULL ,
  `heureDecollage` DATETIME NOT NULL ,
  `heureAtterissage` DATETIME NOT NULL ,
  PRIMARY KEY (`noVol`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Place`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Place` (
  `noPlace` INT NOT NULL ,
  `noAgence` INT UNSIGNED NOT NULL ,
  `Personne_noPersonne` INT UNSIGNED NOT NULL ,
  `noVol` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`noPlace`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Telephone_has_Aeroport`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Telephone_has_Aeroport` (
  `Telephone_noTelephone` INT UNSIGNED NOT NULL ,
  `Aeroport_labelAeroport` VARCHAR(45) NOT NULL ,
  `LabelTelephone_label` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`Telephone_noTelephone`, `Aeroport_labelAeroport`, `LabelTelephone_label`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Vol_has_Agence`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Vol_has_Agence` (
  `Vol_noVol` INT UNSIGNED NOT NULL ,
  `Agence_noAgence` INT UNSIGNED NOT NULL ,
  `nbReservation` INT UNSIGNED NOT NULL ,
  `enAttentedeTraitement` TINYINT(1)  NOT NULL DEFAULT true ,
  `valider` TINYINT(1)  NOT NULL DEFAULT false ,
  PRIMARY KEY (`Vol_noVol`, `Agence_noAgence`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`TypeEtudeMarche`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`TypeEtudeMarche` (
  `labelTypeEtudeMarche` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelTypeEtudeMarche`) ,
  UNIQUE INDEX `labelTypeEtudeMarche_UNIQUE` (`labelTypeEtudeMarche` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`DemandeLigne`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`DemandeLigne` (
  `noDemandeLigne` INT NOT NULL ,
  `labelAeroportDeco` VARCHAR(45) NOT NULL ,
  `labelAeroportAtte` VARCHAR(45) NOT NULL ,
  `Motif` VARCHAR(500) NOT NULL ,
  PRIMARY KEY (`noDemandeLigne`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`EtudeMarche`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`EtudeMarche` (
  `noEtudeMarche` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `labelTypeEtudeMarche` VARCHAR(45) NOT NULL ,
  `Ligne_noLigne` INT UNSIGNED NOT NULL ,
  `noDemandeLigne` INT NOT NULL ,
  PRIMARY KEY (`noEtudeMarche`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`TypeIncident`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`TypeIncident` (
  `labelTypeIncident` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelTypeIncident`) ,
  UNIQUE INDEX `labelTypeIncident_UNIQUE` (`labelTypeIncident` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Incident`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Incident` (
  `noIncident` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dateIncident` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ,
  `labelAeroportArriNextIncident` VARCHAR(45) NOT NULL ,
  `noVol` INT UNSIGNED NOT NULL ,
  `labelTypeIncident` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noIncident`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`EnVol`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`EnVol` (
  `noVol` INT UNSIGNED NOT NULL ,
  `noEmploye` INT UNSIGNED NOT NULL ,
  `equipageSecours` TINYINT(1)  NOT NULL DEFAULT false ,
  `heureStart` DATETIME NOT NULL ,
  `heureEnd` DATETIME NULL ,
  PRIMARY KEY (`noVol`, `noEmploye`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Menu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Menu` (
  `labelMenu` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelMenu`) ,
  UNIQUE INDEX `labelMenu_UNIQUE` (`labelMenu` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`CommandeNourriture`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`CommandeNourriture` (
  `noCommandeNourriture` INT NOT NULL ,
  `dateLivraison` DATE NOT NULL ,
  `dateCommande` DATE NOT NULL ,
  `labelAeroportLivraison` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noCommandeNourriture`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`EstCommande`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`EstCommande` (
  `labelMenu` VARCHAR(45) NOT NULL ,
  `noCommandeNourriture` INT NOT NULL ,
  PRIMARY KEY (`labelMenu`, `noCommandeNourriture`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`RegimeAlimentaire`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`RegimeAlimentaire` (
  `labelRegimeAlimentaire` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelRegimeAlimentaire`) ,
  UNIQUE INDEX `LabelRegimeAlimentaire_UNIQUE` (`labelRegimeAlimentaire` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Personne_has_RegimeAlimentaire`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Personne_has_RegimeAlimentaire` (
  `noPersonne` INT UNSIGNED NOT NULL ,
  `labelRegimeAlimentaire` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`noPersonne`, `labelRegimeAlimentaire`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `INSSET_Airlines`.`Incompatible`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `INSSET_Airlines`.`Incompatible` (
  `labelRegimeAlimentaire` VARCHAR(45) NOT NULL ,
  `labelMenu` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`labelRegimeAlimentaire`, `labelMenu`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
