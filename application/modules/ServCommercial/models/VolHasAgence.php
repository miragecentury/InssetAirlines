<?php

class ServCommercial_Model_VolHasAgence
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero du vol
     * @var int
     */
    protected $_Vol_noVol;

    /**
     * numero de l'agence
     * @var int
     */
    protected $_Agence_noAgence;

    /**
     * nombre de la reservation
     * @var int
     */
    protected $_nbReservation;

    /**
     * Reservation en attente de traitement : 1 si oui, 0 si non
     * @var bool
     */
    protected $_enAttentedeTraitement;

    /**
     * Reservation valider : 1 si oui, 0 si non
     * @var bool
     */
    protected $_valider;

    /**
     * Mapper de l'objet
     * @var ServCommercial_Model_Vol_has_AgenceMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_VolHasAgence");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute une reservation dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addReservation()
    {
        $this->_mapper->save($this);
    }

    /**
     * Suprime une reservation
     *
     * @author charles
     * @access public
     * @param int $noAgence
     *
     */
    public function delReservation($noVol, $noAgence)
    {
        try {
            $this->_mapper->delete($noVol, $noAgence);
        } catch (Zend_Exception $e) {
            echo 'Serv_Commercial_Models_VolHasAgence_delReservation() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Modifie une reservation dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function updReservation()
    {
        $this->_mapper->update($this);
    }

    public function getReservationHTML()
    {
        $Place = "<table class='grid_16'>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Vol</td>
                    <td class='grid_3'>" . $this->get_Vol_noVol() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Agence</td>
                    <td class='grid_3'>" . $this->get_Agence_noAgence() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Nombre Reservation</td>
                    <td class='grid_3'>" . $this->get_nbReservation() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Etat Traitement</td>
                    <td class='grid_3'>" . $this->get_enAttentedeTraitement() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Etat Validation</td>
                    <td class='grid_3'>" . $this->get_valider() . "</td>
                </tr>                
            </table>";
        return $Place;
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Retourne une VolHasAgence a partir de son noVol et de son noAgence
     * Si elle n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int[] int $noVol, int $noAgence
     * @return null|ServCommercial_Model_Agence_has_AgenceMapper
     *  
     */
    public function getReservation($_Vol_noVol, $_Agence_noAgence)
    {
        return $this->_mapper->find(array($_Vol_noVol, $_Agence_noAgence));
    }

    /**
     * Retourne tous les places sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeReservationHTML($admin=true)
    {
        $html = ServCommercial_Model_VolHasAgence::getListeReservation();
        $color = true;

        if (!empty($html)) {
            $tableau = "<table class='grid_16'>
                        <tr>
                            <td class='grid_1'>Vol</td>
                            <td class='grid_1'>Agence</td>
                            <td class='grid_2'>Nombre de place</td>
                            <td class='grid_2'>Traitement</td>
                            <td class='grid_1'>Validation</td>";
            if ($admin)
                $tableau .= " <td class='grid_1'></td>
                              <td class='grid_1'></td>
                              <td class='grid_2'></td>";
            $tableau .= " </tr>";

            foreach ($html as $val) {
                if ($color) {
                    $tableau .= "<tr bgcolor='#CCCCCC'>";
                }
                $color = !$color;
                $tableau .= "   <td class='grid_1'>" . $val->get_Vol_noVol() . "</td>
                                <td class='grid_1'>" . $val->get_Agence_noAgence() . "</td>
                                <td class='grid_2'>" . $val->get_nbReservation() . "</td>
                                <td class='grid_2'>" . $val->get_enAttentedeTraitement() . "</td>
                                <td class='grid_1'>" . $val->get_valider() . "</td>";
                if ($admin)
                    $tableau .= "   <td class='grid_1'><a href='/ServCommercial/Reservation/detail?id[]=" . $val->get_Vol_noVol() . "&id[]=" . $val->get_Agence_noAgence() . "'>Detail</a></td>
                                    <td class='grid_1'><a href='/ServCommercial/Reservation/upd?id[]=" . $val->get_Vol_noVol() . "&id[]=" . $val->get_Agence_noAgence() . "'>Modifier</a></td>
                                    <td class='grid_2'><a href='/ServCommercial/Reservation/del?id[]=" . $val->get_Vol_noVol() . "&id[]=" . $val->get_Agence_noAgence() . "'>Supprimer</a></td>";
                $tableau .= " </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas de place répertoriées dans la base de donnée</div>";
        }
        return $tableau;
    }

    /**
     * Retourne tous les vol de toutes les reservation, null si il n'y en as pas 
     * dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_VolHasAgence)
     *  
     */
    public static function getListeReservation()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_VolHasAgence");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_Vol_noVol()
    {
        return $this->_Vol_noVol;
    }

    public function set_Vol_noVol($_Vol_noVol)
    {
        $this->_Vol_noVol = $_Vol_noVol;
        return $this;
    }

    public function get_Agence_noAgence()
    {
        return $this->_Agence_noAgence;
    }

    public function set_Agence_noAgence($_Agence_noAgence)
    {
        $this->_Agence_noAgence = $_Agence_noAgence;
        return $this;
    }

    public function get_nbReservation()
    {
        return $this->_nbReservation;
    }

    public function set_nbReservation($_nbReservation)
    {
        $this->_nbReservation = $_nbReservation;
        return $this;
    }

    public function get_enAttentedeTraitement()
    {
        return $this->_enAttentedeTraitement;
    }

    public function set_enAttentedeTraitement($_enAttentedeTraitement)
    {
        $this->_enAttentedeTraitement = $_enAttentedeTraitement;
        return $this;
    }

    public function get_valider()
    {
        return $this->_valider;
    }

    public function set_valider($_valider)
    {
        $this->_valider = $_valider;
        return $this;
    }

}

?>
