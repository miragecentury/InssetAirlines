<?php

class ServMaintenance_Model_TacheMaintenance {

    protected $_noMaintenance;
    protected $_dateDebut;
    protected $_dateFin;
    protected $_retard;
    protected $_noTypeMaintenance;
    protected $_noAvion;
    private static $mapper = null;

    private static function init() {
        if (self::$mapper === null) {
            self::$mapper = Spesx_Mapper_MapperFactory::getMapper('ServMaintenance_Model_TacheMaintenance');
        }
    }

    //**************************************************************************
    //public static

    public static function getPlusLongueTypeMaintenance() {
        
    }

    public static function nbMaintenanceEnCoursAujourdhui() {
        
    }

    public static function nbMaintenanceAtDateTimeInterval($Strat, $End) {
        
    }

    public static function changementSemaine() {
        return FALSE;
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

    public static function findAllAtCurrentDay() {
        self::init();
    }

    public static function findAllAtCurrentTime() {
        self::init();
    }

    public static function findAllAtDateTimeInterval($start, $end) {
        self::init();
    }

    public static function findAllByAvionAtDateTimeInterval($start, $end, $noAvion) {
        self::init();
    }

    public static function findOneByAvionAtCurrentTime($noAvion) {
        self::init();
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

    public function isPrioritaire() {
        
    }

    public function IsOnMaintenanceAtCurrent() {
        self::init();
        return self::IsOnMaintenanceAtCurrent($this->_noMaintenance);
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
    }

    public function get_dateDebut() {
        return $this->_dateDebut;
    }

    public function set_dateDebut($_dateDebut) {
        $this->_dateDebut = $_dateDebut;
    }

    public function get_dateFin() {
        return $this->_dateFin;
    }

    public function set_dateFin($_dateFin) {
        $this->_dateFin = $_dateFin;
    }

    public function get_retard() {
        return $this->_retard;
    }

    public function set_retard($_retard) {
        $this->_retard = $_retard;
    }

    public function get_noTypeMaintenance() {
        return $this->_noTypeMaintenance;
    }

    public function set_noTypeMaintenance($_noTypeMaintenance) {
        $this->_noTypeMaintenance = $_noTypeMaintenance;
    }

    public function get_noAvion() {
        return $this->_noAvion;
    }

    public function set_noAvion($_noAvion) {
        $this->_noAvion = $_noAvion;
    }

}

?>
