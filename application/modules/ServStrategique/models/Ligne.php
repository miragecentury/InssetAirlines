<?php

class ServStrategique_Model_Ligne
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de Ligne
     * @var int
     */
    protected $_noLigne;

    /**
     * nombre de jours entre deux vol sur cette ligne
     * @var int
     */
    protected $_jours;

    /**
     * nombre de semaines entre deux vol sur cette ligne
     * @var int
     */
    protected $_semaines;

    /**
     * nombre de mois entre deux vol sur cette ligne
     * @var int
     */
    protected $_mois;

    /**
     * nombre d'années entre deux vol sur cette ligne
     * @var int
     */
    protected $_annees;

    /**
     * label de l'aeroport de depart
     * @var string
     */
    protected $_labelAeroportDeco;

    /**
     * label de l'aeroport d'arrivee
     * @var string
     */
    protected $_labelAeroportAtte;

    /**
     * Mapper de l'objet
     * @var ServStrategique_Model_LigneMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde une  ligne, selon l'existence ou non du noLigne,
     * il est ajouté ou modifié
     *
     * @author charles,pewho
     * @access public
     *
     */
    public function addLigne()
    {
        try{
        $this->_mapper->save($this, 'noLigne');
        return true;
        } catch (Spesx_Mapper_Exception $e){
            Spesx_Log::log('addligne Exception - ' .
            $e->getMessage() . ' - ' .
            $e->getPrevious()->getMessage(),
            Zend_Log::ERR);
            return false;
        }
    }

    /**
     * Suprime un ou plusieurs Ligne a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delLigne($noLigne)
    {
        try {
            $this->_mapper->delete('noLigne',$noLigne);
            return true;
        } catch (Zend_Exception $e) {
            echo 'ServSrategique_Models_Ligne_delLigne()
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
            return false;
        }
    }

    /**
     * Retourne une Ligne a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     *
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServPlaning_Model_Ligne
     *
     */
    public static function getLigne($noLigne)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        return $mapper->find($noLigne);
    }

    /**
     * Retourne toutes les Lignes, null si il n'y en as pas dans la BD
     *
     * @access public
     * @author charles
     * @return null|array(Application_Model_Ligne)
     *
     */
    public static function getListeLigne()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------

    public function get_noLigne()
    {
        return $this->_noLigne;
    }

    public function set_noLigne($_noLigne)
    {
        $this->_noLigne = $_noLigne;
        return $this;
    }

    public function get_jours()
    {
        return $this->_jours;
    }

    public function set_jours($_jours)
    {
        $this->_jours = $_jours;
        return $this;
    }

    public function get_semaines()
    {
        return $this->_semaines;
    }

    public function set_semaines($_semaines)
    {
        $this->_semaines = $_semaines;
        return $this;
    }

    public function get_mois()
    {
        return $this->_mois;
    }

    public function set_mois($_mois)
    {
        $this->_mois = $_mois;
        return $this;
    }

    public function get_annees()
    {
        return $this->_annees;
    }

    public function set_annees($_annees)
    {
        $this->_annees = $_annees;
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

    public function get_labelAeroportAtte()
    {
        return $this->_labelAeroportAtte;
    }

    public function set_labelAeroportAtte($_labelAeroportAtte)
    {
        $this->_labelAeroportAtte = $_labelAeroportAtte;
        return $this;
    }

}

?>
