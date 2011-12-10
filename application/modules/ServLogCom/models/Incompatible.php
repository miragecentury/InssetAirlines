<?php

class ServLogCom_Model_Incompatible
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id
     * @var int
     */
    protected $_id;

    /**
     * RegimeAlimentaire
     * @var int
     */
    protected $_idRegimeAlimentaire;

    /**
     * Menu
     * @var int
     */
    protected $_idMenu;

    /**
     * Mapper de l'objet
     * @var ServLogCom_Model_IncompatibleMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Incompatible");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde ou modifie un item
     *
     * @author charles
     * @access public
     *
     */
    public function add()
    {
        $this->_mapper->save($this, 'id');
    }

    /**
     * Suprime un ou plusieurs Incompatible a partir d'une valeur
     *
     * @author charles
     * @access public
     * @param int id
     *
     */
    public function del($id)
    {
        try {
            $this->_mapper->delete('id', $id);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_Incompatible_del() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une association a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServLogCom_Model_Incompatible
     *  
     */
    public function get($id)
    {
        return $this->_mapper->find($id);
    }

    /**
     * Retourne toutes les association a partir d'un idMenu
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $idMenu
     * @return null|ServLogCom_Model_Incompatible
     *  
     */
    public static function getbyMenu($idMenu)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Incompatible");
        try {
            return $mapper->findbyMenu($idMenu);
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }
    
    /**
     * Retourne toutes les association a partir d'un idRegime
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $idRegime
     * @return null|ServLogCom_Model_Incompatible
     *  
     */
    public static function getbyRegime($idRegime)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Incompatible");
        try {
            return $mapper->findbyRegime($idRegime);
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    /**
     * Retourne toutes les association a partir d'un idMenu et d'un îd Regime
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $idMenu $idRegime
     * @return null|ServLogCom_Model_Incompatible
     *  
     */
    public function getbyMenuAndRegime($idMenu, $idRegime)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Incompatible");
        try {
            return $mapper->findbyMenuAndRegime($idMenu, $idRegime);
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_id()
    {
        return $this->_id;
    }

    public function set_id($_id)
    {
        $this->_id = $_id;
        return $this;
    }

    public function set_idRegimeAlimentaire($_idRA)
    {
        $this->_idRegimeAlimentaire = $_idRA;
        return $this;
    }

    public function get_idRegimeAlimentaire()
    {
        return $this->_idRegimeAlimentaire;
    }

    public function get_idMenu()
    {
        return $this->_idMenu;
    }

    public function set_idMenu($_idMenu)
    {
        $this->_idMenu = $_idMenu;
        return $this;
    }

}

?>
