<?php

class ServPlaning_Model_Vol
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero du vol
     * @var int
     */
    protected $_noVol;

    /**
     * label du vol
     * @var string
     */
    protected $_labelvol;

    /**
     * label de l'aeroport d'arrivée
     * @var string
     */
    protected $_labelAeroportAtte;

    /**
     * label de depart
     * @var string
     */
    protected $_labelAeroportDeco;

    /**
     * numero de l'avion
     * @var int
     */
    protected $_noAvion;

    /**
     * numero de la ligne
     * @var int
     */
    protected $_noLigne;

    /**
     * heure de decollage
     * @var int
     */
    protected $_heuredecollage;

    /**
     * heure d'atterissage
     * @var int
     */
    protected $_heureAtterissage;

    /**
     * Mapper de l'objet
     * @var ServPlaning_Model_VolMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute ou modifie un vol dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addVol()
    {
        $this->_mapper->save($this, 'noVol');
    }

    /**
     * Suprime un vol a partir de son noVol
     *
     * @author charles
     * @access public
     * @param string $noVol
     *
     */
    public function delVol($noVol)
    {
        try {
            $this->_mapper->delete('noVol', $noVol);
        } catch (Zend_Exception $e) {
            echo 'ServPlaning_Models_Vol_delVol() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un vol a partir de son noVol.
     * S'il n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $noVol
     * @return null|ServPlaning_Model_Vol
     *  
     */
    public function getVol($noVol)
    {
        return $this->_mapper->find($noVol);
    }

    /**
     * Retourne tous les vols, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_Vol)
     *  
     */
    public static function getListeVol()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    /**
     * Retourne tous les vol sous forme de select, retourne un select vide si
     * il n'y en a pas
     * 
     * @access public
     * @author charles
     * @param string $name, string $label
     * @return Zend_Form_Element_Select
     *  
     */
    public static function getSelectVol($name, $label)
    {
        try {
            $Vols = ServPlaning_Model_Vol::getListeVol();
            $noVol = new Zend_Form_Element_Select($name);
            foreach ($Vols as $Vol) {
                $noVol->addMultiOption($Vol->get_noVol(), 
                    $Vol->get_noVol());
            }
            $noVol->setRequired();
            $noVol->setLabel($label);
            return $noVol;
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noVol()
    {
        return $this->_noVol;
    }

    public function set_noVol($_noVol)
    {
        $this->_noVol = $_noVol;
        return $this;
    }

    public function get_labelvol()
    {
        return $this->_labelvol;
    }

    public function set_labelvol($_labelvol)
    {
        $this->_labelvol = $_labelvol;
        return $this;
    }

    public function get_labelAeroportAtte()
    {
        return $this->_labelAeroportAtte;
    }

    public function set_labelAeroportAtte($_labelAeroportAtte)
    {
        $this->_labelAeroportAtte = $_labelAeroportAtte;
        return $this;
    }

    public function get_labelAeroportDeco()
    {
        return $this->_labelAeroportDeco;
    }

    public function set_labelAeroportDeco($_labelAeroportDeco)
    {
        $this->_labelAeroportDeco = $_labelAeroportDeco;
        return $this;
    }

    public function get_noAvion()
    {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion)
    {
        $this->_noAvion = $_noAvion;
        return $this;
    }

    public function get_noLigne()
    {
        return $this->_noLigne;
    }

    public function set_noLigne($_noLigne)
    {
        $this->_noLigne = $_noLigne;
        return $this;
    }

    public function get_heuredecollage()
    {
        return $this->_heuredecollage;
    }

    public function set_heuredecollage($_heuredecollage)
    {
        $this->_heuredecollage = $_heuredecollage;
        return $this;
    }

    public function get_heureAtterissage()
    {
        return $this->_heureAtterissage;
    }

    public function set_heureAtterissage($_heureAtterissage)
    {
        $this->_heureAtterissage = $_heureAtterissage;
        return $this;
    }

}

?>
