<?php

class Application_Model_Aeroport
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id de l'aéroport
     * @var int
     */
    protected $_noAeroport;

    /**
     * label de l'aéroport
     * @var string
     */
    protected $_labelAeroport;

    /**
     * label de la ville
     * @var string
     */
    protected $_labelVille;

    /**
     * label du pays
     * @var string
     */
    protected $_labelPays;

    /**
     * Mapper de l'objet
     * @var Application_Model_AeroportMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("Application_Model_Aeroport");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------

    /**
     * Sauvegarde un aéroport, selon l'existence ou non du labelAeroport, il est
     * ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addAeroport()
    {
        $this->_mapper->save($this, 'noAeroport');
    }

    /**
     * Suprime un aéroport a partir de son labelAeroport
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delAeroport($noAeroport)
    {
        try {
            $this->_mapper->delete('noAeroport', $noAeroport);
        } catch (Zend_Exception $e) {
            echo 'Application_Models_Aeroport_delAeroport() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un Aeroport a partir de son labelAeroport.
     * S'il n'existe pas, retourne null.
     *
     * @access public
     * @author charles
     * @param string $labelAeroport
     * @return null|Application_Model_Aeroport
     *
     */
    public function getAeroport($noAeroport)
    {
        $return = $this->_mapper->find($noAeroport);
        return $return;
    }
    public static function getStaticAeroport($noAeroport){
        $mapper = Spesx_Mapper_MapperFactory::getMapper("Application_Model_Aeroport");
        $return = $mapper->find($noAeroport);
        return $return;
    }

    /**
     * Retourne tout les aeroports, null si il n'y en as pas dans la BD
     *
     * @access public
     * @author charles
     * @return null|array(Application_Model_Aeroport)
     *
     */
    public static function getListeAeroport()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("Application_Model_Aeroport");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
        return $return;
    }

    /** TO DO
     * GetSelectAeroport a coder en helper
     */

    /**
     * Retourne tous les aeroports sous forme de select, retourne un select
     * vide s'il n'y en a pas
     *
     * @access public
     * @author charles
     * @param string $name, string $label
     * @return Zend_Form_Element_Select
     *
     */
    public static function getSelectAeroport($name, $label)
    {
        try {
            $Aeroports = Application_Model_Aeroport::getListeAeroport();
            $labelAeroport = new Zend_Form_Element_Select($name);
            foreach ($Aeroports as $Aeroport) {
                $labelAeroport->addMultiOption($Aeroport->get_noAeroport(), $Aeroport->get_labelAeroport());
            }
            $labelAeroport->setRequired();
            $labelAeroport->setLabel($label);
            return $labelAeroport;
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noAeroport()
    {
        return $this->_noAeroport;
    }

    public function set_noAeroport($_noAeroport)
    {
        $this->_noAeroport = $_noAeroport;
        return $this;
    }

    public function get_labelAeroport()
    {
        return $this->_labelAeroport;
    }

    public function set_labelAeroport($_labelAeroport)
    {
        $this->_labelAeroport = $_labelAeroport;
        return $this;
    }

    public function get_labelVille()
    {
        return $this->_labelVille;
    }

    public function set_labelVille($_labelVille)
    {
        $this->_labelVille = $_labelVille;
        return $this;
    }

    public function get_labelPays()
    {
        return $this->_labelPays;
    }

    public function set_labelPays($_labelPays)
    {
        $this->_labelPays = $_labelPays;
        return $this;
    }

}

?>
