<?php

class ServDRH_Model_TypeConge 
{
    protected $_labelTypeConge;
    
     public function getTypeConges(){
        $mapper = new ServDRH_Model_TypeCongeMapper();
        return $mapper->findAll();
    }
    
    
    public function get_labelTypeConge() {
        return $this->_labelTypeConge;
        
    }

    public function set_labelTypeConge($_labelTypeConge) {
        $this->_labelTypeConge = $_labelTypeConge;
        return $this;
    }


}

?>
