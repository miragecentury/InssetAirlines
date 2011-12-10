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