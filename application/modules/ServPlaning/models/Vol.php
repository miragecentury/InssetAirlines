<?php

class ServPlaning_Model_Vol {

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero du vol
     * @var int
     */
    protected $_noVol;

    /**
     * label du vol
     * @var string
     */
    protected $_labelvol;

    /**
     * label de l'aeroport d'arrivée
     * @var string
     */
    protected $_noAeroportAtte;

    /**
     * label de depart
     * @var string
     */
    protected $_noAeroportDeco;

    /**
     * numero de l'avion
     * @var int
     */
    protected $_noAvion;

    /**
     * numero de la ligne
     * @var int
     */
    protected $_noLigne;

    /**
     * heure de decollage
     * @var int
     */
    protected $_heuredecollage;

    /**
     * heure d'atterissage
     * @var int
     */
    protected $_heureAtterissage;

    /**
     * Mapper de l'objet
     * @var ServPlaning_Model_VolMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct() {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute ou modifie un vol dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addVol() {
        $this->_mapper->save($this, 'noVol');
    }

    /**
     * Suprime un vol a partir de son noVol
     *
     * @author charles
     * @access public
     * @param string $noVol
     *
     */
    public function delVol($noVol) {
        try {
            $this->_mapper->delete('noVol', $noVol);
        } catch (Zend_Exception $e) {
            echo 'ServPlaning_Models_Vol_delVol() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un Vol sous forme de tableau HTML
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public function getVolHTML() {
        $Aero = "<table class='grid_16'>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Id</td>
                    <td class='grid_3'>" . $this->get_noVol() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Label</td>
                    <td class='grid_3'>" . $this->get_labelvol() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Aeroport de départ</td>
                    <td class='grid_3'>" . $this->get_noAeroportDeco() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Aeroport d'arrivée</td>
                    <td class='grid_3'>" . $this->get_noAeroportAtte() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Avion</td>
                    <td class='grid_3'>" . $this->get_noAvion() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Ligne</td>
                    <td class='grid_3'>" . $this->get_noLigne() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Heure depart</td>
                    <td class='grid_3'>" . $this->get_heuredecollage() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Heure arrivée</td>
                    <td class='grid_3'>" . $this->get_heureAtterissage() . "</td>
                </tr>
            </table>";
        return $Aero;
    }

    /**
     * Retourne un vol a partir de son noVol.
     * S'il n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $noVol
     * @return null|ServPlaning_Model_Vol
     *  
     */
    public function getVol($noVol) {
        return $this->_mapper->find($noVol);
    }

    /**
     * Retourne tous les vols, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_Vol)
     *  
     */
    public static function getListeVol() {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    /**
     * Retourne tous les vol sous forme de select, retourne un select vide si
     * il n'y en a pas
     * 
     * @access public
     * @author charles
     * @param string $name, string $label
     * @return Zend_Form_Element_Select
     *  
     */
    public static function getSelectVol($name, $label) {
        try {
            $Vols = ServPlaning_Model_Vol::getListeVol();
            $noVol = new Zend_Form_Element_Select($name);
            foreach ($Vols as $Vol) {
                $noVol->addMultiOption($Vol->get_noVol(), $Vol->get_noVol());
            }
            $noVol->setRequired();
            $noVol->setLabel($label);
            return $noVol;
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    public static function getVolByAvion($noAvion) {
        
    }

    /**
     * Retourne tous les vols sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeVolHTML() {
        $all = ServPlaning_Model_Vol::getListeVol();
        $color = true;

        if (!empty($all)) {
            $tableau = "<table class='grid_16'>
                        <tr>
                            <td class='grid_1'>Id</td>
                            <td class='grid_2'>Label</td>
                            <td class='grid_3'>Aeroport de départ</td>
                            <td class='grid_3'>Aeroport d'arrivée</td>
                            <td class='grid_1'>Avion</td>
                            <td class='grid_1'>Ligne</td>
                            <td class='grid_1'>Depart</td>
                            <td class='grid_1'>Arrivée</td>
                            <td class='grid_2'></td>
                            <td class='grid_2'></td>
                        </tr>";

            foreach ($all as $val) {
                if ($color) {
                    $tableau .= "<tr bgcolor='#CCCCCC'>";
                }
                $color = !$color;
                $tableau .= "   <td class='grid_1'>" . $val->get_noVol() . "</td>
                                <td class='grid_2'>" . $val->get_labelvol() . "</td>
                                <td class='grid_3'>" . $val->get_noAeroportDeco() . "</td>
                                <td class='grid_3'>" . $val->get_noAeroportAtte() . "</td>
                                <td class='grid_1'>" . $val->get_noAvion() . "</td>
                                <td class='grid_1'>" . $val->get_noLigne() . "</td>
                                <td class='grid_1'>" . $val->get_heuredecollage() . "</td>
                                <td class='grid_1'>" . $val->get_heureAtterissage() . "</td>
                                <td class='grid_2'><a href='/ServPlaning/Vol/upd?id=" . $val->get_noVol() . "'>Modifier</a></td>
                                <td class='grid_2'><a href='/ServPlaning/Vol/del?id=" . $val->get_noVol() . "'>Supprimer</a></td>
                            </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas d'incident dans la base de donnée</div>";
        }
        return $tableau;
    }

    /**
     * Retourne tous les vols sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeVolUser() {
        $all = ServPlaning_Model_Vol::getListeVol();
        $color = true;

        if (!empty($all)) {
            $tableau = "<table class='grid_16'>
                        <tr>
                            <td class='grid_1'>Id</td>
                            <td class='grid_3'>Label</td>
                            <td class='grid_3'>Aeroport de départ</td>
                            <td class='grid_3'>Aeroport d'arrivée</td>
                            <td class='grid_1'>Avion</td>
                            <td class='grid_1'>Ligne</td>
                            <td class='grid_1'>Depart</td>
                            <td class='grid_1'>Arrivée</td>
                        </tr>";

            foreach ($all as $val) {
                if ($color) {
                    $tableau .= "<tr bgcolor='#CCCCCC'>";
                }
                $color = !$color;
                $tableau .= "   <td class='grid_1'>" . $val->get_noVol() . "</td>
                                <td class='grid_3'>" . $val->get_labelvol() . "</td>
                                <td class='grid_3'>" . $val->get_noAeroportDeco() . "</td>
                                <td class='grid_3'>" . $val->get_noAeroportAtte() . "</td>
                                <td class='grid_1'>" . $val->get_noAvion() . "</td>
                                <td class='grid_1'>" . $val->get_noLigne() . "</td>
                                <td class='grid_1'>" . $val->get_heuredecollage() . "</td>
                                <td class='grid_1'>" . $val->get_heureAtterissage() . "</td>
                                </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas d'incident dans la base de donnée</div>";
        }
        return $tableau;
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noVol() {
        return $this->_noVol;
    }

    public function set_noVol($_noVol) {
        $this->_noVol = $_noVol;
        return $this;
    }

    public function get_labelvol() {
        return $this->_labelvol;
    }

    public function set_labelvol($_labelvol) {
        $this->_labelvol = $_labelvol;
        return $this;
    }

    public function get_noAeroportAtte() {
        return $this->_noAeroportAtte;
    }

    public function set_noAeroportAtte($_labelAeroportAtte) {
        $this->_noAeroportAtte = $_labelAeroportAtte;
        return $this;
    }

    public function get_noAeroportDeco() {
        return $this->_noAeroportDeco;
    }

    public function set_noAeroportDeco($_labelAeroportDeco) {
        $this->_noAeroportDeco = $_labelAeroportDeco;
        return $this;
    }

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
        return $this;
    }

    public function get_noLigne() {
        return $this->_noLigne;
    }

    public function set_noLigne($_noLigne) {
        $this->_noLigne = $_noLigne;
        return $this;
    }

    public function get_heuredecollage() {
        return $this->_heuredecollage;
    }

    public function set_heuredecollage($_heuredecollage) {
        $this->_heuredecollage = $_heuredecollage;
        return $this;
    }

    public function get_heureAtterissage() {
        return $this->_heureAtterissage;
    }

    public function set_heureAtterissage($_heureAtterissage) {
        $this->_heureAtterissage = $_heureAtterissage;
        return $this;
    }

}

?>
