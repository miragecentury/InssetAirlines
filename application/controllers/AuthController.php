<?php

/**
 * Application_Controller_AuthController
 * Gère la conection des utilisateurs
 *
 * @author pewho
 */
class AuthController extends Zend_Controller_Action
{

    /**
     * Contient la liste des Acl contenu dans le Registry
     * @var Zend_Acl
     */
    private $_acl;

    /**
     * initialisation de la classe Auth_Controller
     *
     * rendu du menu et du layout principal
     *
     * @author pewho
     * @access public
     * @return void
     */
    public function init()
    {
        $this->view->render('user/_sidebar.phtml');
        //$this->view->render('user/_login.phtml');
        $this->_acl = Zend_Registry::get('Acl');
    }

    /**
     * Action : index
     * renvoi vers Action : login
     */
    public function indexAction()
    {
        $this->loginAction();
    }

    /**
     * Action : Login
     * Methode permetant la connection d'un utilisateur
     *
     * @access public
     * @return void
     * @author pewho
     */
    public function loginAction()
    {
        $auth = Zend_Auth::getInstance();

//Chargement de la form de login
        $loginForm = new Application_Form_Auth_Login($_POST);
        $this->view->loginForm = $loginForm;

//conection à la BDD
        $dbAdapter = Zend_Registry::get('Db');
        if (isset($_POST) && !empty($_POST) && $loginForm->isValid($_POST)) {
            $adapter = new Zend_Auth_Adapter_DbTable(
                            $dbAdapter,
                            'Personne',
                            'email',
                            'password'
            );

//Récupération des données du formulaire
            $adapter->setIdentity($loginForm->getValue('username'));
            $adapter->setCredential($loginForm->getValue('password'));

//Authentification
            $result = $auth->authenticate($adapter);
            if ($result->isValid()) {
                $this->view->codeResult = $result->getCode();
//Recupération du role de l'utilisateur
                try {
                    $select = $dbAdapter->select()
                            ->from(array('Personne'), array('role'))
                            ->where('email = ?', $loginForm->getValue('username'));
                    $stmt = $dbAdapter->query($select);
                    $resultRole = $stmt->fetchAll();
                } catch (Zend_Db_Exception $e) {
                    Zend_Registry::get('Log')->log('Erreur de récuperation du role dans la bdd (Auth)', Zend_Log::ERR);
                }
                $role = $resultRole[0]['role'];
                if (!$this->verificationValidRole($role)) {
                    Zend_Registry::get('Log')->log(
                            "Auth : Entrée BDD utilisateur corrompue : le role n'existe pas ! role : $role", Zend_Log::ERR
                    );
                } else {
//stockage du role en session dans le namespace Zend Auth
                    try {
                        $authSession = new Zend_Session_Namespace('Zend_Auth');
                        $authSession->role = $role;
                    } catch (Zend_Session_Exception $e) {
                        Zend_Registry::get('Log')->log(
                                'Erreur de stockage du role dans la Session (Auth)', Zend_Log::ERR
                        );
                    }

//redirection vers la page concernée (par les acl)
                    $this->redirectionAcl();
                }
            } else {
//Affichage du message d'erreur dans la form
                $this->view->codeResult = $result->getCode();
                $this->view->messageError = $result->getMessages();
            }
        }
    }

    public function redirectionAction(){
        $this->redirectionAcl();
    }

    /**
     * Methode de déconnection
     *
     * @access public
     * @author pewho
     *
     * @return void
     */
    public function deconnectionAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $session = Zend_Session::destroy();
        $this->_redirect('/');
    }

    /**
     * Methode permetant de retourner le chemin vers lequel est redirigé l'utilisateur
     * après son login.
     *
     * @access protected
     * @author pewho
     * @return string chemin de redirection
     */
    protected function redirectionAcl()
    {
//Récupération des éléments
        $auth = new Zend_Session_Namespace('Zend_Auth');
        $roleCourant = $auth->role;

//si la ressource est autorisé pour un role particulier
        if ($this->_acl->isAllowed($roleCourant, 'Mod_Admin')) {
            $this->_redirect('/Admin');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_DRH')) {
            $this->_redirect('/ServDRH');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Com')) {
            $this->_redirect('/ServCommercial');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Log')) {
            $this->_redirect('/ServLogCom');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Exp')) {
            $this->_redirect('/ServExploitation');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Maint')) {
            $this->_redirect('/ServMaintenance');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Plan')) {
            $this->_redirect('/ServPlaning');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Strat')) {
            $this->_redirect('/ServStrategique');
        } elseif ($this->_acl->isAllowed($roleCourant, 'Mod_Serv_Agence')) {
            $this->_redirect('/AgenceVoyage');
        } else {
            //sinon redirection avec message d'erreur sur le front
            $this->_redirect('/');
        }
    }

    /**
     * Permet de verifier si le role existe ien dans la liste des acl
     *
     * @author pewho
     * @access protected
     * @param string $role
     * @return boolean
     */
    protected function verificationValidRole($role)
    {

        $valid = false;

        if ($this->_acl->hasRole($role)) {
            $valid = true;
        }
        return $valid;
    }

}