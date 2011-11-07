<?php

class Application_Model_TacheMaintenance
{
    protected $_noMaintenance;
    protected $_dateDebut;
    protected $_dateFin;
    protected $_retard;
    protected $_labelTypeMaintenance;
    protected $_noAvion;
    
    public function get_noMaintenance()
    {
        return $this->_noMaintenance;
    }

    public function set_noMaintenance($_noMaintenance) 
    {
        $this->_noMaintenance = $_noMaintenance;
    }

    public function get_dateDebut() 
    {
        return $this->_dateDebut;
    }

    public function set_dateDebut($_dateDebut)
    {
        $this->_dateDebut = $_dateDebut;
    }

    public function get_dateFin()
    {
        return $this->_dateFin;
    }

    public function set_dateFin($_dateFin)
    {
        $this->_dateFin = $_dateFin;
    }

    public function get_retard()
    {
        return $this->_retard;
    }

    public function set_retard($_retard)
    {
        $this->_retard = $_retard;
    }

    public function get_labelTypeMaintenance()
    {
        return $this->_labelTypeMaintenance;
    }

    public function set_labelTypeMaintenance($_labelTypeMaintenance) 
    {
        $this->_labelTypeMaintenance = $_labelTypeMaintenance;
    }

    public function get_noAvion()
    {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) 
    {
        $this->_noAvion = $_noAvion;
    }


}

?>
