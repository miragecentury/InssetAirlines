<?php
class ServDRH_Model_Metier 
{
    protected $_labelMetier;
    
     public function getMetiers(){
        $mapper = new ServDRH_Model_MetierMapper();
        return $mapper->findAll();
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


}

?>
