<?php

class ServCommercial_Model_VolHasAgence
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id
     * @var int
     */
    protected $_idVolHasAgence;

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
     * Ajoute ou modif une reservation dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addReservation()
    {
        $this->_mapper->save($this, 'idVolHasAgence');
    }

    /**
     * Suprime une reservation
     *
     * @author charles
     * @access public
     * @param int $noAgence
     *
     */
    public function delReservation($id)
    {
        echo $id;
        try {
            $this->_mapper->delete('idVolHasAgence', $id);
        } catch (Zend_Exception $e) {
            echo 'Serv_Commercial_Models_VolHasAgence_delPlace() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
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
    public function getReservation($id)
    {
        return $this->_mapper->find($id);
    }
    
    /**
     * Retourne une VolHasAgence a partir de son noAgence
     * Si elle n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int[] int $noVol, int $noAgence
     * @return null|ServCommercial_Model_Agence_has_AgenceMapper
     *  
     */
    public function getReservationbyAgence($idAgence)
    {
        return $this->_mapper->findbyAgence($idAgence);
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
    public function get_idVolHasAgence()
    {
        return $this->_idVolHasAgence;
    }

    public function set_idVolHasAgence($_id)
    {
        $this->_idVolHasAgence = $_id;
        return $this;
    }

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
