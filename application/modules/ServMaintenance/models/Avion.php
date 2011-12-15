<?php

class ServMaintenance_Model_Avion {
    /**
     * Intervale entre de Vol ou Maintenance Obligatoire pour un avion
     */
    const IntervalTraitement = 10;

    const ETAT_ENSERVICE = 0;
    const ETAT_ATT_HORSERVICE = 1;
    const ETAT_HORSSERVICE = 2;


    protected $_noAvion;
    protected $_nbPlaceMax;
    protected $_nbHeureVol;
    protected $_nbIncident;
    protected $_label;
    protected $_dateMiseService;
    protected $_dateMiseHorsService;
    protected $_enService;
    protected $_noModele;
    protected static $_mapper = null;
    protected static $message = 'ServMaintenance_Model_Avion : ';

//**************************************************************************
//public static

    public static function initialisation() {
        if (self::$_mapper === null) {
            if (($mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_Avion')) instanceof ServMaintenance_Model_AvionMapper) {
                self::$_mapper = $mapper;
            }
        }
    }

    public function __construct() {
        self::initialisation();
    }

//**************************************************************************

    public static function changementJour() {
        self::initialisation();
        $lstAmettreHorsService = self::$_mapper->findAllForMiseHorsServiceAtCurrentTime();
        if (count($lstAmettreHorsService) > 0) {
            foreach ($lstAmettreHorsService as $avion) {
                if ($avion instanceof ServMaintenance_Model_Avion) {
                    $avion->set_enService(ServMaintenance_Model_Avion::ETAT_HORSSERVICE);
                    $avion->save();
                }
            }
        }

//**********************************************************************
//**********************************************************************

        $DateStart = new DateTime(date(DATE_ATOM));
        $DateStart->modify('-1 day');
        $DateStart->setTime(0, 0, 0);

        $lstOK = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($DateStart, new DateTime(date(DATE_ATOM)), ServPlaning_Model_Vol::ETAT_OK);
        $lstRetardD = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($DateStart, new DateTime(date(DATE_ATOM)), ServPlaning_Model_Vol::ETAT_RETARD_AT);
        $lstRetardA = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($DateStart, new DateTime(date(DATE_ATOM)), ServPlaning_Model_Vol::ETAT_RETARD_DE);
        $lstOK = array_merge($lstOK, $lstRetardA, $lstRetardD);
//mettre à finir

        if (is_array($lstOK) && (count($lstOK) > 0)) {
            foreach ($lstOK as $vol) {
                if ($vol instanceof ServPlaning_Model_Vol) {
                    $avion = ServMaintenance_Model_Avion::findOne($vol->get_noAvion());
                    if ($avion instanceof ServMaintenance_Model_Avion) {
                        $start = new DateTime($vol->get_heuredecollage());
                        $end = new DateTime($vol->get_heureAtterissage());
                        $diff = $end->diff($start, TRUE);
                        $avion->addHeureVol($diff->h);
                        $vol->set_etat(ServPlaning_Model_Vol::ETAT_EFFECTUER);
                        $vol->save();
                    }
                }
            }
        }
//**********************************************************************

        $lstIncident = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($DateStart, new DateTime(date(DATE_ATOM)), ServPlaning_Model_Vol::ETAT_NOAVION);
        $lstIncident1 = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($DateStart, new DateTime(date(DATE_ATOM)), ServPlaning_Model_Vol::ETAT_MQ_PERSONNEL);
        $lstIncident = array_merge($lstIncident, $lstIncident1);
//mettre en annules
        if (is_array($lstIncident) && (count($lstIncident) > 0)) {
            foreach ($lstIncident as $vol) {
                if ($vol instanceof ServPlaning_Model_Vol) {
                    $vol->set_etat(ServPlaning_Model_Vol::ETAT_ANNULE);
                    $vol->save();
                }
            }
        }
//**********************************************************************
//**********************************************************************
        return TRUE;
    }

    public static function changementSemaine() {
        self::initialisation();
        return TRUE;
    }

    /**
     * Fonction retournant l'avion correspondant à l'id passé en paramètre
     * @param int $noAvion
     * @return null|ServMaintenance_Model_Avion
     * @author VANROYE Victorien
     */
    public static function findOne($noAvion) {
        self::initialisation();
        return self::$_mapper->find($noAvion);
    }

    public static function findAll() {
        self::initialisation();
        return self::$_mapper->findAll();
    }

    /**
     * Fonction renvoyant les Appareils en Service au moment de l'appel
     * 
     * @return Array(ServMaintenance_Model_Avion)|null
     * @author VANROYE Victorien
     */
    public static function findAllEnServiceAtCurrentTime() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllServiceAtCurrentTime(array(self::ETAT_ENSERVICE, self::ETAT_ATT_HORSERVICE)))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function findAllEnServiceAtDateTime(DateTime $start, DateTime $end) {
        self::initialisation();
        return self::$_mapper->findAllEnServiceAtDateTimeInterval($start, $end);
    }

    public static function finAllEnServiceForMiseHorsServiceAtCurrentTime() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllServiceAtCurrentTime(array(self::ETAT_ENSERVICE)))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function findAllHorsServiceAtCurrentTime() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllServiceAtCurrentTime(array(self::ETAT_HORSSERVICE)))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function miseHorsServiceAtDateTime($Date, $noAvion) {
        self::initialisation();
        if (is_string($Date)) {
            $DateHorsService = new DateTime($Date);
        } elseif ($Date instanceof DateTime) {
            $DateHorsService = $Date;
        } else {
            return FALSE;
        }
        $DateHorsService->setTime(0, 0, 0);
        $DateHorsService = $DateHorsService->format(DATE_ATOM);
        $CurrentDate = new DateTime();
        $Border = ServPlaning_Model_Vol::getSemaineAheadFromCurrent(5);
        var_dump($Border);
        if ($DateHorsService < ServPlaning_Model_Vol::getSemaineAheadFromCurrent(5)) {
            echo 'inférieur à 5 Semaines';
//enlever les maintenances dépassant la date de mise hors service
//générer des erreurs etc... au niveau des vols
        } else {
//enlever les maintenances dépassant la date de mise hors service
        }
    }

    public static function findAllHorsService() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllServiceAtCurrentTime(array(self::ETAT_HORSSERVICE)))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function findAllByModele($noModele) {
        self::initialisation();
        return self::$_mapper->findAllByModele($noModele);
    }

    public static function delById($noAvion) {
        self::initialisation();
        try {
            self::$_mapper->delete('noAvion', $noAvion);
        } catch (Exception $e) {
            echo self::$message . $e->getMessage() . '<br/>';
            return FALSE;
        }
    }

//**************************************************************************

    public static function IsEnMaintenanceAtCurrentTime($noAvion) {
        self::initialisation();
        if (count(ServMaintenance_Model_TacheMaintenance::findOneByAvionAtCurrentTime($noAvion)) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param int $noAvion
     * @param DateTime|String $Date
     * @return type 
     */
//**************************************************************************

    public function addHeureVol($nbHeureVol) {
        $nbHeureVol = $this->get_nbHeureVol() + $nbHeureVol;
        $this->set_nbHeureVol($nbHeureVol);
        $this->save();
    }

    /**
     *
     * @param DateTime|String(DATE_ATOM) $Date 
     */
    public function miseHorsServiceAt($Date) {
        return self::miseHorsServiceAtDateTime($Date, $this->_noAvion);
    }

    public function del() {
        self::initialisation();
        return self::del($this->_noAvion);
    }

    public function save() {
        self::initialisation();
        return self::$_mapper->save($this, 'noAvion');
    }

    public function isDipos() {
        if ($this->isEnVol()) {
            return 1;
        } else if ($this->isEnMaintenance()) {
            return 2;
        } else {
            return FALSE;
        }
    }

    public function isEnVol() {
        return ServPlaning_Model_Vol::IsEnVolByAvionOnCurrentTime($this->_noAvion);
    }

    /**
     * Retourne un Bool pour savoir si l'avion est en Maintenance ou non 
     * 
     * @return Bool
     * @author VANROYE Victorien
     */
    public function isEnMaintenance() {
        self::initialisation();
        if ($this->_enService != self::ETAT_HORSERVICE) {
            $TachesMaintenance = ServMaintenance_Model_TacheMaintenance::findOneByAvionAtCurrentTime($this->_noAvion);
            if ($TachesMaintenance != null && $TachesMaintenance instanceof ServMaintenance_Model_TacheMaintenance) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_labelStatus() {
        
    }

//**************************************************************************
// *  Getter / Setter
//**************************************************************************

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
        return $this;
    }

    public function get_nbPlaceMax() {
        return $this->_nbPlaceMax;
    }

    public function set_nbPlaceMax($_nbPlaceMax) {
        $this->_nbPlaceMax = $_nbPlaceMax;
        return $this;
    }

    public function get_nbHeureVol() {
        return $this->_nbHeureVol;
    }

    public function set_nbHeureVol($_nbHeureVol) {
        $this->_nbHeureVol = $_nbHeureVol;
        return $this;
    }

    public function get_nbIncident() {
        return $this->_nbIncident;
    }

    public function set_nbIncident($_nbIncident) {
        $this->_nbIncident = $_nbIncident;
        return $this;
    }

    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
        return $this;
    }

    public function get_dateMiseService() {
        return $this->_dateMiseService;
    }

    public function set_dateMiseService($_dateMiseService) {
        $this->_dateMiseService = $_dateMiseService;
        return $this;
    }

    public function get_dateMiseHorsService() {
        return $this->_dateMiseHorsService;
    }

    public function set_dateMiseHorsService($_dateMiseHorsService) {
        $this->_dateMiseHorsService = $_dateMiseHorsService;
        return $this;
    }

    public function get_enService() {
        return $this->_enService;
    }

    public function set_enService($_enService) {
        $this->_enService = $_enService;
        return $this;
    }

    public function get_noModele() {
        return $this->_noModele;
    }

    public function set_noModele($_noModele) {
        $this->_noModele = $_noModele;
        return $this;
    }

}

?>