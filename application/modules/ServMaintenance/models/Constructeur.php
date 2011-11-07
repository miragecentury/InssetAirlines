<?php

class Application_Model_Constructeur
{
    protected $_label;
    protected $_noAdresse;
    
    public function get_label() 
    {
        return $this->_label;
    }

    public function set_label($_label) 
    {
        $this->_label = $_label;
    }

    public function get_noAdresse()
    {
        return $this->_noAdresse;
    }

    public function set_noAdresse($_noAdresse)
    {
        $this->_noAdresse = $_noAdresse;
    }
}

?>
