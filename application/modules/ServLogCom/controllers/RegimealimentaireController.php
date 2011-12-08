<?php

class ServLogCom_RegimealimentaireController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServLogSidebar.phtml');
        $this->view->render('sidebar/_homeServLogRegimeSidebar.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Log')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirection/fail');
        }
    }

    public function indexAction()
    {
        $this->view->all = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaire();
    }

    public function adminAction()
    {
        $this->view->all = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaire();
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $form = new ServLogCom_Form_RegimeAlimentaire();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_RegimeAlimentaire();
            $item->set_labelRegimeAlimentaire($form->getValue('labelRegimeAlimentaire'));
            $item->addRegimeAlimentaire();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout d'un regime alimentaire réussi.";
            $session->redirection = "/ServLogCom/Regimealimentaire/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $form = new ServLogCom_Form_RegimeAlimentaire();
        $item = new ServLogCom_Model_RegimeAlimentaire();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getRegimeAlimentaire($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('labelRegimeAlimentaire')->setValue($item->get_labelRegimeAlimentaire());
            }
            $this->view->form = $form;
        } else {
            $item->set_noRegimeAlimentaire($this->getRequest()->getParam('id'))
                    ->set_labelRegimeAlimentaire($this->getRequest()->getParam('labelRegimeAlimentaire'));
            $item->addRegimeAlimentaire();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Regimealimentaire/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_RegimeAlimentaire;
        $item = $mod->getRegimeAlimentaire($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServLogCom/Regimealimentaire/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $mod->delRegimeAlimentaire($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('RegimeAlimentaireController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                $session->message = "Echec de supression.";
                $this->_redirect('/redirection/fail');
            }
        } else {
            $this->view->item = $item;
            $this->view->id = $this->getRequest()->getParam('id');
        }
    }

    public function detailAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_RegimeAlimentaire;
        $this->view->item = $mod->getRegimeAlimentaire($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }
}

