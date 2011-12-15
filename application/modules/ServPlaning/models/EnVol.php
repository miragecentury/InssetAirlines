<?php

class ServPlaning_Model_EnVol {

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero du vol
     * @var int
     */
    protected $_noVol;

    /**
     * numero de l'employe
     * @var int
     */
    protected $_noEmploye;

    /**
     * Equipage de secours présent ou non : 1 si oui, 0 si non
     * @var bool
     */
    protected $_equipageSecours;

    /**
     * heure de debut du travail
     * @var int
     */
    protected $_heureStart;

    /**
     * numero de fin du travail
     * @var int
     */
    protected $_heureEnd;

    /**
     * Mapper de l'objet
     * @var ServPlaning_Model_EnVolMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct() {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_EnVol");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Retourne un employe en vol a partir des id fourni en parametre.
     * Si la combinaison des id n'existe pas, retourne null.
     *
     * @access public
     * @author charles
     * @param int $_noVol, int $_noEmploye
     * @return null|ServPlaning_Model_EnVol
     *
     */
    public function getEnVol($_noVol, $_noEmploye) {
        return $this->_mapper->find(array($_noVol, $_noEmploye));
    }

    /**
     * Retourne tous les employe en vol, null si il n'y en as pas dans la BD
     *
     * @access public
     * @author charles
     * @return null|array(Application_Model_EnVol)
     *
     */
    public function getListeEnVol() {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_EnVol");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    public static function getEmployesLibresDuJour() {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_EnVol");

        //création des dates butoirs
        //butoir gauche aujourd'hui minuit
        $dateStart = new DateTime(date(DATE_ATOM));
        $dateStart->setTime(0, 0, 0);
        //butoir droite demain minuit
        $dateStop = $dateStart;
        $dateStop->modify('tomorrow');

        //Récupération des Employés
        //recup de la liste
        if (($return = self::$_mapper->getEmployeLibreInInterval($dateStart, $dateStop)) != false) {
            return $return;
        } else {
            return null;
        }
    }

    public static function getEmployesLibresAtInterval(DateTime $Start, DateTime $End) {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_EnVol");

        //Récupération des Employés
        //recup de la liste
        if (($return = self::$_mapper->getEmployeLibreInInterval($Start, $End)) != false) {
            return $return;
        } else {
            return null;
        }
    }

    public static function IsLibreAtIntervalByEmploye(DateTime $Start, DateTime $End, $noEmploye) {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_EnVol");
        return $mapper->IsLibreAtIntervalByEmploye($Start, $End, $noEmploye);
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

    public function get_noEmploye() {
        return $this->_noEmploye;
    }

    public function set_noEmploye($_noEmploye) {
        $this->_noEmploye = $_noEmploye;
        return $this;
    }

    public function get_equipageSecours() {
        return $this->_equipageSecours;
    }

    public function set_equipageSecours($_equipageSecours) {
        $this->_equipageSecours = $_equipageSecours;
        return $this;
    }

    public function get_heureStart() {
        return $this->_heureStart;
    }

    public function set_heureStart($_heureStart) {
        $this->_heureStart = $_heureStart;
        return $this;
    }

    public function get_heureEnd() {
        return $this->_heureEnd;
    }

    public function set_heureEnd($_heureEnd) {
        $this->_heureEnd = $_heureEnd;
        return $this;
    }

}

?>
