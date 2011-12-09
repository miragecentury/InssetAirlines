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
        if (Spesx_Cache::test($id)) {
            return unserialize(Spesx_Cache::load($id));
        } else {
            self::init();
            $item = self::$mapper->find($id);

            if ($item instanceof Application_Model_ApplicationVar) {
                $var = unserialize($item->get_var());
                Spesx_Cache::save(serialize($var), $id);
                return $var;
            } else {
                return null;
            }
        }
    }

    public static function set($id, $var) {
        self::init();
        $item = new Application_Model_ApplicationVar();
        $item->set_id($id);
        $item->set_var(serialize($var));
        try {
            $item->save();
            Spesx_Cache::save(serialize($var), $id);
        } catch (Exception $e) {
            return FALSE;
        }
        return TRUE;
    }

    public static function checkEventUpdate() {
        //var_dump(new DateTime(null));

        $Interrupt_Cache = FALSE;

        $CurrentDate = new DateTime();

        $UpdateCipherAnnee = Application_Model_ApplicationVar::get('UpdateCipherAnnee');
        if ($UpdateCipherAnnee === null) {
            $UpdateCipherAnnee = (String) ($CurrentDate->format('Y') - 1);
            Application_Model_ApplicationVar::set('UpdateCipherAnnee', $UpdateCipherAnnee);
        }

        //**********************************************************************

        $UpdateCipherMois = Application_Model_ApplicationVar::get('UpdateCipherMois');
        if ($UpdateCipherMois === null) {
            $UpdateCipherMois = (String) ($CurrentDate->format('m') - 1);
            Application_Model_ApplicationVar::set('UpdateCipherMois', $UpdateCipherMois);
        }


        //**********************************************************************


        $UpdateCipherSemaine = Application_Model_ApplicationVar::get('UpdateCipherSemaine');
        if ($UpdateCipherSemaine === null) {
            $UpdateCipherSemaine = (String) ($CurrentDate->format('W') - 1);
            Application_Model_ApplicationVar::set('UpdateCipherSemaine', $UpdateCipherSemaine);
        }

        //**********************************************************************

        $UpdateCipherJour = Application_Model_ApplicationVar::get('UpdateCipherJour');
        if ($UpdateCipherJour === null) {
            $UpdateCipherJour = (String) ($CurrentDate->format('d') - 1);
            Application_Model_ApplicationVar::set('UpdateCipherJour', $UpdateCipherJour);
        }


        //**********************************************************************
        if ($UpdateCipherAnnee != $CurrentDate->format('Y')) {
            //echo 'Update Annee';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementAnnee();
            if ($boolInt == 1){
                Spesx_Log::LogINFO('Update Annee Ok');
                Application_Model_ApplicationVar::set('UpdateCipherAnnee', $CurrentDate->format('Y'));
            } else {
                Spesx_Log::LogINFO('Update Annee Err:');
            }
        }

        if ($UpdateCipherMois != $CurrentDate->format('m')) {
            //echo 'Update Mois';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementMois();

            if ($boolInt == 1) {
                Spesx_Log::LogINFO('Update Mois Ok');
                Application_Model_ApplicationVar::set('UpdateCipherMois', $CurrentDate->format('m'));
            } else {
                Spesx_Log::LogINFO('Update Mois Err:');
            }
        }
        if ($UpdateCipherSemaine != $CurrentDate->format('W')) {
            //echo 'Update Annee';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementSemaine();
            $boolInt += (INT) ServExploitation_Model_Incident::changementSemaine();

            if ($boolInt == 2) {
                Spesx_Log::LogINFO('Update Semaine Ok');
                Application_Model_ApplicationVar::set('UpdateCipherSemaine', $CurrentDate->format('W'));
            } else {
                Spesx_Log::LogINFO('Update Semaine Err:');
            }
        }
        if ($UpdateCipherJour != $CurrentDate->format('d')) {
            //echo 'Update Jour';
            $boolInt = 0;
            $boolInt += (INT) ServStrategique_Model_Ligne::changementJour();

            if ($boolInt == 1) {
                Spesx_Log::LogINFO('Update Jour Ok');
                Application_Model_ApplicationVar::set('UpdateCipherJour', $CurrentDate->format('d'));
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
