<?php

class ServLogCom_Model_RegimeAlimentaire
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * label du regimeAlimentaire
     * @var string
     */
    protected $_labelRegimeAlimentaire;

    /**
     * Mapper de l'objet
     * @var ServLogCom_Model_RegimeAlimentaireMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_RegimeAlimentaire");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde un RegimeAlimentaire, selon l'existence ou non du 
     * labelRegimeAlimentaire, il est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addRegimeAlimentaire()
    {
        $this->_mapper->save($this, 'labelRegimeAlimentaire');
    }

    /**
     * Suprime un ou plusieurs RegimeAlimentaire a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delRegimeAlimentaire($labelRegimeAlimentaire)
    {
        try {
            $this->_mapper->delete('labelRegimeAlimentaire', $labelRegimeAlimentaire);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_RegimeAlimentaire_delRegimeAlimentaire() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un RegimeAlimentaire a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServLogCom_Model_RegimeAlimentaire
     *  
     */
    public function getRegimeAlimentaire($labelRegimeAlimentaire)
    {
        return $this->_mapper->find($labelRegimeAlimentaire);
    }

    /**
     * Retourne tout les RegimeAlimentaire, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(ServLogCom_Model_RegimeAlimentaire)
     *  
     */
    public function getListeRegimeAlimentaire()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_RegimeAlimentaire");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
        return $return;
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_labelRegimeAlimentaire()
    {
        return $this->_labelRegimeAlimentaire;
    }

    public function set_labelRegimeAlimentaire($_labelRegimeAlimentaire)
    {
        $this->_labelRegimeAlimentaire = $_labelRegimeAlimentaire;
        return $this;
    }

}

?>
