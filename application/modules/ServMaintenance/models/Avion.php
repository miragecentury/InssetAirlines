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

    public function __call($name, $arguments) {
        self::initialisation();
    }

    public static function initialisation() {
        if (self::$_mapper === null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_Avion');
        }
    }

    public static function findOne($noAvion) {
        return self::$_mapper->find($noAvion);
    }

    public static function findAll() {
        return self::$_mapper->findAll();
    }

    public static function findAllByModele($noModele) {
        return self::$_mapper->findAllByModele($noModele);
    }

    public static function del($noAvion) {
        try {
            self::$_mapper->delete('noAvion', $noAvion);
        } catch (Exception $e) {
            echo self::$message . $e->getMessage() . '<br/>';
            return FALSE;
        }
    }

    //**************************************************************************

    public function del() {
        return self::del($this->_noAvion);
    }

    public function save() {
        return self::$_mapper->save($this, 'noModele');
    }

    /*
     *  Getter / Setter
     */

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
    }

    public function get_nbPlaceMax() {
        return $this->_nbPlaceMax;
    }

    public function set_nbPlaceMax($_nbPlaceMax) {
        $this->_nbPlaceMax = $_nbPlaceMax;
    }

    public function get_nbHeureVol() {
        return $this->_nbHeureVol;
    }

    public function set_nbHeureVol($_nbHeureVol) {
        $this->_nbHeureVol = $_nbHeureVol;
    }

    public function get_nbIncident() {
        return $this->_nbIncident;
    }

    public function set_nbIncident($_nbIncident) {
        $this->_nbIncident = $_nbIncident;
    }

    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
    }

    public function get_dateMiseService() {
        return $this->_dateMiseService;
    }

    public function set_dateMiseService($_dateMiseService) {
        $this->_dateMiseService = $_dateMiseService;
    }

    public function get_dateMiseHorsService() {
        return $this->_dateMiseHorsService;
    }

    public function set_dateMiseHorsService($_dateMiseHorsService) {
        $this->_dateMiseHorsService = $_dateMiseHorsService;
    }

    public function get_enService() {
        return $this->_enService;
    }

    public function set_enService($_enService) {
        $this->_enService = $_enService;
    }

    public function get_noModele() {
        return $this->_noModele;
    }

    public function set_noModele($_noModele) {
        $this->_noModele = $_noModele;
    }

}

?>