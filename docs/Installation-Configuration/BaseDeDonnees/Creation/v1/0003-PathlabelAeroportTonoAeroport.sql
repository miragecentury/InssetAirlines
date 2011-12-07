ALTER TABLE `Ligne` CHANGE `labelAeroportDeco` `noAeroportDeco` INT( 11 ) NOT NULL ,
CHANGE `labelAeroportAtte` `noAeroportAtte` INT( 11 ) NOT NULL ;

ALTER TABLE `Vol` CHANGE `labelAeroportAtte` `noAeroportAtte` INT( 11 ) NOT NULL ,
CHANGE `labelAeroportDeco` `noAeroportDeco` INT( 11 ) NOT NULL ;


