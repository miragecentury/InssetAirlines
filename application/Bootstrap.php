<?php

/** Boostrap (Lanceur de Zend)
 * 
 *  
 *  @author Projet-Insset-Grp3
 * 
 */
/* TODO: Boostrap : cre: Victorien VANROYE
 *  Ajouter les Exceptions XP voir en créer pour l'application 
 *  MyException extends Zend_Exception
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /** TODO: Bootstrap : Optimisation:
     *  - $validate_ip deux vérifications si $_SERVER['HTTP_HOST']
     */
// Système dit Primaire Log + Cache
    protected function _initConfig()
    {
        $Config = $this->getOptions();
        Zend_Registry::set('Config', $Config);
        return $Config;
    }

    /**
     * @method _initLog()
     * 
     * @return Zend_Log 
     */
    protected function _initLog()
    {

        $logConfig = $this->getOption('log');

        try {
            $Log = Spesx_Log::Factory($logConfig);
        } catch (Spesx_Log_Exception $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if ($Log === null || $Log === FALSE) {
            $Log = new Zend_Log();
            $Log->addWriter(new Zend_Log_Writer_Null());
        };

        return $Log;
    }

//Fin Log - Début Cache

    protected function _initCache()
    {
//require l'initialisation de Log (_initLog)
        parent::_executeResource('Log');

        /* ================================================================== */
// Début de la récupération des configurations du cache
        try {
            $config = $this->getOption('cache');
        } catch (Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initCache : Cache Désactivé', Zend_Log::DEBUG);
            Zend_Registry::set('Cache', FALSE);
            return FALSE;
        }

//initialisation du filtre pour la récupération [true|false] du ini 
        $filtre_bool = new Zend_Filter_Boolean('all');
        $config['activeResourceq'] = $filtre_bool->filter($config['activeResourceq']);
        $config['active'] = $filtre_bool->filter($config['active']);

//nettoyage
        unset($filtre_bool);

// test sur le application.ini cache.active = [false|true]
        if ($config['active']) {


            /* ================================================================== */
//  Début de la récupération des ressources Personnalisées et envoyées 
// dans le Registery

            if ($config['activeResourceq']) {

                $cache_Sys = array();
                if (isset($config['resourceq']) && (count($config['resourceq']) > 0)) {
                    try {
                        foreach ($config['ressourceq'] as $key => $value) {
                            if ($value['frontOptions']['type'] == 'Core') {
                                $value['frontOptions']['cache_id_prefix'] = $config['idApplication'];
                            }
                            try {
                                $cache_Sys[$key] = Zend_Cache::factory($value['frontOptions']['type'], $config['adapter'], $value['frontOptions'], $config['back']);
                            } catch (Zend_Cache_Exception $e) {
                                Zend_Registry::get('Log')->log('Bootstrap : _initCache : Zend_Cache_Exception : Impossible de créer le Zend_Cache', Zend_Log::ALERT);
                                return FALSE;
                            } catch (Exception $e) {
                                Zend_Registry::get('Log')->log('Bootstrap : _initCache : Exception : Impossible de créer le Zend_Cache', Zend_Log::ALERT);
                                return FALSE;
                            }

                            try {
                                if (!($data = $cache_Sys[$key]->load($key))) {
                                    if ($cache_Sys[$key]->save(($data = $this->$key()), $key)) {
                                        try {
                                            Zend_Registry::set($key, $data);
                                        } catch (Zend_Exception $e) {
                                            Zend_Registry::get('Log')->log('Bootstrap : _initCache : Set dans le Registery Impossible', Zend_Log::ALERT);
                                            return FALSE;
                                        } catch (Exception $e) {
                                            Zend_Registry::get('Log')->log('Bootstrap : _initCache : Set dans le Registery Impossible', Zend_Log::ALERT);
                                            return FALSE;
                                        }
                                    } else {
                                        Zend_Registry::get('Log')->log('Bootstrap : _initCache : Impossible de save une ressource', Zend_Log::ALERT);
                                    }
                                } else {
                                    try {
                                        Zend_Registry::set($key, $data);
                                        Zend_Registry::get('Log')->log('Bootstrap : _initCache : Chargement de ' . $key . ' dans le Registery', Zend_Log::DEBUG);
                                    } catch (Exception $e) {
                                        Zend_Registry::get('Log')->log('Bootstrap : _initCache : Exception : Impossible de mettre dans le Registry ' . $key . " ");
                                    }
                                }
                            } catch (Zend_Cache_Exception $e) {
                                Zend_Registry::get('Log')->log('Bootstrap : _initCache : Zend_Cache_Exception : Appel ou Save Error', Zend_Log::ALERT);
                                return FALSE;
                            } catch (Exception $e) {
                                Zend_Registry::get('Log')->log('Bootstrap : _initCache : Exception : Appel ou Save Error', Zend_Log::ALERT);
                                return FALSE;
                            }
                        }
                    } catch (Exception $e) {
                        Zend_Registry::get('Log')->log('Bootstrap : _initCache : foreach Erreur', Zend_Log::ALERT);
                        return FALSE;
                    }
                } else {
                    Zend_Registry::get('Log')->log('Bootstrap : _initCache : Aucune cache.ressourceq[] vérifier la déclaration si anormal sinon désactivé le cache merci', Zend_Log::NOTICE);
                }
//nettoyage
                unset($cache_Sys);
            } else {
//Zend_Registry::get('Log')->log('Bootstrap : _initCache : Cache désactivé', Zend_Log::DEBUG);
//chargement dans le registry des Class en manuel
            }
            /* ================================================================== */
//  Début de l'initialisation du Cache du système
            $cache_Sys = Zend_Cache::factory($config['frontOptions']['type'], $config['adapter'], $config['frontOptions'], $config['back']);

            Zend_Registry::set('Cache', $cache_Sys);
            return $cache_Sys;
        } else {

//return FALSE et set FALSE pour communiquer au autre système dépendant que le cache est Out ou désactivé
            Zend_Registry::get('Log')->log('Bootstrap : _initCache : Cache Désactivé', Zend_Log::DEBUG);
            Zend_Registry::set('Cache', FALSE);
            return FALSE;
        }
    }

    /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Système Secondaire Db + Acl

    protected function _initDb()
    {
        parent::_executeResource('Log');
        parent::_executeResource('Cache');
        $config = $this->getOptions();
        if (
            isset($config['resources']) &&
            isset($config['resources']['db']) &&
            isset($config['resources']['db']['adapter']) &&
            isset($config['resources']['db']['params']) &&
            isset($config['resources']['db']['params']['host']) &&
            isset($config['resources']['db']['params']['username']) &&
            isset($config['resources']['db']['params']['password']) &&
            isset($config['resources']['db']['params']['dbname'])
        ) {
            try {
                $adapter = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
                Zend_Registry::set('Db', $adapter);
                Zend_Db_Table_Abstract::setDefaultAdapter($adapter);
                return $adapter;
            } catch (Zend_Db_Exception $e) {
                $message = "Bootstrap : Exception Zend_Db : Impossible de se connecter à la base de données : Fermeture Application";
                echo $message;
            } catch (Exception $e) {
                $message = "Bootstrap : Exception : Fermeture Application";
                echo $message;
            }
            return FALSE;
        } else {
            $message = "Bootstrap : Impossible de trouver les paramètres de connection a la base de donnée.";
            echo $message;
            return FALSE;
        }
    }

    protected function _initAcl()
    {
//require avant démarrage
        parent::_executeResource('Log');
        parent::_executeResource('Cache');

        $filter_bool = new Zend_Filter_Boolean('all');
        $validate_file_exists = new Zend_Validate_File_Exists();
        $validate_file_extension = new Zend_Validate_File_Extension('ini');

        try {
            $config = $this->getOption('acl');
            $config_cache = $this->getOption('cache');
        } catch (Exception $e) {
            Zend_Registry::get('Log');
            return FALSE;
        }

        if (isset($config['active']) && !empty($config['active'])) {
            $config['active'] = $filter_bool->filter($config['active']);
        } else {
            $config['active'] = FALSE;
        }

        if (isset($config['active_assertion']) && !empty($config['active_assertion'])) {
            $config['active_assertion'] = $filter_bool->filter($config['active_assertion']);
        } else {
            $config['active_assertion'] = FALSE;
        }
        //echo '../application/configs/' . $config['filename'];
        //var_dump($validate_file_exists->isValid('../application/configs/' . $config['filename']));
        //if ($config['active'] && $validate_file_exists->isValid('../application/configs/'.$config['filename']) && $validate_file_extension->isValid('../application/configs/'.$config['filename'])) {
        if ($config['active']) {
            if (isset($config['cache']['active']) && !empty($config['cache']['active'])) {
                $config['cache']['active'] = $filter_bool->filter($config['cache']['active']);
            }
            if ((Zend_Registry::get('Cache') != FALSE)) {
                if ($config['cache']['active']) {
                    $cache = Zend_Registry::get('Cache');
                    if (!($data = $cache->load($config_cache['idApplication'] . 'Acl')) && FALSE) {
                        echo 'Acl get in cache';
                        //var_dump($data);
                        //$data = Zend_Serializer::unserialize($data);
                        return $data;
                    } else {
                        echo 'Acl set in cache';
                        $acl = $acl = $this->getAcl('../application/configs/' . $config['filename']);
                        $Sadap = new Zend_Serializer_Adapter_Amf0();
                        Zend_Serializer::setDefaultAdapter($Sadap);
                        $data = Zend_Serializer::serialize($acl);

                        var_dump($data);
                        try {
                            $cache->save($config_cache['idApplication'] . 'Acl', $data);
                        } catch (Exception $e) {
                            Zend_Registry::get('Log')->log('Bootstrap : _initAcl : Exception : Impossible de Mettre l\'Acl dans le Cache', Zend_Log::ALERT);
                        }
                    }
                    return $acl;
                } else {
                    Zend_Registry::set('Acl', ($acl = $this->getAcl('../application/configs/' . $config['filename'])));
                    return $acl;
                }
            } else {
                Zend_Registry::set('Acl', ($acl = $this->getAcl('../application/configs/' . $config['filename'])));
                return $acl;
            }
        } else {
            Zend_Registry::set('Acl', FALSE);
            Zend_Registry::get('Log')->log('Bootstrap : _initAcl : Acl Désactivé', Zend_Log::DEBUG);
            return FALSE;
        }

//nettoyage
        unset($filter_bool);
        unset($validate_file_exists);
        unset($validate_file_extension);
    }

    private function getAcl($PathToIniAclFile = '../application/configs/acl.ini')
    {
        $acl = new Zend_Acl();
        $validate_file_exists = new Zend_Validate_File_Exists();
        $validate_file_extension = new Zend_Validate_File_Extension('ini');

        //if ($validate_file_exists->isValid($PathToIniAclFile) && $validate_file_extension->isValid($PathToIniAclFile)) {
        if (TRUE) {
            try {
                $acl_role = new Zend_Config_Ini($PathToIniAclFile, 'roles');
                $acl_resources = new Zend_Config_Ini($PathToIniAclFile, 'resources');
                $acl_role = $acl_role->toArray();
                $acl_resources = $acl_resources->toArray();
            } catch (Zend_Config_Exception $e) {
                Zend_Registry::get('Log')->log('Bootstrap : getAcl : Forme de ' . $PathToIniAclFile . ' Incorrecte', Zend_Log::ALERT);
                return FALSE;
            } catch (Exception $e) {
                Zend_Registry::get('Log')->log('Bootstrap : getAcl : Forme de ' . $PathToIniAclFile . ' Incorrecte', Zend_Log::ALERT);
                return FALSE;
            }

            $trigger_role_herit = array();
            foreach ($acl_role as $key => $value) {
                $acl->addRole($key);
                if (isset($value['herit']) && (count($value['herit']) > 0)) {
                    $trigger_role_herit[] = $key;
                }
            }

            foreach ($acl_resources as $key => $value) {
                $acl->addResource($key);
                if (isset($value['allow']) && (count($value['allow']) > 0)) {
                    foreach ($value['allow'] as $roles) {
                        $acl->allow($roles, $key);
                    }
                }
                if (isset($value['deny']) && (count($value['deny']) > 0)) {
                    foreach ($value['deny'] as $roles) {
                        $acl->deny($roles, $key);
                    }
                }
            }
            return $acl;
        } else {
            Zend_Registry::get('Log')->log('Bootstrap : getAcl : Impossible de charger le fichier .ini des acl Vérifier le fichier de configuration', Zend_Log::ALERT);
            return FALSE;
        }



        //nettoyage
        unset($validate_file_exists);
        unset($validate_file_extension);
    }

    /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Système Tertiaire Translate + View...

    protected function _initTranslate()
    {
        $locale = new Zend_Locale('fr');
        $translator = FALSE;
        try {
            $translator = new Zend_Translate(
                    array(
                        'adapter' => 'array',
                        'content' => '../data/Language/',
                        'locale' => $locale,
                        'scan' => Zend_Translate::LOCALE_DIRECTORY
                    )
            );
            Zend_Validate_Abstract::setDefaultTranslator($translator);
        } catch (Zend_Translate_Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initTranslate : Impossible de charger le module de traduction.', Zend_Log::ALERT);
        } catch (Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initTranslate : Impossible de charger le module de traduction.', Zend_Log::ALERT);
        }
        return $translator;
    }

    public function _initView()
    {
        //initialisation de la view
        $view = new Zend_View;
        $view->doctype('HTML5');
        $view->headTitle('Insset Airlines');
        $view->headTitle()->setSeparator('-');
        $view->headLink()->prependStylesheet('/ressource/css/reset.css')
            ->appendStylesheet('/ressource/css/960.css')
            ->appendStylesheet('/ressource/css/text.css');

        //configuration du renderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

    protected function _initViewSiteBar()
    {
        $this->bootstrap('View');
        try {
            $view = $this->getResource('View');
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initView : Zend_exception 
                : Echec de récuperation de la ressource view !');
        } catch (Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initView : Exception inconnue !');
        }

        //configuration initial du sidebar
        $view->placeholder('sidebar')
            ->setPrefix("<ul>\n<li>")
            ->setSeparator("</li>\n<li>")
            ->setPostfix("</li>\n</ul>\n");

        return true;
    }

    protected function _initLogin()
    {
        $this->bootstrap('View');
        try {
            $view = $this->getResource('View');
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initView : Zend_exception 
                : Echec de récuperation de la ressource view !');
        } catch (Exception $e) {
            Zend_Registry::get('Log')->log('Bootstrap : _initView : Exception inconnue !');
        }
        $view->placeholder('login');
    }

    
    // A refaire en beaucoup mieux, la gestion des autoloader marche, mais n'est pas opti
    
    // -_-' regarde la fonction $this->getAppNamespace()->addResourceType($type, $path, $namespace)
    public function _initAutoload()
    {
        $autoloaderExp = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServExploitation',
                'basePath' => dirname(__FILE__) . '/modules/ServExploitation'));
        $autoloaderCom = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServCommercial',
                'basePath' => dirname(__FILE__) . '/modules/ServCommercial'));

        $autoloaderDRH = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServDRH',
                'basePath' => dirname(__FILE__) . '/modules/ServDRH'));
        $autoloaderAdm = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'Admin',
                'basePath' => dirname(__FILE__) . '/modules/Admin'));

        $autoloaderAgv = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'AgenceVoyage',
                'basePath' => dirname(__FILE__) . '/modules/AgenceVoyage'));

        $autoloaderLog = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServLogCom',
                'basePath' => dirname(__FILE__) . '/modules/ServLogCom'));
        $autoloaderMai = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServMaintenance',
                'basePath' => dirname(__FILE__) . '/modules/ServMaintenance'));

        $autoloaderPla = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServPlaning',
                'basePath' => dirname(__FILE__) . '/modules/ServPlaning'));

        $autoloaderStr = new Zend_Application_Module_Autoloader(array(
                'namespace' => 'ServStrategique',
                'basePath' => dirname(__FILE__) . '/modules/ServStrategique'));
        return array($autoloaderExp,$autoloaderCom,$autoloaderDRH,
            $autoloaderAdm,$autoloaderAgv,$autoloaderLog,$autoloaderMai,
            $autoloaderPla,$autoloaderStr);
    }
}

