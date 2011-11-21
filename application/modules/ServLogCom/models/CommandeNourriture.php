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
     * label de l'aeroport de livraison
     * @var string
     */
    protected $_labelAeroportLivraison;

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
        $this->_mapper->save($this, 'noCommandeNourriture');
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
     * Retourne une commande de nourriture sous forme de tableau HTML
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public function getCommandeNourritureHTML()
    {
        $Incident = "<div>No Commande Nourriture : " . $this->get_noCommandeNourriture() . "</div>";
        $Incident.= "<div>Date de livraison : " . $this->get_dateLivraison() . "</div>";
        $Incident.= "<div>Date de Commande : " . $this->get_dateCommande() . "</div>";
        $Incident.= "<div>Aeroport de livraison : " . $this->get_labelAeroportLivraison() . "</div>";
        return $Incident;
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

    /**
     * Retourne tous les incidents sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeCommandeNourritureHTML()
    {
        $allCN = ServLogCom_Model_CommandeNourriture::getListeCommandeNourriture();

        if (!empty($allCN)) {
            $tableau = "<table>
                        <tr>
                            <td>No de Commande|</td>
                            <td>Date de livraison|</td>
                            <td>Date de Commande|</td>
                            <td>Aeroport de livraison</td>
                            <td></td>
                            <td></td>
                        </tr>";

            foreach ($allCN as $val) {
                $tableau .= "<tr>
                                <td>" . $val->get_noCommandeNourriture() . "</td>
                                <td>" . $val->get_dateLivraison() . "</td>
                                <td>" . $val->get_dateCommande() . "</td>
                                <td>" . $val->get_labelAeroportLivraison() . "</td>
                                <td><a href='/ServLogCom/Commandenourriture/upd?id=" . $val->get_noCommandeNourriture() . "'>Modifier</a></td>
                                <td><a href='/ServLogCom/Commandenourriture/del?id=" . $val->get_noCommandeNourriture() . "'>Supprimer</a></td>
                            </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas de commande dans la base de donnée</div>";
        }
        return $tableau;
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

    public function get_labelAeroportLivraison()
    {
        return $this->_labelAeroportLivraison;
    }

    public function set_labelAeroportLivraison($_labelAeroportLivraison)
    {
        $this->_labelAeroportLivraison = $_labelAeroportLivraison;
        return $this;
    }

}

?>
