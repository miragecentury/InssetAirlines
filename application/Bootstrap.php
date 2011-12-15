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

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /** TODO: Bootstrap : Optimisation:
     *  - $validate_ip deux vérifications si $_SERVER['HTTP_HOST']
     */
// Système dit Primaire Log + Cache
    protected function _initConfig() {
        $Config = $this->getOptions();
        Zend_Registry::set('Config', $Config);

        //Pare-feu (Site dans un dossier d'un domaine)
        // le helper n'étant pas accessible hors des vues
        // on utilise cette méthode
        Zend_Registry::set('BaseUrl', $Config['InssetAirlines']['BaseUrl']);
        if (isset($Config['InssetAirlines']['BaseUrlDocumentRoot'])) {
            /**
             * Distribue la requête avec une base d'URL réglé
             * avec Zend_Controller_Front.
             */
            $router = new Zend_Controller_Router_Rewrite();
            $controller = Zend_Controller_Front::getInstance();
            $controller->setControllerDirectory('./application/controllers')
                    ->setRouter($router)
                    ->setBaseUrl($Config['InssetAirlines']['BaseUrlDocumentRoot']); // affecte la base d'url
            $response = $controller->dispatch();
        }


        return $Config;
    }

    /**
     * @method _initLog()
     *
     * @return Zend_Log
     */
    protected function _initLog() {

//récupération de la configuration
        $logConfig = $this->getOption('log');

        try {
            $Log = Spesx_Log::Factory($logConfig);
        } catch (Spesx_Log_Exception $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        //pare-feu de control
        if ($Log === null || $Log === FALSE) {
            $Log = new Zend_Log();
            $Log->addWriter(new Zend_Log_Writer_Null());
        };

        //Retro-compatibilité avec l'ancienne version
        Zend_Registry::set('Log', $Log);

        return $Log;
    }

//Fin Log - Début Cache

    protected function _initCache() {
//require l'initialisation de Log (_initLog)
        parent::_executeResource('Log');
        $cache = null;
        $cacheConfig = $this->getOption('cache');
        try {
            $cache = Spesx_Cache::factory($cacheConfig, Spesx_Log::ReturnZendLog());
        } catch (Exception $e) {
            echo 'Spesx_Cache_Exception XS it\'s bad <br/>' . $e->getMessage();
        }

        //var_dump($cache->save('test', 'test'));
        //var_dump($cache->load('test'));

        if ($cache === null | $cache === FALSE) {
            $cache = Zend_Cache::factory(new Zend_Cache_Core(), new Zend_Cache_Backend_BlackHole());
            Spesx_Log::LogERR('Spesx_Cache::factory retourne une cache invalide');
        }



        return $cache;
    }

    /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Système Secondaire Db + Acl

    protected function _initDb() {
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
                echo $e->getMessage();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            return FALSE;
        } else {
            $message = "Bootstrap : Impossible de trouver les paramètres de connection a la base de donnée.";
            echo $message;
            return FALSE;
        }
    }

    protected function _initAcl() {
//require avant démarrage
        parent::_executeResource('Log');
        parent::_executeResource('Cache');

        $acl_config = $this->getOption('acl');

        $acl = null;

        try {
            $acl = Spesx_Acl::factory($acl_config, Spesx_Log::ReturnZendLog(), Spesx_Cache::ReturnZendCache());
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if ($acl === null || $acl === FALSE || !is_a($acl, 'Zend_Acl')) {
            $acl = Spesx_Acl::ReturnEmptyAcl();
        }
        //echo '<br/>';
        //var_dump($acl);
        //Retro-compatibilité avec l'ancienne version
        Zend_Registry::set('Acl', Spesx_Acl::ReturnZendAcl());

        return $acl;
    }

    /* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

// Système Tertiaire Translate + View...

    protected function _initTranslate() {
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

    public function _initView() {
        $this->bootstrap('Config');
//initialisation de la view
        $view = new Zend_View;
        $view->doctype('HTML5');
        $view->headTitle('Insset Airlines');
        $view->headTitle()->setSeparator('-');
        $view->headLink()->prependStylesheet(Zend_Registry::get('BaseUrl') . '/ressource/css/reset.css')
                ->appendStylesheet(Zend_Registry::get('BaseUrl') . '/ressource/css/960.css')
                ->appendStylesheet(Zend_Registry::get('BaseUrl') . '/ressource/css/text.css');

//configuration du renderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }

    protected function _initViewSiteBar() {
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

    protected function _initLogin() {
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

    //configuration initial du paginator
    protected function _initPaginator() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    }

// A refaire en beaucoup mieux, la gestion des autoloader marche, mais n'est pas opti
// -_-' regarde la fonction $this->getAppNamespace()->addResourceType($type, $path, $namespace)
    public function _initAutoload() {
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
        return array($autoloaderExp, $autoloaderCom, $autoloaderDRH,
            $autoloaderAdm, $autoloaderAgv, $autoloaderLog, $autoloaderMai,
            $autoloaderPla, $autoloaderStr);
    }

    public function _initUpdate() {
        Application_Model_ApplicationVar::checkEventUpdate();
        return null;
    }

}

