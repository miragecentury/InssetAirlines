<?php

class ServStrategique_GestvolController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Strat')) {
            $session = Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirect/success');
        }
    }

    public function indexAction() {
        //Chargement de la liste des lignes existantes
        $lignes = ServStrategique_Model_Ligne::getListeLigne();
        $this->view->lignes = $lignes;
    }

    public function newvolAction() {

    }

    public function updvolAction() {

    }

    public function delvolAction() {

    }

}

