<?php

class ServCommercial_PlaceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServComSidebar.phtml');
        $this->view->render('sidebar/_homeServComPlaceSidebar.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Com')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirection/fail');
        }
    }

    public function indexAction()
    {
        $this->view->all = ServCommercial_Model_Place::getListePlace();
    }

    public function adminAction()
    {
        $this->view->render('sidebar/_homeServComPlaceAdminSidebar.phtml');
        $this->view->all = ServCommercial_Model_Place::getListePlace();
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServComPlaceAdminSidebar.phtml');
        $form = new ServCommercial_Form_Place();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
            $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
        } else {
            $item = new ServCommercial_Model_Place();
            $item->set_noVol($form->getValue('noVol'))
                    ->set_noAgence($form->getValue('noAgence'))
                    ->set_Personne_noPersonne($form->getValue('noPersonne'));
            $item->addPlace();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de la place réussi.";
            $session->redirection = "/ServCommercial/Place/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $this->view->render('sidebar/_homeServComPlaceAdminSidebar.phtml');
        $form = new ServCommercial_Form_Place();
        $item = new ServCommercial_Model_Place();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getPlace($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('noVol')->setValue($item->get_noVol());
                $form->getElement('noAgence')->setValue($item->get_noAgence());
                $form->getElement('noPersonne')->setValue($item->get_Personne_noPersonne());
            }
            $this->view->form = $form;
            $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
        } else {
            $item->set_noPlace($this->getRequest()->getParam('id'))
                    ->set_noVol($form->getValue('noVol'))
                    ->set_noAgence($form->getValue('noAgence'))
                    ->set_Personne_noPersonne($form->getValue('noPersonne'));
            $item->addPlace();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServCommercial/Place/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServComPlaceAdminSidebar.phtml');
        $Mod = new ServCommercial_Model_Place();
        $item = $Mod->getPlace($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServCommercial/Place/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $Mod->delPlace($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('PlaceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $this->view->render('sidebar/_homeServComPlaceAdminSidebar.phtml');
        $Mod = new ServCommercial_Model_Place();
        $this->view->item = $Mod->getPlace($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }

}