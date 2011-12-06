<?php

class ServLogCom_Model_Menu
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id du Menu
     * @var int
     */
    protected $_idMenu;

    /**
     * label du Menu
     * @var string
     */
    protected $_labelMenu;

    /**
     * Mapper de l'objet
     * @var ServLogCom_Model_MenuMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Menu");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde un Menu, selon l'existence ou non du labelMenu, elle est
     * ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addMenu()
    {
        $this->_mapper->save($this, 'idMenu');
    }

    /**
     * Suprime un ou plusieurs Menu a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delMenu($idMenu)
    {
        try {
            $this->_mapper->delete('idMenu', $idMenu);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_Menu_delMenu() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un Menu a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServLogCom_Model_Menu
     *  
     */
    public function getMenu($idMenu)
    {
        return $this->_mapper->find($idMenu);
    }

    /**
     * Retourne tout les menus, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(ServLogCom_Model_Menu)
     *  
     */
    public static function getListeMenu()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_Menu");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_idMenu()
    {
        return $this->_idMenu;
    }

    public function set_idMenu($_idMenu)
    {
        $this->_idMenu = $_idMenu;
        return $this;
    }

    public function get_labelMenu()
    {
        return $this->_labelMenu;
    }

    public function set_labelMenu($_labelMenu)
    {
        $this->_labelMenu = $_labelMenu;
        return $this;
    }

}

?>
