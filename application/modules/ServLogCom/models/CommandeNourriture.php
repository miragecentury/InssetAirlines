<?php

class ServLogCom_Model_CommandeNourriture
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de la commande de nourriture
     * @var int
     */
    protected $_noCommandeNourriture;

    /**
     * date de livraison
     * @var int
     */
    protected $_dateLivraison;

    /**
     * date de commande
     * @var int
     */
    protected $_dateCommande;

    /**
     * id de l'aeroport de livraison
     * @var int
     */
    protected $_idAeroportLivraison;

    /**
     * Mapper de l'objet
     * @var ServLogCom_Model_CommandeNourritureMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_CommandeNourriture");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde une commandeNourriture, selon l'existence ou non du 
     * noCommandeNourriture, elle est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addCommandeNourriture()
    {
        return $this->_mapper->save($this, 'noCommandeNourriture');
    }

    /**
     * Suprime un ou plusieurs CommandeNourriture a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delCommandeNourriture($noCommandeNourriture)
    {
        try {
            $this->_mapper->delete('noCommandeNourriture', $noCommandeNourriture);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_CommandeNourriture_delCommandeNourriture() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une CommandeNourriture a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServLogCom_Model_CommandeNourriture
     *  
     */
    public function getCommandeNourriture($noCommandeNourriture)
    {
        return $this->_mapper->find($noCommandeNourriture);
    }

    /**
     * Retourne toutes les commandesNourriture, null si il n'y en as pas dans
     * la BD
     * 
     * @access public
     * @author charles
     * @return null|array(AServLogCom_Model_CommandeNourriture)
     *  
     */
    public static function getListeCommandeNourriture()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_CommandeNourriture");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noCommandeNourriture()
    {
        return $this->_noCommandeNourriture;
    }

    public function set_noCommandeNourriture($_noCommandeNourriture)
    {
        $this->_noCommandeNourriture = $_noCommandeNourriture;
        return $this;
    }

    public function get_dateLivraison()
    {
        return $this->_dateLivraison;
    }

    public function set_dateLivraison($_dateLivraison)
    {
        $this->_dateLivraison = $_dateLivraison;
        return $this;
    }

    public function get_dateCommande()
    {
        return $this->_dateCommande;
    }

    public function set_dateCommande($_dateCommande)
    {
        $this->_dateCommande = $_dateCommande;
        return $this;
    }

    public function get_idAeroportLivraison()
    {
        return $this->_idAeroportLivraison;
    }

    public function set_idAeroportLivraison($_idAeroportLivraison)
    {
        $this->_idAeroportLivraison = $_idAeroportLivraison;
        return $this;
    }

    public function get_labelAeroportLivraison()
    {
        $item = new Application_Model_Aeroport;
        $item = $item->getAeroport($this->get_idAeroportLivraison());
        if ($item != null)
            return $item->get_labelAeroport();
        return "Aeroport Incorect";
    }

}

?>
