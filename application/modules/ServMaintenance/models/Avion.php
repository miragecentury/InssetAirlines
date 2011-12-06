<?php

class ServMaintenance_Model_Avion {

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

    public static function initialisation() {
        if (self::$_mapper === null) {
            if (($mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_Avion')) instanceof ServMaintenance_Model_AvionMapper) {
                self::$_mapper = $mapper;
            } else {
                echo 'Boum!!';
            }
        }
    }

    public static function findOne($noAvion) {
        self::initialisation();
        return self::$_mapper->find($noAvion);
    }

    public static function findAll() {
        self::initialisation();
        return self::$_mapper->findAll();
    }

    public static function findAllDispoAtInterDate($Start, $End) {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllDispoAtInterDate($Start,$End))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function findAllEnService() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllService(TRUE))) == 0) {
            return null;
        } else {
            return $array;
        }
    }

    public static function findAllHorsService() {
        self::initialisation();
        if (count(($array = self::$_mapper->findAllService(FALSE))) == 0) {
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

    public function del() {
        self::initialisation();
        return self::del($this->_noAvion);
    }

    public function save() {
        self::initialisation();
        return self::$_mapper->save($this, 'noModele');
    }

    public function isEnVol() {
        self::initialisation();
        $Vols = ServPlaning_Model_Vol::getVolByAvion($this->get_noAvion());
        var_dump($Vols);
    }

    /*
     *  Getter / Setter
     */

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