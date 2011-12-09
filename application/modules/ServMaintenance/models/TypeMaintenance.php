<?php

class Application_Model_TypeMaintenance {

    protected $_noTypeMaintenance;
    protected $_label;
    protected $_dureeMaintenance;
    protected $_periode;
    protected $_noModele;
    private static $mapper = null;

    private static function init() {
        if (self::$mapper === null) {
            self::$mapper = Spesx_Mapper_MapperFactory::getMapper("ServMaintenance_Model_TypeMaintenance");
        }
    }

    //**************************************************************************
    
    
    
    //**************************************************************************

    /*
     *  Setter / Getter
     */

    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
        return $this;
    }

    public function get_dureeMaintenance() {
        return $this->_dureeMaintenance;
    }

    public function set_dureeMaintenance($dureeMaintenance) {
        $this->_dureeMaintenance = $_dureeMaintenance;
        return $this;
    }

    public function get_noModele() {
        return $this->_noModele;
    }

    public function set_noModele($noModele) {
        $this->_noModele = $noModele;
        return $this;
    }

    public function get_periode() {
        return $this->_periode;
    }

    public function set_periode($periode) {
        $this->_periode = $periode;
        return $this;
    }

    public function get_noTypeMaintenance() {
        return $this->_noTypeMaintenance;
    }

    public function set_noTypeMaintenance($noTypeMaintenance) {
        $this->_noTypeMaintenance;
        return $this;
    }

}

?>
