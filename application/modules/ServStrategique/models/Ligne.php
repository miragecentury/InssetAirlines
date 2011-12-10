<?php

class ServStrategique_Model_Ligne
{
    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    const ETAT_ETUDE = 1;
    const ETAT_EN_VALIDATION = 2;
    const ETAT_ACTIVE = 3;
    const ETAT_INACTIVE = 4;

    /**
     * numero de Ligne
     * @var int
     */
    protected $_noLigne;

    /**
     * nombre de jours entre deux vol sur cette ligne
     * @var int
     */
    protected $_jours;

    /**
     * nombre de semaines entre deux vol sur cette ligne
     * @var int
     */
    protected $_semaines;

    /**
     * nombre de mois entre deux vol sur cette ligne
     * @var int
     */
    protected $_mois;

    /**
     * nombre d'années entre deux vol sur cette ligne
     * @var int
     */
    protected $_annees;

    /**
     * label de l'aeroport de depart
     * @var string
     */
    protected $_noAeroportDeco;

    /**
     * label de l'aeroport d'arrivee
     * @var string
     */
    protected $_noAeroportAtte;

    /**
     * Etat de la ligne
     * Correspond à 4 constante :
     * -> 1 : En etude
     * -> 2 : En attente de Validation
     * -> 3 : active
     * -> 4 : desactive
     * @var int
     */
    protected $_etat;

    /**
     * Durée minimal du vol
     * @var int
     */
    protected $_duree;

    /**
     * Mapper de l'objet
     * @var ServStrategique_Model_LigneMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------

    public static function changementSemaine()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        // enregistrement de la liste en bdd
        $return = $mapper->getLignesHebdomadaires();
        return $return;
    }

    public static function changementMois()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        // enregistrement de la liste en bdd
        $return = $mapper->getLignesMensuelles();
        return $return;
    }

    public static function changementJour()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        // enregistrement de la liste en bdd
        $return = $mapper->getLignesJournalieres();
        return $return;
    }

    public static function changementAnnee()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        // enregistrement de la liste en bdd
        $return = $mapper->getLignesAnnuelles();
        return $return;
    }

    /**
     * Sauvegarde une  ligne, selon l'existence ou non du noLigne,
     * il est ajouté ou modifié
     *
     * @author charles,pewho
     * @access public
     *
     */
    public function addLigne()
    {
        try {
            $this->_mapper->save($this, 'noLigne');
            return true;
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::log('addligne Exception - ' .
                $e->getMessage() . ' - ' .
                $e->getPrevious()->getMessage(), Zend_Log::ERR);
            return false;
        }
    }

    /**
     * Suprime un ou plusieurs Ligne a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delLigne($noLigne)
    {
        try {
            $this->_mapper->delete('noLigne', $noLigne);
            return true;
        } catch (Zend_Exception $e) {
            echo 'ServSrategique_Models_Ligne_delLigne()
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
            return false;
        }
    }

    /**
     * Retourne une Ligne a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     *
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServPlaning_Model_Ligne
     *
     */
    public static function getLigne($noLigne)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        return $mapper->find($noLigne);
    }

    /**
     * Retourne toutes les Lignes, null si il n'y en as pas dans la BD
     *
     * @access public
     * @author charles
     * @return null|array(Application_Model_Ligne)
     *
     */
    public static function getListeLigne()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    /**
     * Retourne l'état de la ligne en bon françois
     *
     * @access pewho
     * @author charles
     * @return string
     */
    public function getStatusLigne()
    {
        switch ($this->get_etat()) {
            case 1:
                return 'En étude';
                break;
            case 2:
                return 'En attente de validation';
            case 3:
                return 'Active';
            case 4:
                return 'Inactive';
            default:
                return 'Erreur';
        }
    }

    //Systeme de comptage de vol a planifier
    public static function getNbPlanJourRestante()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        //recupération de l'array des planifications restante
        $listeJLun = Application_Model_ApplicationVar::get('LstVolAPlan_J_Lun');
        $listeJMar = Application_Model_ApplicationVar::get('LstVolAPlan_J_Mar');
        $listeJMer = Application_Model_ApplicationVar::get('LstVolAPlan_J_Mer');
        $listeJJeu = Application_Model_ApplicationVar::get('LstVolAPlan_J_Jeu');
        $listeJVen = Application_Model_ApplicationVar::get('LstVolAPlan_J_Ven');
        $listeJSam = Application_Model_ApplicationVar::get('LstVolAPlan_J_Sam');
        $listeJDim = Application_Model_ApplicationVar::get('LstVolAPlan_J_Dim');
        //Comptage
        $nbPlanification = 0;
        if ($listeJLun != null) {
            foreach ($listeJLun as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJMar != null) {
            foreach ($listeJMar as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJMer != null) {
            foreach ($listeJMer as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJJeu!= null) {
            foreach ($listeJJeu as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJVen != null) {
            foreach ($listeJVen as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJSam != null) {
            foreach ($listeJSam as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        if ($listeJDim != null) {
            foreach ($listeJDim as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        return $nbPlanification;
    }

    public static function getNbPlanHebRestante()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        //recupération de l'array des planifications restante
        $listeJ = Application_Model_ApplicationVar::get('LstVolAPlan_S');
        //Comptage
        $nbPlanification = 0;
        if ($listeJ != null) {
            foreach ($listeJ as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        return $nbPlanification;
    }

    public static function getNbPlanMenRestante()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        //recupération de l'array des planifications restante
        $listeJ = Application_Model_ApplicationVar::get('LstVolAPlan_M');
        //Comptage
        $nbPlanification = 0;
        if ($listeJ != null) {
            foreach ($listeJ as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        return $nbPlanification;
    }

    public static function getNbPlanAnnRestante()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServStrategique_Model_Ligne");
        //recupération de l'array des planifications restante
        $listeJ = Application_Model_ApplicationVar::get('LstVolAPlan_A');
        //Comptage
        $nbPlanification = 0;
        if ($listeJ != null) {
            foreach ($listeJ as $value) {
                $nbPlanification += $value['recurence'];
            }
        }
        return $nbPlanification;
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_duree()
    {
        return $this->_duree;
    }

    public function set_duree($_duree)
    {
        $this->_duree = $_duree;
        return $this;
    }

    public function get_noLigne()
    {
        return $this->_noLigne;
    }

    public function set_noLigne($_noLigne)
    {
        $this->_noLigne = $_noLigne;
        return $this;
    }

    public function get_jours()
    {
        return $this->_jours;
    }

    public function set_jours($_jours)
    {
        $this->_jours = $_jours;
        return $this;
    }

    public function get_semaines()
    {
        return $this->_semaines;
    }

    public function set_semaines($_semaines)
    {
        $this->_semaines = $_semaines;
        return $this;
    }

    public function get_mois()
    {
        return $this->_mois;
    }

    public function set_mois($_mois)
    {
        $this->_mois = $_mois;
        return $this;
    }

    public function get_annees()
    {
        return $this->_annees;
    }

    public function set_annees($_annees)
    {
        $this->_annees = $_annees;
        return $this;
    }

    public function get_noAeroportDeco()
    {
        return $this->_noAeroportDeco;
    }

    public function set_noAeroportDeco($_labelAeroportDeco)
    {
        $this->_noAeroportDeco = $_labelAeroportDeco;
        return $this;
    }

    public function get_noAeroportAtte()
    {
        return $this->_noAeroportAtte;
    }

    public function set_noAeroportAtte($_labelAeroportAtte)
    {
        $this->_noAeroportAtte = $_labelAeroportAtte;
        return $this;
    }

    public function get_etat()
    {
        return $this->_etat;
    }

    public function set_etat($_etat)
    {
        $this->_etat = $_etat;
        return $this;
    }

}

?>
