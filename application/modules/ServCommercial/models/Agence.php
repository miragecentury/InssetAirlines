<?php

class ServCommercial_Model_Agence
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de l'agence
     * @var int
     */
    protected $_noAgence;

    /**
     * label de l'agence
     * @var string
     */
    protected $_labelAgence;

    /**
     * date de lancement
     * @var int
     */
    protected $_dateLancement;

    /**
     * date de cloture
     * @var int
     */
    protected $_dateCloture;

    /**
     * Acces extranet, 0 si inactif, 1 si actif
     * @var bool
     */
    protected $_accesExtranet;

    /**
     * numero de l'adresse
     * @var int
     */
    protected $_noAdresse;

    /**
     * Mapper de l'objet
     * @var ServCommercial_Model_AgenceMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Agence");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute ou modifie une agence dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addAgence()
    {
        $this->_mapper->save($this, 'noAgence');
    }

    /**
     * Suprime une agence a partir de son noIncident
     *
     * @author charles
     * @access public
     * @param int $noAgence
     *
     */
    public function delAgence($noAgence)
    {
        try {
            $this->_mapper->delete('noAgence', $noAgence);
        } catch (Zend_Exception $e) {
            echo 'Serv_Commercial_Models_Agence_delAgence() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une Agence a partir de son noAgence
     * Si elle n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $noAgence
     * @return null|ServCommercial_Model_Agence
     *  
     */
    public function getAgence($noAgence)
    {
        return $this->_mapper->find($noAgence);
    }

    /**
     * Retourne toutes les agences, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_Agence)
     *  
     */
    public static function getListeAgence()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Agence");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noAgence()
    {
        return $this->_noAgence;
    }

    public function set_noAgence($_noAgence)
    {
        $this->_noAgence = $_noAgence;
        return $this;
    }

    public function get_labelAgence()
    {
        return $this->_labelAgence;
    }

    public function set_labelAgence($_labelAgence)
    {
        $this->_labelAgence = $_labelAgence;
        return $this;
    }

    public function get_dateLancement()
    {
        return $this->_dateLancement;
    }

    public function set_dateLancement($_dateLancement)
    {
        $this->_dateLancement = $_dateLancement;
        return $this;
    }

    public function get_dateCloture()
    {
        return $this->_dateCloture;
    }

    public function set_dateCloture($_dateCloture)
    {
        $this->_dateCloture = $_dateCloture;
        return $this;
    }

    public function get_accesExtranet()
    {
        return $this->_accesExtranet;
    }

    public function set_accesExtranet($_accesExtranet)
    {
        $this->_accesExtranet = $_accesExtranet;
        return $this;
    }

    public function get_noAdresse()
    {
        return $this->_noAdresse;
    }

    public function set_noAdresse($_noAdresse)
    {
        $this->_noAdresse = $_noAdresse;
        return $this;
    }

}

?>
