SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `INSSET_Airlines`.`Constructeur` ADD COLUMN `noConstructeur` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  FIRST 
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`noConstructeur`) ;

ALTER TABLE `INSSET_Airlines`.`Modele` DROP COLUMN `labelConstructeur` , ADD COLUMN `noModele` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  FIRST , ADD COLUMN `noConstructeur` INT(10) UNSIGNED NOT NULL  AFTER `dateLancement` , 
  ADD CONSTRAINT `fk_Modele_Constructeur1`
  FOREIGN KEY (`noConstructeur` )
  REFERENCES `INSSET_Airlines`.`Constructeur` (`noConstructeur` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`noModele`) 
, ADD INDEX `fk_Modele_Constructeur1` (`noConstructeur` ASC) ;

ALTER TABLE `INSSET_Airlines`.`TypeMaintenance` ADD COLUMN `noTypeMaintenance` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT  FIRST , ADD COLUMN `periode` INT(10) UNSIGNED NOT NULL  AFTER `dureeMaintenance` 
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`noTypeMaintenance`) ;

ALTER TABLE `INSSET_Airlines`.`TacheMaintenance` DROP COLUMN `labelTypeMaintenance` , ADD COLUMN `noTypeMaintenance` INT(10) UNSIGNED NOT NULL  AFTER `retard` , CHANGE COLUMN `noAvion` `noAvion` INT(10) UNSIGNED NOT NULL  , 
  ADD CONSTRAINT `fk_TacheMaintenance_TypeMaintenance`
  FOREIGN KEY (`noTypeMaintenance` )
  REFERENCES `INSSET_Airlines`.`TypeMaintenance` (`noTypeMaintenance` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_TacheMaintenance_Avion1`
  FOREIGN KEY (`noAvion` )
  REFERENCES `INSSET_Airlines`.`Avion` (`noAvion` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_TacheMaintenance_TypeMaintenance` (`noTypeMaintenance` ASC) 
, ADD INDEX `fk_TacheMaintenance_Avion1` (`noAvion` ASC) ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
