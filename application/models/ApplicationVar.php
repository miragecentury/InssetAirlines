<?php

class Application_Model_ApplicationVar {

    protected $_id;
    protected $_var;
    private static $mapper = null;

    private static function init() {
        if (self::$mapper === null) {
            self::$mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_ApplicationVar');
        }
    }

    public static function getAll() {
        self::init();
        return self::$mapper->findAll();
    }

    public static function get($id) {
        self::init();
        $item = self::$mapper->find($id);

        if ($item instanceof Application_Model_ApplicationVar) {
            return $item->get_var();
        } else {
            return null;
        }
    }

    public static function set($id, $var) {
        self::init();
        $item = new Application_Model_ApplicationVar();
        $item->set_id($id);
        $item->set_var($var);
        try {
            $item->save();
        } catch (Exception $e) {
            return FALSE;
        }
        return TRUE;
    }

    public static function checkEventUpdate() {
        //var_dump(new DateTime(null));

        $Interrupt_Cache = FALSE;

        $CurrentDate = new DateTime();
        if (Spesx_Cache::test('UpdateCipherAnnee') && $Interrupt_Cache) {
            Spesx_Log::LogINFO('Update Annee Load');
            $UpdateCipherAnnee = Spesx_Cache::load('UpdateCipherAnnee');
        } else {
            $UpdateCipherAnnee = Application_Model_ApplicationVar::get('UpdateCipherAnnee');
            if ($UpdateCipherAnnee === null) {
                $UpdateCipherAnnee = (String) ($CurrentDate->format('Y') - 1);
                Application_Model_ApplicationVar::set('UpdateCipherAnnee', $UpdateCipherAnnee);
            }
            Spesx_Cache::save($UpdateCipherAnnee, 'UpdateCipherAnnee');
        }
        //**********************************************************************

        if (Spesx_Cache::test('UpdateCipherMois') && $Interrupt_Cache) {
            $UpdateCipherMois = Spesx_Cache::load('UpdateCipherMois');
            Spesx_Log::LogINFO('Update Mois Load');
        } else {
            $UpdateCipherMois = Application_Model_ApplicationVar::get('UpdateCipherMois');
            if ($UpdateCipherMois === null) {
                $UpdateCipherMois = (String) ($CurrentDate->format('m') - 1);
                Application_Model_ApplicationVar::set('UpdateCipherMois', $UpdateCipherMois);
            }
            Spesx_Cache::save($UpdateCipherMois, 'UpdateCipherMois');
        }

        //**********************************************************************

        if (Spesx_Cache::test('UpdateCipherSemaine') && $Interrupt_Cache) {
            Spesx_Log::LogINFO('Update Semaine Load');
            $UpdateCipherSemaine = Spesx_Cache::load('UpdateCipherSemaine');
        } else {
            $UpdateCipherSemaine = Application_Model_ApplicationVar::get('UpdateCipherSemaine');
            if ($UpdateCipherSemaine === null) {
                $UpdateCipherSemaine = (String) ($CurrentDate->format('W') - 1);
                Application_Model_ApplicationVar::set('UpdateCipherSemaine', $UpdateCipherSemaine);
            }
            Spesx_Cache::save($UpdateCipherSemaine, 'UpdateCipherSemaine');
        }

        //**********************************************************************

        if (Spesx_Cache::test('UpdateCipherJour') && $Interrupt_Cache) {
            Spesx_Log::LogINFO('Update Jour Load');
            $UpdateCipherJour = Spesx_Cache::load('UpdateCipherJour');
        } else {
            $UpdateCipherJour = Application_Model_ApplicationVar::get('UpdateCipherJour');
            if ($UpdateCipherJour === null) {
                $UpdateCipherJour = (String) ($CurrentDate->format('d') - 1);
                Application_Model_ApplicationVar::set('UpdateCipherJour', $UpdateCipherJour);
            }
            Spesx_Cache::save($UpdateCipherJour, 'UpdateCipherJour');
        }

        //**********************************************************************
        if ($UpdateCipherAnnee != $CurrentDate->format('Y')) {
            //echo 'Update Annee';
            $boolInt = 0;

            if ($boolInt == 0) {
                Spesx_Log::LogINFO('Update Annee Ok');
                Application_Model_ApplicationVar::set('UpdateCipherAnnee', $CurrentDate->format('Y'));

                Spesx_Cache::save($CurrentDate->format('Y'), 'UpdateCipherAnnee');
            } else {
                Spesx_Log::LogINFO('Update Annee Err:');
            }
        }

        if ($UpdateCipherMois != $CurrentDate->format('m')) {
            //echo 'Update Mois';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementMois();
            $boolInt += (INT) ServPlaning_Model_Vol::changementMois();
            if ($boolInt == 2) {
                Spesx_Log::LogINFO('Update Mois Ok');
                Application_Model_ApplicationVar::set('UpdateCipherMois', $CurrentDate->format('m'));
                Spesx_Cache::save($CurrentDate->format('m'), 'UpdateCipherMois');
            } else {
                Spesx_Log::LogINFO('Update Mois Err:');
            }
        }
        if ($UpdateCipherSemaine != $CurrentDate->format('W')) {
            //echo 'Update Annee';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementSemaine();
            $boolInt += (INT) ServMaintenance_Model_TacheMaintenance::changementSemaine();
            $boolInt += (INT) ServPlaning_Model_Vol::changementSemaine();
            if ($boolInt == 3) {
                Spesx_Log::LogINFO('Update Semaine Ok');
                Application_Model_ApplicationVar::set('UpdateCipherSemaine', $CurrentDate->format('W'));
                Spesx_Cache::save($CurrentDate->format('W'), 'UpdateCipherSemaine');
            } else {
                Spesx_Log::LogINFO('Update Semaine Err:');
            }
        }
        if ($UpdateCipherJour != $CurrentDate->format('d')) {
            //echo 'Update Jour';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementJour();
            $boolInt += (INT) ServPlaning_Model_Vol::changementJour();
            if ($boolInt == 2) {
                Spesx_Log::LogINFO('Update Jour Ok');
                Application_Model_ApplicationVar::set('UpdateCipherJour', $CurrentDate->format('d'));
                Spesx_Cache::save($CurrentDate->format('d'), 'UpdateCipherJours');
            } else {
                Spesx_Log::LogINFO('Update Jour Err:');
            }
        }
    }

    public function save() {
        self::init();

        return self::$mapper->savebyLabel($this, 'id');
    }

    //**************************************************************************
    // Setter / Getter
    //**************************************************************************

    public function set_id($id) {
        $this->_id = $id;
        return $this;
    }

    public function get_id() {
        return $this->_id;
    }

    public function set_var($var) {
        $this->_var = $var;
        return $this;
    }

    public function get_var() {
        return $this->_var;
    }

}

?>
