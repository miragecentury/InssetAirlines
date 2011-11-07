<?php

class ServStrategique_Model_DemandeLigne
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de demande de Ligne
     * @var int
     */
    protected $_noDemandeLigne;

    /**
     * label de l'aeroport de depart
     * @var string
     */
    protected $_labelAeroportDeco;

    /**
     * label de l'aeroport d'arrivée
     * @var string
     */
    protected $_labelAeroportAtt;

    /**
     * label du motif de la demande de ligne
     * @var string
     */
    protected $_motif;

    /**
     * Mapper de l'objet
     * @var ServStrategique_Model_DemandedeLigneMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_DemandeLigne");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde une Demande de ligne, selon l'existence ou non du 
     * noDemandeLigne, il est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addDemandeLigne()
    {
        $this->_mapper->save($this, 'noDemandeLigne');
    }
    /**
     * Suprime un ou plusieurs DemandeLigne a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delDemandeLigne($noDemandeLigne)
    {
        try {
            $this->_mapper->delete('noDemandeLigne',$noDemandeLigne);
        } catch (Zend_Exception $e) {
            echo 'ServSrategique_Models_DemandeLigne_delDemandeLigne() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }
    /**
     * Retourne une DemandeLigne a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServPlaning_Model_DemandeLigne
     *  
     */
    public function getDemandeLigne($noDemandeLigne)
    {
        return $this->_mapper->find($noDemandeLigne);
    }

    /**
     * Retourne toutes les DemandeLignes, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_DemandeLigne)
     *  
     */
    public function getListeDemandeLigne()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_DemandeLigne");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noDemandeLigne()
    {
        return $this->_noDemandeLigne;
    }

    public function set_noDemandeLigne($_noDemandeLigne)
    {
        $this->_noDemandeLigne = $_noDemandeLigne;
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

    public function get_labelAeroportAtt()
    {
        return $this->_labelAeroportAtt;
    }

    public function set_labelAeroportAtt($_labelAeroportAtt)
    {
        $this->_labelAeroportAtt = $_labelAeroportAtt;
        return $this;
    }

    public function get_motif()
    {
        return $this->_motif;
    }

    public function set_motif($_motif)
    {
        $this->_motif = $_motif;
        return $this;
    }

}

?>
