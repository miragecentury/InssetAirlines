<?php

class Application_Model_TypeMaintenance
{
    protected $_label;
    protected $_dureeMaintenance;
    
    public function get_label() 
    {
        return $this->_label;
    }

    public function set_label($_label) 
    {
        $this->_label = $_label;
    }

    public function get_dureeMaintenance()
    {
        return $this->_dureeMaintenance;
    }

    public function set_dureeMaintenance($_dureeMaintenance) 
    {
        $this->_dureeMaintenance = $_dureeMaintenance;
    }


}

?>
