<?php

class ServMaintenance_Model_Constructeur {

    protected $_noConstructeur;
    protected $_label;
    protected $_noAdresse;
    protected static $_mapper = null;

    public static function initialisation() {
        if (self::$_mapper === null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_Constructeur');
        }
    }

    public static function GetAll() {
        self::initialisation();
        return self::$_mapper->findAll();
    }

    public static function FindOne($noConstructeur) {
        self::initialisation();
        return self::$_mapper->find($noConstructeur);
    }

    public static function delConstructeur($noConstructeur) {
        try {
            self::$_mapper->delete('noConstructeur', $noConstructeur);
        } catch (Zend_Exception $e) {
            echo 'ServMaintenance_Model_Constructeur_delConstructeur() 
                Exception - ' .
            $e->getMessage();
        }
    }

    /*     * *********************************************************************** */

    public function Del() {
        return self::delConstructeur($this->_noConstructeur);
    }

    public function Save() {
        self::initialisation();
        return self::$_mapper->save($this, 'noConstructeur');
    }

    /*
     *  Getter / Setter
     */

    public function get_noConstructeur() {
        return $this->_noConstructeur;
    }

    public function set_noConstructeur($_noConstructeur) {
        $this->_noConstructeur = $_noConstructeur;
        return $this;
    }

    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
        return $this;
    }

    public function get_noAdresse() {
        return $this->_noAdresse;
    }

    public function set_noAdresse($_noAdresse) {
        $this->_noAdresse = $_noAdresse;
        return $this;
    }

}

?>
