<?php

class ServStrategique_Model_TypeEtudeMarche
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * label type etude marche
     * @var string
     */
    protected $_labelTypeEtudeMarche;

    /**
     * Mapper de l'objet
     * @var ServStrategique_Model_TypeEtudeMarche
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_TypeEtudeMarche");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde un type d'étude de marche, selon l'existence ou non du
     * labelTypeEtudeMarche, il est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addTypeEtudeMarche()
    {
        $this->_mapper->save($this, 'labelTypeEtudeMarche');
    }

    /**
     * Suprime un ou plusieurs TypeEtudeMarche a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delTypeEtudeMarche($labelTypeEtudeMarche)
    {
        try {
            $this->_mapper->delete('labelTypeEtudeMarche', $labelTypeEtudeMarche);
        } catch (Zend_Exception $e) {
            echo 'ServSrategique_Models_TypeEtudeMarche_delTypeEtudeMarche() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne unn TypeEtudeMarche a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param string $id
     * @return null|ServPlaning_Model_TypeEtudeMarche
     *  
     */
    public function getTypeEtudeMarche($labelTypeEtudeMarche)
    {
        return $this->_mapper->find($labelTypeEtudeMarche);
    }

    /**
     * Retourne toutes les TypeEtudeMarches, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_TypeEtudeMarche)
     *  
     */
    public function getListeTypeEtudeMarche()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_TypeEtudeMarche");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------

    public function get_labelTypeEtudeMarche()
    {
        return $this->_labelTypeEtudeMarche;
    }

    public function set_labelTypeEtudeMarche($_labelTypeEtudeMarche)
    {
        $this->_labelTypeEtudeMarche = $_labelTypeEtudeMarche;
        return $this;
    }

}

?>
