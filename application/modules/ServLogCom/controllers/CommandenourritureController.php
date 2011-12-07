<?php

class ServLogCom_CommandenourritureController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
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
        $this->view->all = ServLogCom_Model_CommandeNourriture::getListeCommandeNourriture();
    }

    public function newAction()
    {
        $form = new ServLogCom_Form_CommandeNourriture();
        if (empty($_POST) || !$form->isValid($_POST)) {
           $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_CommandeNourriture();
            $item->set_dateLivraison($this->getRequest()->getParam('dateLivraison'))
                    ->set_dateCommande($this->getRequest()->getParam('dateCommande'))
                    ->set_idAeroportLivraison($this->getRequest()->getParam('idAeroportLivraison'));
            $item->addCommandeNourriture();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de la commande réussi.";
            $session->redirection = "/ServLogCom/Commandenourriture/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $form = new ServLogCom_Form_CommandeNourriture();
        $item = new ServLogCom_Model_CommandeNourriture();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getCommandeNourriture($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('dateLivraison')->setValue($item->get_dateLivraison());
                $form->getElement('dateCommande')->setValue($item->get_dateCommande());
                $form->getElement('idAeroportLivraison')->setValue($item->get_idAeroportLivraison());
            }
            $this->view->form = $form;
        } else {
            $item->set_noCommandeNourriture($this->getRequest()->getParam('id'))
                    ->set_dateLivraison($this->getRequest()->getParam('dateLivraison'))
                    ->set_dateCommande($this->getRequest()->getParam('dateCommande'))
                    ->set_idAeroportLivraison($this->getRequest()->getParam('idAeroportLivraison'));
            $item->addCommandeNourriture();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Commandenourriture/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $mod = new ServLogCom_Model_CommandeNourriture;
        $item = $mod->getCommandeNourriture($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServLogCom/Commandenourriture/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if($item != null) {
                $mod->delCommandeNourriture($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('CommandenourritureController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $mod = new ServLogCom_Model_CommandeNourriture;
        $this->view->item = $mod->getCommandeNourriture($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }

    public function adminAction()
    {
        $this->view->all = ServLogCom_Model_CommandeNourriture::getListeCommandeNourriture();
    }
}

