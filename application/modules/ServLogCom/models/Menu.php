<?php

class ServLogCom_Model_Menu
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
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
        $this->_mapper->save($this, 'labelMenu');
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
    public function delMenu($labelMenu)
    {
        try {
            $this->_mapper->delete('labelMenu', $labelMenu);
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
    public function getMenu($labelMenu)
    {
        return $this->_mapper->find($labelMenu);
    }

    /**
     * Retourne un Menu sous forme de tableau HTML
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public function getMenuHTML()
    {
        $menu = "<div>Menu : " . $this->get_labelMenu() . "</div>";
        return $menu;
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

    /**
     * Retourne tous les menus sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeMenuHTML()
    {
        $allMenu = ServExploitation_Model_Incident::getListeMenu();


        if (!empty($allMenu)) {
            $tableau = "<table>
                        <tr>
                            <td>Menu</td>
                            <td></td>
                            <td></td>
                        </tr>";

            foreach ($allMenu as $val) {
                $tableau .= "<tr>
                                <td>" . $val->get_labelMenu() . "</td>
                                <td><a href='/ServLogCom/Menu/upd?id=" . $val->get_labelMenu() . "'>Modifier</a></td>
                                <td><a href='/ServLogCom/Menu/del?id=" . $val->get_labelMenu() . "'>Supprimer</a></td>
                            </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas de menu dans la base de donnée</div>";
        }
        return $tableau;
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
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
