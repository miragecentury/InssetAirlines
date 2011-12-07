<?php

class ServMaintenance_Model_TacheMaintenance {

    protected $_noMaintenance;
    protected $_dateDebut;
    protected $_dateFin;
    protected $_retard;
    protected $_noTypeMaintenance;
    protected $_noAvion;

    //**************************************************************************
    //public static
    public static function findAll() {
        
    }

    public static function findAllbyTypeMaintenance($TypeMaintenance) {
        
    }

    public static function findOne($noTacheMaintenance) {
        
    }

    public static function findAllatCurrentDay() {
        
    }

    public static function findAllatDateTimeInterval($start, $end) {
        
    }

    //**************************************************************************
    //public
    public function save() {
        
    }

    //**************************************************************************
    //private static
    //**************************************************************************
    //private
    //**************************************************************************
    //  Setter / Getter
    //**************************************************************************

    public function get_noMaintenance() {
        return $this->_noMaintenance;
    }

    public function set_noMaintenance($_noMaintenance) {
        $this->_noMaintenance = $_noMaintenance;
    }

    public function get_dateDebut() {
        return $this->_dateDebut;
    }

    public function set_dateDebut($_dateDebut) {
        $this->_dateDebut = $_dateDebut;
    }

    public function get_dateFin() {
        return $this->_dateFin;
    }

    public function set_dateFin($_dateFin) {
        $this->_dateFin = $_dateFin;
    }

    public function get_retard() {
        return $this->_retard;
    }

    public function set_retard($_retard) {
        $this->_retard = $_retard;
    }

    public function get_noTypeMaintenance() {
        return $this->_noTypeMaintenance;
    }

    public function set_noTypeMaintenance($_noTypeMaintenance) {
        $this->_noTypeMaintenance = $_noTypeMaintenance;
    }

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
    }

}

?>
