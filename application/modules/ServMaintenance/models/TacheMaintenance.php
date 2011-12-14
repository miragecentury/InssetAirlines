<?php

class ServMaintenance_Model_TacheMaintenance {

    protected $_noMaintenance;
    protected $_etat;
    protected $_dateDebut;
    protected $_dateFin;
    protected $_retard;
    protected $_rapport;
    protected $_noTypeMaintenance;
    protected $_noAvion;
    private static $mapper = null;

    const TACHE_PREVENTIVE = 0;
    const TACHE_URGENTE = 1;
    const TACHE_FINIE = 2;

    private static function init() {
        if (self::$mapper === null) {
            self::$mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_TacheMaintenance');
        }
    }

    //**************************************************************************
    //public static

    public static function findAllPlanifierAtCurrentTime() {
        self::init();
        return self::$mapper->findAllPlanifierAtCurrentTime();
    }

    public static function nbMaintenanceEnCoursAujourdhui($Etat) {
        self::init();
        if (is_int($Etat)) {
            $t = self::$mapper->findAllAtCurrentTime($Etat);
            return count($t);
        } else {
            return FALSE;
        }
    }

    public static function FindLastMaintenanceByAvionByTypeMaintenance($noAvion, $noTypeMaintenance) {
        self::init();
        return self::$mapper->FindLastMaintenanceByAvionByTypeMaintenance($noAvion, $noTypeMaintenance);
    }

    public static function nbMaintenanceAtDateTimeInterval($Strat, $End) {
        
    }

    public static function nbMaintenanceUrgenteAPlanifier() {
        return count(Application_Model_ApplicationVar::get('lstTacheUrgenteAplanifier'));
    }

    public static function getMaintenanceUrgenteAPlanifier() {
        return Application_Model_ApplicationVar::get('lstTacheUrgenteAplanifier');
    }

    public static function actualisationcloturedesMaintenances() {
        self::init();
        //passer en clôturer les tâches finies

        $forcloture = self::$mapper->findAllForCloture();
        if (is_array($forcloture)) {
            foreach ($forcloture as $maintenance) {
                if ($maintenance instanceof ServMaintenance_Model_TacheMaintenance) {
                    $maintenance->cloture();
                }
            }
        }
        return TRUE;
    }

    public static function actualisationlstTacheUrgenteAplanifier() {
        self::init();
        /*
          $lstTacheUrgenteAplanifier = array();
          $lstTacheUrgenteAplanifier[] = array('noAvion' => 3, 'typeMaintenance' => '18');
          Application_Model_ApplicationVar::set('lstTacheUrgenteAplanifier', $lstTacheUrgenteAplanifier);
         */

        //Déterminer à chaque début de semaine les tâches urgentes si pas effectué
        Application_Model_ApplicationVar::set('lstTacheUrgenteAplanifier', array());
        $lstTacheUrgenteAplanifier = array();
        //$TypeMaintenanceByModele = array(array());
        $TypesMaintenance = ServMaintenance_Model_TypeMaintenance::findAll();
        foreach ($TypesMaintenance as $TypeMaintenance) {
            if ($TypeMaintenance instanceof ServMaintenance_Model_TypeMaintenance) {
                $TypeMaintenanceByModele[$TypeMaintenance->get_noModele()][$TypeMaintenance->get_noTypeMaintenance()] = $TypeMaintenance;
            }
        }
        $Avions = ServMaintenance_Model_Avion::findAllEnServiceAtCurrentTime();
        foreach ($Avions as $Avion) {
            if ($Avion instanceof ServMaintenance_Model_Avion) {
                if (isset($TypeMaintenanceByModele[$Avion->get_noModele()])) {
                    $TypesMaintenance = $TypeMaintenanceByModele[$Avion->get_noModele()];
                    foreach ($TypesMaintenance as $TypeMaintenance) {
                        if ($TypeMaintenance instanceof ServMaintenance_Model_TypeMaintenance) {
                            if (!(ServMaintenance_Model_TacheMaintenance::findOneByAvionAtCurrentTime($Avion->get_noAvion()) instanceof ServMaintenance_Model_TacheMaintenance)) {
                                $TacheMaintenance = self::FindLastMaintenanceByAvionByTypeMaintenance($Avion->get_noAvion(), $TypeMaintenance->get_noTypeMaintenance());
                                if ($TacheMaintenance instanceof ServMaintenance_Model_TacheMaintenance) {
                                    $Vols = ServPlaning_Model_Vol::getVolsByAvionFromDateTimeEffectif(new DateTime($TacheMaintenance->get_dateFin()), $Avion->get_noAvion());
                                    if (is_array($Vols) && count($Vols > 0)) {
                                        $nbHeuredeVol = 0;
                                        foreach ($Vols as $Vol) {
                                            if ($Vol instanceof ServPlaning_Model_Vol) {
                                                $start = new DateTime($Vol->get_heuredecollage());
                                                $end = new DateTime($Vol->get_heureAtterissage());
                                                $diff = $start->diff($end, TRUE);
                                                $nbHeuredeVol+=$diff->h;
                                            }
                                        }
                                        if ($nbHeuredeVol >= $TypeMaintenance->get_periode()) {

                                            if (!self::IsPlanifierByTypeMaintenanceByAvionAtCurrentTime($TypeMaintenance->get_noTypeMaintenance(), $Avion->get_noAvion())) {
                                                $lstTacheUrgenteAplanifier[] = 
                                                array(
                                                    'noAvion' => $Avion->get_noAvion(), 
                                                    'typeMaintenance' => $TypeMaintenance->get_noTypeMaintenance(),
                                                    'nbHeuredeVol' => $nbHeuredeVol - $TypeMaintenance->get_periode()
                                                );
                                            } else {
                                                //maintenance déjà prévu XD
                                            }
                                        } else {
                                            //out;
                                            //heure de vol osef
                                        }
                                    } else {
                                        //out;
                                        //aucun vols depuis la dernière maintenance de ce type
                                    }
                                } else {
                                    //err Récupération Maintenances
                                    //ou
                                    //aucune maintenace de ce type encore effectué
                                }
                            } else {
                                echo 'Maintenance en cours';
                                //out Maintenance en cours
                            }
                        } else {
                            return FALSE;
                        }
                    }
                } else {
                    //aucun type de maintenance pour ce modèle
                }
            } else {
                return FALSE;
            }
        }
        Application_Model_ApplicationVar::set('lstTacheUrgenteAplanifier', $lstTacheUrgenteAplanifier);
        return TRUE;
    }

    public static function findAll() {
        self::init();
        return self::$mapper->findAll();
    }

    public static function findAllbyTypeMaintenance($TypeMaintenance) {
        self::init();
    }

    public static function findOne($noTacheMaintenance) {
        self::init();
        return self::$mapper->find($noTacheMaintenance);
    }

    public static function IsPlanifierByTypeMaintenanceByAvionAtCurrentTime($TypeMaintenance, $noAvion) {
        self::init();
        $Tache = self::$mapper->getTachePlanifierByTypeMaintenanceByAvionAtCurrentTime($TypeMaintenance, $noAvion);
        if (count($Tache) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function findAllAtCurrentTime() {
        self::init();
        return self::$mapper->findAllAtCurrentTime();
    }

    public static function findAllAtDateTimeInterval($start, $end) {
        self::init();
    }

    public static function findAllByAvionAtDateTimeInterval(DateTime $start, DateTime $end, $noAvion) {
        self::init();
        return self::$mapper->findAllByAvionAtDateTimeInterval($start,$end,$noAvion);
    }

    public static function findOneByAvionAtCurrentTime($noAvion) {
        self::init();
        return self::$mapper->findOneByAvionAtCurrentTime($noAvion);
    }

    public static function IsOnMaintenanceAtCurrentByAvion($noAvion) {
        self::init();
    }

    public static function repercutionMiseHorsServiceAvion($noAvion, $DateTime) {
        self::init();
    }

//**************************************************************************
//public
    public function save() {
        self::init();
        self::$mapper->save($this, 'noMaintenance');
    }

    public function cloture() {
        self::init();
        $this->set_etat(self::TACHE_FINIE);
    }

//**************************************************************************
//private static
//**************************************************************************
//private
//**************************************************************************
//  Setter / Getter
//**************************************************************************

    public function get_noMaintenance() {
        return $this->_noMaintenance;
    }

    public function set_noMaintenance($_noMaintenance) {
        $this->_noMaintenance = $_noMaintenance;
        return $this;
    }

    public function get_dateDebut() {
        return $this->_dateDebut;
    }

    public function set_dateDebut($_dateDebut) {
        $this->_dateDebut = $_dateDebut;
        return $this;
    }

    public function get_dateFin() {
        return $this->_dateFin;
    }

    public function set_dateFin($_dateFin) {
        $this->_dateFin = $_dateFin;
        return $this;
    }

    public function get_retard() {
        return $this->_retard;
    }

    public function set_retard($_retard) {
        $this->_retard = $_retard;
        return $this;
    }

    public function get_noTypeMaintenance() {
        return $this->_noTypeMaintenance;
    }

    public function set_noTypeMaintenance($_noTypeMaintenance) {
        $this->_noTypeMaintenance = $_noTypeMaintenance;
        return $this;
    }

    public function get_etat() {
        return $this->_etat;
    }

    public function set_etat($etat) {
        $this->_etat = $etat;
        return $this;
    }

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
        return $this;
    }

    public function get_rapport() {
        return $this->_rapport;
    }

    public function set_rapport($rapport) {
        $this->_rapport = $rapport;
        return $this;
    }

}

