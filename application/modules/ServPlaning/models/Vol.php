<?php

/**
 *
 *
 */
class ServPlaning_Model_Vol
{
    //le vol est ok;
    const ETAT_OK = 0;

    //Etat entraînant une NOTICE aux futurs passagés et au Serv Exploitation
    const ETAT_RETARD_DE = 1;
    const ETAT_RETARD_AT = 6;

    //Etat entraînant une alerte au service Planning
    const ETAT_NOAVION = 3;
    const ETAT_MQ_PERSONNEL = 4;

    //Vol dont les traitements sont finis (sauf calcul heure personnel DRH)
    const ETAT_ANNULE = 2;
    const ETAT_EFFECTUER = 5;

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
    protected $_etat;

    /**
     * Mapper de l'objet
     * @var ServPlaning_Model_VolMapper
     */
    private static $_mapper;

    public static function init()
    {
        if (self::$_mapper === null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        }
    }

//--------------------------------------------------------------------------
// Methodes
//--------------------------------------------------------------------------
//******************************************************************************
//public static

    public static function findAllVolsInInterval(DateTime $start, DateTime $stop)
    {
        self::init();
        return self::$_mapper->findAllVolsInInterval($start, $stop);
    }

    public static function FindAllVolsByAvionAtDateTimeInterval(DateTime $Start, DateTime $End, $noAvion)
    {
        self::init();
        return self::$_mapper->FindAllVolsByAvionAtDateTimeInterval($Start, $End, $noAvion);
    }

    public static function getVolsByAvionFromDateTimeEffectif(DateTime $DateTime, $noAvion)
    {
        self::init();
        return self::$_mapper->getVolsByAvionFromDateTimeEffectif($DateTime, $noAvion);
    }

    public static function changementSemaine()
    {

    }

    public static function changementMois()
    {

    }

    public static function changementJour()
    {

    }

    public static function getVolsByAvion($noAvion)
    {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        return self::$_mapper->getVolsByAvion($noAvion);
    }

    public static function findAllVolsInIntervalByEtat(DateTime $start, DateTime $stop, $etat)
    {
        self::init();
        return self::$_mapper->findAllVolsInIntervalByEtat($start, $stop, $etat);
    }

    public static function IsEnVolByAvionOnCurrentTime($noAvion)
    {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        $vols = self::$_mapper->getVolsByAvionOnCurrentTime($noAvion);
        if (count($vols) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retourne la liste des vols prevus pour la semaine demandée
     *
     * @access public
     * @static
     * @param int $noAvion
     * @author pewho
     * @return array(ServPlaning_Model_Vol)|false
     */
    public static function getVolsBySemaine($noSemaine)
    {
        //récupération des dates
        $start = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent($noSemaine));
        $stop = new DateTime(ServPlaning_Model_Vol::getFinSemaineAheadFromCurrent($noSemaine));
        //Selection
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        $return = $mapper->findAllVolsInInterval($start, $stop);
        return $return;
    }

    public static function getVolByAvionOnCurrentTime($noAvion)
    {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        $vols = self::$_mapper->getVolsByAvionOnCurrentTime($noAvion);
        if (count($vols) == 1) {
            return $vols[0];
        } else {
            return FALSE;
        }
    }

    /**
     * Renvoie la date du lundi minuit de la semaine S+$nbrSemaine
     *
     * @author pewho
     * @static
     * @access public
     * @param int $nbrSemaine
     * @return null|string
     */
    public static function getSemaineAheadFromCurrent($nbrSemaine)
    {
        $date = new DateTime(date(DATE_ATOM));
        $date->modify('Monday this week');
        if (is_int($nbrSemaine) && $nbrSemaine > 0) {
            $semaine = '+' . $nbrSemaine . ' week';
            $date->modify($semaine);
        } else if ($nbrSemaine == 0) {

        } else {
            return null;
        }
        $date->setTime(0, 0, 0);
        return $date->format(DATE_ATOM);
    }

    /**
     * Renvoie la cate du Dimanche minuit de la semaine S+$nbrSemaine
     * @author pewho
     * @access public
     * @static
     * @param int $nbrSemaine
     * @return null|string
     */
    public static function getFinSemaineAheadFromCurrent($nbrSemaine)
    {
        $date = new DateTime(date(DATE_ATOM));
        $date->modify('Sunday this week');
        if (is_int($nbrSemaine) && $nbrSemaine > 0) {
            $semaine = '+' . $nbrSemaine . ' week';
            $date->modify($semaine);
        } else if ($nbrSemaine == 0) {

        } else {
            return null;
        }
        $date->setTime(0, 0, 0);
        return $date->format(DATE_ATOM);
    }

    public static function repercutionMiseHorsServiceAvion($noAvion, $DateTime)
    {
        $End = self::getSemaineAheadFromCurrent(5);
        if ($DateTime instanceof DateTime) {
            $Start = $DateTime;
        } elseif (is_string($DateTime)) {

        } else {
            return FALSE;
        }
    }

    public static function getJourFromWeek($weekDate, $jour)
    {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }

        switch ($jour) {
            case 1:
                return $date->format(DATE_ATOM);
            case 2:
                $date->modify('tuesday');
                return $date->format(DATE_ATOM);
            case 3:
                $date->modify('wednesday');
                return $date->format(DATE_ATOM);
            case 4:
                $date->modify('thursday');
                return $date->format(DATE_ATOM);
            case 5:
                $date->modify('friday');
                return $date->format(DATE_ATOM);
            case 6:
                $date->modify('saturday');
                return $date->format(DATE_ATOM);
            case 7:
                $date->modify('sunday');
                return $date->format(DATE_ATOM);
            default:
                return null;
        }
    }

    public static function getMoisFromWeek($weekDate)
    {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }
        $date->modify('first day of this month');
        return $date->format(DATE_ATOM);
    }

    public static function getAnneeFromWeek($weekDate)
    {
        if ($weekDate instanceof DateTime) {
            $date = $weekDate;
        } else if (is_string($weekDate)) {
            $date = new DateTime($weekDate);
        } else {
            return null;
        }
        $date->setDate($date->format('Y'), 1, 1);
        return $date->format(DATE_ATOM);
    }

    /**
     * recupération des vols du jour courant
     *
     * @access public
     * @static
     * @return array(ServPlaning_Model_Vol)
     */
    public static function getVolsDuJour()
    {
        //création des dates butoirs
        //butoir gauche aujourd'hui minuit
        $dateStart = new DateTime(date(DATE_ATOM));
        $dateStart->setTime(0, 0, 0);
        //butoir droite demain minuit
        $dateStop = $dateStart;
        $dateStop->modify('tomorrow');

        //recupération des vols
        //mapper
        if (self::$_mapper == null) {
            self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        }
        //recup de la liste
        if (($return = self::$_mapper->findAllVolsInInterval($dateStart, $dateStop)) != false) {
            return $return;
        } else {
            return null;
        }
    }

    /**
     * Retourne le nombre de semaine entre aujourd'hui et $date
     *
     * @access public
     * @static
     * @author pewho
     * @param int $date
     * @return int $s
     */
    public static function getIntervalSemBetweenNowAndDate($date)
    {
        //si la date est un string
        if (is_string($date)) {
            $stop = new DateTime($date);
        } if ($date instanceof DateTime) {
            $stop = $date;
        } else {
            return null;
        }
        $stop = $stop->format('d/m/Y');

        //génération de la date now
        $start = new DateTime(date(DATE_ATOM));
        $start->modify('Monday this week');
        $start = $start->format('d/m/Y');
        //expode
        $start = explode('/', $start);
        $stop = explode('/', $stop);
        //timestamp
        $start = mktime(0, 0, 0, $start[1], $start[0], $start[2]);
        $stop = mktime(0, 0, 0, $stop[1], $stop[0], $stop[2]);
        //calcul
        $result = $stop - $start;
        $s = ($result / 86400);

        $s = floor($s / 7);
        return $s;
    }

//******************************************************************************
//private static
//******************************************************************************
//public
//******************************************************************************
//private

    /**
     * Ajoute ou modifie un vol dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addVol()
    {
        self::init();
        self::$_mapper->save($this, 'noVol');
    }

    public function addRetardDecollage($nbHeure, $nbMinute)
    {
        self::init();
        $date = new DateTime($this->get_heuredecollage());
        $date->modify("+" . $nbHeure . " hour +" . $nbMinute . " min");
        $this->set_heuredecollage($date->format(DATE_ATOM));
        $date = new DateTime($this->get_heureAtterissage());
        $date->modify("+" . $nbHeure . " hour +" . $nbMinute . " min");
        $this->set_heureAtterissage($date->format(DATE_ATOM));
        try {
            $this->save();
            $this->addRetardRec($nbHeure, $nbMinute);
        } catch (Exception $e) {

        }
    }

    /**
     * Permet de gerer l'effet boule de neige lors de l'ajout d'un retard.
     *
     * @access private
     * @author pewho
     * @param int $nbHeure
     * @param int $nbMin
     */
    private function addRetardRec($nbHeure, $nbMinute)
    {
        //init
        $volSuivant = null;
        self::init();


        //1 Etape : recuperation et test du prochain vol de l'avion utilisé
        $volSuivant = self::$_mapper->getNextVolByAvion($this);


        //Si le vol est en conflit
        if ($volSuivant instanceof ServPlaning_Model_Vol &&
            $this->get_heureAtterissage() > $volSuivant->get_heureDecollage()) {
            $arrayEnVol = ServPlaning_Model_EnVol::getEnVolByVol($volSuivant->get_noVol());
            //modification de la date Start / stop de chaque en Vol
            foreach ($arrayEnVol as $enVol) {
                $dateStart = new DateTime($enVol->get_heureStart());
                $dateStop = new DateTime($enVol->get_heureStop());
                $dateStart->modify("+" . $nbHeure . " hour +" . $nbMinute . " min");
                $dateStop->modify("+" . $nbHeure . " hour +" . $nbMinute . " min");
                $enVol->set_heureStart($dateStart->format(DATE_ATOM));
                $enVol->set_heureStop($dateStop->format(DATE_ATOM));
                $envol->save();
            }
            $volSuivant->addRetardDecollage($nbHeure, $nbMinute);
        }

        //2 Etape : recuperation et test des pilotes de l'avion utilisé
        $enVols = ServPlaning_Model_EnVol::getEnVolByVol($this->get_noVol());
        $compteur = 0; // afin de ses souvenir que vol a deja ete modifié
        foreach ($enVols as $enVol) {
            //Pour chaque EnVol Courant
            $enVolSuivant = ServPlaning_Model_EnVol::getNextEnVolByEnVol($enVol);
            if ($enVolSuivant instanceof ServPlaning_Model_EnVol &&
                $enVol->get_heureStop() > $enVolSuivant->get_heureStart()) {
                    $VolMod = ServPlaning_Model_Vol::getVol($enVolSuivant->get_noVol());
                    $VolMod->addRetardRec($nbHeure, $nbMinute);
            }
        }
    }

    public function addRetardAtterissage($nbHeure, $nbMinute)
    {
        self::init();
    }

    public function deroute($noAeroportAtterissage)
    {
        self::init();
    }

    public function annule()
    {
        self::init();
    }

    /**
     * Suprime un vol a partir de son noVol
     *
     * @author charles
     * @access public
     * @param string $noVol
     *
     */
    public function delVol($noVol)
    {
        self::init();
        try {
            self::$_mapper->delete('noVol', $noVol);
        } catch (Zend_Exception $e) {
            echo 'ServPlaning_Models_Vol_delVol()
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un vol a partir de son noVol.
     * S'il n'existe pas, retourne null.
     *
     * @access public
     * @static
     * @author charles
     * @param int $noVol
     * @return null|ServPlaning_Model_Vol
     *
     */
    public static function getVol($noVol)
    {
        self::$_mapper = Spesx_Mapper_MapperFactory::getMapper("ServPlaning_Model_Vol");
        return self::$_mapper->find($noVol);
    }

    public function save()
    {
        self::init();
        return self::$_mapper->save($this, 'noVol');
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noVol()
    {
        return $this->_noVol;
    }

    public function set_noVol($_noVol)
    {
        $this->_noVol = $_noVol;
        return $this;
    }

    public function get_labelvol()
    {
        return $this->_labelvol;
    }

    public function set_labelvol($_labelvol)
    {
        $this->_labelvol = $_labelvol;
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

    public function get_noAeroportDeco()
    {
        return $this->_noAeroportDeco;
    }

    public function set_noAeroportDeco($_labelAeroportDeco)
    {
        $this->_noAeroportDeco = $_labelAeroportDeco;
        return $this;
    }

    public function get_noAvion()
    {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion)
    {
        $this->_noAvion = $_noAvion;
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

    public function get_heuredecollage()
    {
        return $this->_heuredecollage;
    }

    public function set_heuredecollage($_heuredecollage)
    {
        $this->_heuredecollage = $_heuredecollage;
        return $this;
    }

    public function get_heureAtterissage()
    {
        return $this->_heureAtterissage;
    }

    public function set_heureAtterissage($_heureAtterissage)
    {
        $this->_heureAtterissage = $_heureAtterissage;
        return $this;
    }

    public function set_etat($_etat)
    {
        $this->_etat = $_etat;
        return $this;
    }

    public function get_etat()
    {
        return $this->_etat;
    }

}

?>
