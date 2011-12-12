<?php

class ServLogCom_Model_EstCommande
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
     * Menu
     * @var int
     */
    protected $_idMenu;

    /**
     * Commande Nourriture
     * @var int
     */
    protected $_noCommandeNourriture;

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
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_EstCommande");
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
        return $this->_mapper->save($this, 'id');
    }

    /**
     * Suprime un ou plusieurs EstCommande a partir d'une valeur
     *
     * @author charles
     * @access public
     * @param int id
     *
     */
    public function del($id)
    {
        try {
            return $this->_mapper->delete('id', $id);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_EstCommande_del() 
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
     * @return null|ServLogCom_Model_EstCommande
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
     * @return null|ServLogCom_Model_EstCommande
     *  
     */
    public static function getbyMenu($idMenu)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_EstCommande");
        try {
            return $mapper->findbyMenu($idMenu);
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }
    
    /**
     * Retourne toutes les association a partir d'un idCommande
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $idCommande
     * @return null|ServLogCom_Model_EstCommande
     *  
     */
    public static function getbyCommande($idCommande)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_EstCommande");
        try {
            return $mapper->findbyCommande($idCommande);
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
    public function getbyMenuAndCommande($idMenu, $idCommande)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_EstCommande");
        try {
            return $mapper->findbyMenuAndCommande($idMenu, $idCommande);
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

    public function set_idMenu($_id)
    {
        $this->_idMenu = $_id;
        return $this;
    }

    public function get_idMenu()
    {
        return $this->_idMenu;
    }

    public function get_noCommandeNourriture()
    {
        return $this->_noCommandeNourriture;
    }

    public function set_noCommandeNourriture($_idCommande)
    {
        $this->_noCommandeNourriture = $_idCommande;
        return $this;
    }

}

?>
