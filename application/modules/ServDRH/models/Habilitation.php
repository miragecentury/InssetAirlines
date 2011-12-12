<?php

class ServDRH_Model_Habilitation 
{
    protected $_noHabilitation;
    protected $_labelHabilitation;
    protected $_labelMetier;
    protected $_Modele_label;
    
    public function saveHabilitation() {
        $mapper = new ServDRH_Model_HabilitationMapper();
        $mapper->saveByLabel($this, 'noHabilitation');
    }
    
    public static function getHabilitations(){
        $mapper = new ServDRH_Model_HabilitationMapper();
        return $mapper->findAll();
    }
    
    public function getHabilitationById($noHabilitation){
        $mapper = new ServDRH_Model_HabilitationMapper();
        return $mapper->find($noHabilitation);
    }
    
    public function getHabilitationByLabel($label){
        $mapper = new ServDRH_Model_HabilitationMapper();
        return $mapper->findByLabel($label);
    }
    
    public function delHabilitation($noHabilitation) {
        $mapper = new ServDRH_Model_HabilitationMapper();
        try {
            $mapper->delete('noHabilitation', $noHabilitation);
        } catch (Zend_Exception $e) {
            echo 'ServDRH_Model_EmployeMapper_delEmploye() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();            
        }         
    }
    
    public function get_noHabilitation() 
    {
        return $this->_noHabilitation;
    }

    public function set_noHabilitation($_noHabilitation)
    {
        $this->_noHabilitation = $_noHabilitation;
        return $this;
    }

    public function get_labelHabilitation()
    {
        return $this->_labelHabilitation;
    }

    public function set_labelHabilitation($_labelHabilitation)
    {
        $this->_labelHabilitation = $_labelHabilitation;
        return $this;
    }

    public function get_labelMetier() 
    {
        return $this->_labelMetier;
    }

    public function set_labelMetier($_labelMetier)
    {
        $this->_labelMetier = $_labelMetier;
        return $this;
    }

    public function get_Modele_label() 
    {
        return $this->_Modele_label;
    }

    public function set_Modele_label($_Modele_label)
    {
        $this->_Modele_label = $_Modele_label;
        return $this;
    }


}

?>
