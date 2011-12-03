<?php

class ServMaintenance_Model_Modele {
    protected $_label;
    protected $_rayonAction;
    protected $_distMinAtt;
    protected $_distMinDec;
    protected $_dateLancement;
    protected $_labelConstructeur;
    
    public function getModeles(){
        $mapper = new ServMaintenance_Model_ModeleMapper();
        return $mapper->findAll();
    }
    
    public function get_label() {
        return $this->_label;
    }

    public function set_label($_label) {
        $this->_label = $_label;
    }

    public function get_rayonAction() {
        return $this->_rayonAction;
    }

    public function set_rayonAction($_rayonAction) {
        $this->_rayonAction = $_rayonAction;
    }

    public function get_distMinAtt() {
        return $this->_distMinAtt;
    }

    public function set_distMinAtt($_distMinAtt) {
        $this->_distMinAtt = $_distMinAtt;
    }

    public function get_distMinDec() {
        return $this->_distMinDec;
    }

    public function set_distMinDec($_distMinDec) {
        $this->_distMinDec = $_distMinDec;
    }

    public function get_dateLancement() {
        return $this->_dateLancement;
    }

    public function set_dateLancement($_dateLancement) {
        $this->_dateLancement = $_dateLancement;
    }

    public function get_labelConstructeur() {
        return $this->_labelConstructeur;
    }

    public function set_labelConstructeur($_labelConstructeur) {
        $this->_labelConstructeur = $_labelConstructeur;
    }


}

?>
