<?php

class ServCommercial_Model_Place
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de la place
     * @var int
     */
    protected $_noPlace;

    /**
     * numero de l'agence
     * @var int
     */
    protected $_noAgence;

    /**
     * numero de la personne
     * @var int
     */
    protected $_Personne_noPersonne;

    /**
     * numero du vol
     * @var int
     */
    protected $_noVol;

    /**
     * Mapper de l'objet
     * @var ServCommercial_Model_PlaceMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Place");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute ou modifie une place dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addPlace()
    {
        $this->_mapper->save($this, 'noPlace');
    }
    
    /**
     * Suprime une agence a partir de son noPlace
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delPlace($noPlace)
    {
        try {
            $this->_mapper->delete('noPlace', $noPlace);
        } catch (Zend_Exception $e) {
            echo 'Serv_Commercial_Models_Place_delPlace() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une Place a partir de son noPlace
     * Si elle n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $noPlace
     * @return null|ServCommercial_Model_Place
     *  
     */
    public function getPlace($noPlace)
    {
        return $this->_mapper->find($noPlace);
    }

    /**
     * Retourne tout les places, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_Place)
     *  
     */
    public function getListePlace()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Place");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noPlace()
    {
        return $this->_noPlace;
    }

    public function set_noPlace($_noPlace)
    {
        $this->_noPlace = $_noPlace;
        return $this;
    }

    public function get_noAgence()
    {
        return $this->_noAgence;
    }

    public function set_noAgence($_noAgence)
    {
        $this->_noAgence = $_noAgence;
        return $this;
    }

    public function get_Personne_noPersonne()
    {
        return $this->_Personne_noPersonne;
    }

    public function set_Personne_noPersonne($_Personne_noPersonne)
    {
        $this->_Personne_noPersonne = $_Personne_noPersonne;
        return $this;
    }

    public function get_noVol()
    {
        return $this->_noVol;
    }

    public function set_noVol($_noVol)
    {
        $this->_noVol = $_noVol;
        return $this;
    }

}

?>
