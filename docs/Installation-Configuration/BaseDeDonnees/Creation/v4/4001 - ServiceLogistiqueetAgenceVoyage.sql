DROP TABLE IF EXISTS `Incompatible`;
CREATE TABLE IF NOT EXISTS `Incompatible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idRegimeAlimentaire` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;


DROP TABLE IF EXISTS `EstCommande`;
CREATE TABLE IF NOT EXISTS `EstCommande` (
  `id` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `noCommandeNourriture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Vol_has_Agence`;
CREATE TABLE IF NOT EXISTS `Vol_has_Agence` (
  `idVolHasAgence` int(11) NOT NULL AUTO_INCREMENT,
  `Vol_noVol` int(10) unsigned NOT NULL,
  `Agence_noAgence` int(10) unsigned NOT NULL,
  `nbReservation` int(10) unsigned NOT NULL,
  `enAttentedeTraitement` tinyint(1) NOT NULL DEFAULT '0',
  `valider` tinyint(1) NOT NULL DEFAULT '0',
  `heurePost` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idVolHasAgence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `Place` (
  `noPlace` int(11) NOT NULL AUTO_INCREMENT,
  `noAgence` int(10) unsigned NOT NULL,
  `Personne_noPersonne` int(10) unsigned DEFAULT NULL,
  `noVol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noPlace`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=236 ;
