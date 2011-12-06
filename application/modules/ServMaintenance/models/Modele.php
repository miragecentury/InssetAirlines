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

    public static function GetItemFromRaw($raw) {
        self::initialisation();
        if (
                isset($raw['dateLancement']) && isset($raw['distMinAtt']) && isset($raw['distMinDec']) &&
                isset($raw['label']) && isset($raw['noConstructeur']) &&
                isset($raw['rayonAction'])
        ) {
            $item = new ServMaintenance_Model_Modele();
            $item->set_dateLancement($raw['dateLancement'])
                    ->set_distMinAtt($raw['distMinAtt'])
                    ->set_distMinDec($raw['distMinDec'])
                    ->set_label($raw['label'])
                    ->set_noConstructeur($raw['noConstructeur'])
                    ->set_rayonAction($raw['rayonAction']);

            if (isset($raw['noModele'])) {
                $item->set_noModele($raw['noModele']);
            }
            return $item;
        } else {
            return null;
        }
    }

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
        return $this->_distMinAtt;
    }

    public function set_distMinAtt($_distMinAtt) {
        $this->_distMinAtt = $_distMinAtt;
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
        return $this->_noConstructeur;
    }

    public function set_noConstructeur($_noConstructeur) {
        $this->_noConstructeur = $_noConstructeur;
        return $this;
    }

}

?>
