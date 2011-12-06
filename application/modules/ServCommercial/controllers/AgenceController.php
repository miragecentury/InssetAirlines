<?php

class ServCommercial_AgenceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
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
        $this->view->all = ServCommercial_Model_Agence::getListeAgence();
    }

    public function adminAction()
    {
        $this->view->all = ServCommercial_Model_Agence::getListeAgence();
    }

    public function newAction()
    {
        $form = new ServCommercial_Form_Agence();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Agence();
            $item->set_labelAgence($form->getValue('labelAgence'))
                    ->set_dateLancement($form->getValue('dateLancement'))
                    ->set_accesExtranet($form->getValue('accesExtranet'))
                    ->set_noAdresse($form->getValue('noAdresse'));
            if ($form->getValue('dateCloture') != null)
                $item->set_dateCloture($form->getValue('dateCloture'));
            $item->addAgence();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de l'agence réussi.";
            $session->redirection = "/ServCommercial/Agence/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $form = new ServCommercial_Form_Agence();
        $item = new ServCommercial_Model_Agence();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getAgence($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('labelAgence')->setValue($item->get_labelAgence());
                $form->getElement('dateLancement')->setValue($item->get_dateLancement());
                $form->getElement('dateCloture')->setValue($item->get_dateCloture());
                $form->getElement('accesExtranet')->setValue($item->get_accesExtranet());
                $form->getElement('noAdresse')->setValue($item->get_noAdresse());
            }
            $this->view->form = $form;
        } else {
            $item->set_noAgence($this->getRequest()->getParam('id'))
                    ->set_labelAgence($form->getValue('labelAgence'))
                    ->set_dateLancement($form->getValue('dateLancement'))
                    ->set_accesExtranet($form->getValue('accesExtranet'))
                    ->set_noAdresse($form->getValue('noAdresse'));
            if ($this->getRequest()->getParam('dateCloture') != null)
                $item->set_dateCloture($form->getValue('dateCloture'));
            $item->addAgence();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServCommercial/Agence/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $Mod = new ServCommercial_Model_Agence();
        $item = $Mod->getAgence($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServCommercial/Agence/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $Mod->delAgence($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('AgenceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $Mod = new ServCommercial_Model_Agence;
        $this->view->item = $Mod->getAgence($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }

}