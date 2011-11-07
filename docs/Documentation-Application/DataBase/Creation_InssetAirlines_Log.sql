SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


CREATE SCHEMA IF NOT EXISTS `InssetAirlines_Log` DEFAULT CHARACTER SET utf8 ;
USE `InssetAirlines_Log` ;

-- -----------------------------------------------------
-- Table `InssetAirlines_Log`.`Application`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `InssetAirlines_Log`.`Application` (
  `idApplication` INT NOT NULL ,
  `Applicationcol` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idApplication`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `InssetAirlines_Log`.`Log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `InssetAirlines_Log`.`Log` (
  `idLog` INT NOT NULL ,
  `timeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ,
  `logLevel` INT NOT NULL ,
  `ipUtilisateur` VARCHAR(45) NOT NULL ,
  `message` VARCHAR(500) NOT NULL ,
  `Application_idApplication` INT NOT NULL ,
  PRIMARY KEY (`idLog`, `Application_idApplication`) ,
  INDEX `fk_Log_Application` (`Application_idApplication` ASC) ,
  CONSTRAINT `fk_Log_Application`
    FOREIGN KEY (`Application_idApplication` )
    REFERENCES `InssetAirlines_Log`.`Application` (`idApplication` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
