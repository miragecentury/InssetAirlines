<?php

/**
 * 
 * 
 */
class ServPlaning_Model_Vol {
    //le vol est ok;
    const ETAT_OK = 0;

    //Etat entraînant une NOTICE aux futurs passagés et au Serv Exploitation  
    const ETAT_RETARD_DE = 1;
    const ETAT_RETARD_AT = 6;

    //Etat entraînant une alerte au service Planning
    const ETAT_NOAVION = 3;
    const ETAT_MQ_PERSONNEL = 4;

    //Vol dont les traitements sont finis (sauf calcul heure personnel DRH)
    const ETAT_ANNULE = 2;
    const ETAT_EFFECTUER = 5;

//--------------------------------------------------------------------------
//Attributs
//--------------------------------------------------------------------------
    /**
     * numero du vol
     * @var int
     */
    protected $_noVol;

    /**
     * label du vol
     * @var string
     */
    protected $_labelvol;

    /**
     * label de l'aeroport d'arrivée
     * @var string
     */
    protected $_noAeroportAtte;

    /**
     * label de depart
     * @var string
     */
    protected $_noAeroportDeco;

    /**
     * numero de l'avion
     * @var int
     */
    protected $_noAvion;

    /**
     * numero de la ligne
     * @var int
     */
    protected $_noLigne;

    /**
     * heure de decollage
     * @var int
     */
    protected $_heuredecollage;

    /**
     * heure d'atterissage
     * @var int
     */
    protected $_heureAtterissage;
    protected $_etat;

    /**
     * Mapper de l'objet
     * @var ServPlaning_Model_VolMapper
     */
    private static $_mapper;

    public static function init() {
        if (self::$_mapper === null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        }
    }

//--------------------------------------------------------------------------
// Methodes
//--------------------------------------------------------------------------
//******************************************************************************
//public static

    public static function getVolsByAvion($noAvion) {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        return self::$_mapper->getVolsByAvion($noAvion);
    }

    public static function IsEnVolByAvionOnCurrentTime($noAvion) {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        $vols = self::$_mapper->getVolsByAvionOnCurrentTime($noAvion);
        if (count($vols) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function getVolByAvionOnCurrentTime($noAvion) {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        $vols = self::$_mapper->getVolsByAvionOnCurrentTime($noAvion);
        if (count($vols) == 1) {
            return $vols[0];
        } else {
            return FALSE;
        }
    }

    public static function getSemaineAheadFromCurrent($nbrSemaine) {
        $date = new DateTime(date(DATE_ATOM));
        $date->modify('Monday this week');
        if (is_int($nbrSemaine) && $nbrSemaine > 0) {
            $semaine = '+' . $nbrSemaine . ' week';
            $date->modify($semaine);
        } else if ($nbrSemaine == 0) {
            
        } else {
            return null;
        }
        $date->setTime(0, 0, 0);
        return $date->format(DATE_ATOM);
    }

    public static function repercutionMiseHorsServiceAvion($noAvion, $DateTime) {
        $End = self::getSemaineAheadFromCurrent(5);
        if ($DateTime instanceof DateTime) {
            $Start = $DateTime;
        } elseif (is_string($DateTime)) {
            
        } else {
            return FALSE;
        }
    }

    public static function getJourFromWeek($weekDate, $jour) {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }

        switch ($jour) {
            case 1:
                return $date->format(DATE_ATOM);
            case 2:
                $date->modify('tuesday');
                return $date->format(DATE_ATOM);
            case 3:
                $date->modify('wednesday');
                return $date->format(DATE_ATOM);
            case 4:
                $date->modify('thursday');
                return $date->format(DATE_ATOM);
            case 5:
                $date->modify('friday');
                return $date->format(DATE_ATOM);
            case 6:
                $date->modify('saturday');
                return $date->format(DATE_ATOM);
            case 7:
                $date->modify('sunday');
                return $date->format(DATE_ATOM);
            default:
                return null;
        }
    }

    public static function getMoisFromWeek($weekDate) {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }
        $date->modify('first day of this month');
        return $date->format(DATE_ATOM);
    }

    public static function getAnneeFromWeek($weekDate) {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }
        $date->setDate($date->format('Y'), 1, 1);
        return $date->format(DATE_ATOM);
    }

    /**
     * recupération des vols du jour courant
     *
     * @access public
     * @static
     * @return array(ServPlaning_Model_Vol)
     */
    public static function getVolsDuJour() {
        //création des dates butoirs
        //butoir gauche aujourd'hui minuit
        $dateStart = new DateTime(date(DATE_ATOM));
        $dateStart->setTime(0, 0, 0);
        //butoir droite demain minuit
        $dateStop = $dateStart;
        $dateStop->modify('tomorrow');

        //recupération des vols
        //mapper
        if (self::$_mapper == null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        }
        //recup de la liste
        if (($return = self::$_mapper->findAllVolsInInterval($dateStart, $dateStop)) != false) {
            return $return;
        } else {
            return null;
        }
    }

//******************************************************************************
//private static
//******************************************************************************
//public
//******************************************************************************
//private

    /**
     * Ajoute ou modifie un vol dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addVol() {
        self::$_mapper->save($this, 'noVol');
    }

    public function addRetardDecollage($nbHeure, $nbMinute) {
        $date = new DateTime($this->get_heureAtterissage());
        $date->modify("+" . $nbHeure . " hour +" . $nbMinute . " min");
    }

    public function addRetardAtterissage($nbHeure, $nbMinute) {
        
    }

    public function deroute($noAeroportAtterissage) {
        
    }

    public function annule() {
        
    }

    /**
     * Suprime un vol a partir de son noVol
     *
     * @author charles
     * @access public
     * @param string $noVol
     *
     */
    public function delVol($noVol) {
        try {
            self::$_mapper->delete('noVol', $noVol);
        } catch (Zend_Exception $e) {
            echo 'ServPlaning_Models_Vol_delVol()
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un vol a partir de son noVol.
     * S'il n'existe pas, retourne null.
     *
     * @access public
     * @author charles
     * @param int $noVol
     * @return null|ServPlaning_Model_Vol
     *
     */
    public function getVol($noVol) {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        return self::$_mapper->find($noVol);
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noVol() {
        return $this->_noVol;
    }

    public function set_noVol($_noVol) {
        $this->_noVol = $_noVol;
        return $this;
    }

    public function get_labelvol() {
        return $this->_labelvol;
    }

    public function set_labelvol($_labelvol) {
        $this->_labelvol = $_labelvol;
        return $this;
    }

    public function get_noAeroportAtte() {
        return $this->_noAeroportAtte;
    }

    public function set_noAeroportAtte($_labelAeroportAtte) {
        $this->_noAeroportAtte = $_labelAeroportAtte;
        return $this;
    }

    public function get_noAeroportDeco() {
        return $this->_noAeroportDeco;
    }

    public function set_noAeroportDeco($_labelAeroportDeco) {
        $this->_noAeroportDeco = $_labelAeroportDeco;
        return $this;
    }

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
        return $this;
    }

    public function get_noLigne() {
        return $this->_noLigne;
    }

    public function set_noLigne($_noLigne) {
        $this->_noLigne = $_noLigne;
        return $this;
    }

    public function get_heuredecollage() {
        return $this->_heuredecollage;
    }

    public function set_heuredecollage($_heuredecollage) {
        $this->_heuredecollage = $_heuredecollage;
        return $this;
    }

    public function get_heureAtterissage() {
        return $this->_heureAtterissage;
    }

    public function set_heureAtterissage($_heureAtterissage) {
        $this->_heureAtterissage = $_heureAtterissage;
        return $this;
    }

    public function set_etat($_etat) {
        $this->_etat = $_etat;
        return $this;
    }

    public function get_etat() {
        return $this->get_etat();
    }

}

?>
