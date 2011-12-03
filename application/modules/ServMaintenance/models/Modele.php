<?php

class ServMaintenance_Model_Modele {

    protected $_noModele;
    protected $_label;
    protected $_rayonAction;
    protected $_distMinAtt;
    protected $_distMinDec;
    protected $_dateLancement;
    protected $_noConstructeur;
    private static $_mapper = null;
    private static $message = 'ServMaitenance_Model_Modele Exception:';

    public static function initialisation() {
        if (self::$_mapper === null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServMaintenance_Model_Modele");
        }
    }

    public static function getAll() {
        self::initialisation();
        return self::$_mapper->findAll();
    }

    public static function findOne($noModele) {
        self::initialisation();
        return self::$_mapper->find($noModele);
    }

    public static function delModele($noModele) {
        self::initialisation();
        try {
            self::$_mapper->delete('noModele', $noModele);
        } catch (Exception $e) {
            echo self::$message . $e->getMessage() . '<br/>';
        }
    }

    /*     * *********************************************************************** */

    public function save() {
        self::initialisation();
        self::$_mapper->save($this, 'noModele');
    }

    public function del() {
        self::delModele($this->_noModele);
    }

    /*
     * Getter / Setter
     */

    public function get_noModele() {
        return $this->_noModele;
    }

    public function set_noModele($_noModele) {
        $this->_noModele = $_noModele;
        return $this;
    }

    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
        return $this;
    }

    public function get_rayonAction() {
        return $this->_rayonAction;
    }

    public function set_rayonAction($_rayonAction) {
        $this->_rayonAction = $_rayonAction;
        return $this;
    }

    public function get_distMinAtt() {
        return $this->_distMinAtte;
    }

    public function set_distMinAtt($_distMinAtte) {
        $this->_distMinAtte = $_distMinAtte;
        return $this;
    }

    public function get_distMinDec() {
        return $this->_distMinDec;
    }

    public function set_distMinDec($_distMinDec) {
        $this->_distMinDec = $_distMinDec;
        return $this;
    }

    public function get_dateLancement() {
        return $this->_dateLancement;
    }

    public function set_dateLancement($_dateLancement) {
        $this->_dateLancement = $_dateLancement;
        return $this;
    }

    public function get_noConstructeur() {
        return $this->_labelConstructeur;
    }

    public function set_noConstructeur($_labelConstructeur) {
        $this->_labelConstructeur = $_labelConstructeur;
        return $this;
    }

}

?>
