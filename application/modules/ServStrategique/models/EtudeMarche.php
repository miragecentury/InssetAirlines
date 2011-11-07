<?php

class ServStrategique_Model_EtudeMarche
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero d'étude de marche
     * @var int
     */
    protected $_noEtudeMarche;

    /**
     * label d'etude de marche
     * @var string
     */
    protected $_labelTypeEtudeMarche;

    /**
     * numero de Ligne
     * @var int
     */
    protected $_Ligne_noLigne;

    /**
     * numero de demande de Ligne
     * @var int
     */
    protected $_noDemandeLigne;

    /**
     * Mapper de l'objet
     * @var ServStrategique_Model_EtudeMarcheMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_EtudeMarche");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde une Etude de marche, selon l'existence ou non du 
     * noEtudeMarche, il est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addEtudeMarche()
    {
        $this->_mapper->save($this, 'noEtudeMarche');
    }

    /**
     * Suprime un ou plusieurs EtudeMarche a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delEtudeMarche($noEtudeMarche)
    {
        try {
            $this->_mapper->delete('noEtudeMarche', $noEtudeMarche);
        } catch (Zend_Exception $e) {
            echo 'ServSrategique_Models_EtudeMarche_delEtudeMarche() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une EtudeMarche a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServPlaning_Model_EtudeMarche
     *  
     */
    public function getEtudeMarche($noEtudeMarche)
    {
        return $this->_mapper->find($noEtudeMarche);
    }

    /**
     * Retourne toutes les EtudeMarches, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_EtudeMarche)
     *  
     */
    public function getListeEtudeMarche()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_EtudeMarche");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noEtudeMarche()
    {
        return $this->_noEtudeMarche;
    }

    public function set_noEtudeMarche($_noEtudeMarche)
    {
        $this->_noEtudeMarche = $_noEtudeMarche;
        return $this;
    }

    public function get_labelTypeEtudeMarche()
    {
        return $this->_labelTypeEtudeMarche;
    }

    public function set_labelTypeEtudeMarche($_labelTypeEtudeMarche)
    {
        $this->_labelTypeEtudeMarche = $_labelTypeEtudeMarche;
        return $this;
    }

    public function get_Ligne_noLigne()
    {
        return $this->_Ligne_noLigne;
    }

    public function set_Ligne_noLigne($_Ligne_noLigne)
    {
        $this->_Ligne_noLigne = $_Ligne_noLigne;
        return $this;
    }

    public function get_noDemandeLigne()
    {
        return $this->_noDemandeLigne;
    }

    public function set_noDemandeLigne($_noDemandeLigne)
    {
        $this->_noDemandeLigne = $_noDemandeLigne;
        return $this;
    }

}

?>
