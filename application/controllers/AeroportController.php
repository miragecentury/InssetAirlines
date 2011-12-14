<?php

class AeroportController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->render('user/_frontSidebar.phtml');
        $this->view->render('user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = Application_Model_Aeroport::getListeAeroport();
    }

    public function adminAction()
    {
        $this->view->all = Application_Model_Aeroport::getListeAeroport();
    }

    public function detailAction()
    {
        $Mod = new Application_Model_Aeroport;
        $this->view->item = $Mod->getAeroport($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }

    public function delAction()
    {
        $Mod = new Application_Model_Aeroport;
        $request = $this->getRequest();
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/Aeroport/admin";
        $item = $Mod->getAeroport($request->getParam('id'));
        if ($request->getParam('ok') === "ok") {
            if ($item != null) {
                $Mod->delAeroport($request->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('AeroportController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                $session->message = "Echec de supression.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/fail');
            }
        } else {
            $this->view->item = $item;
            $this->view->id = $request->getParam('id');
        }
    }

    public function newAction()
    {
        $form = new Application_Form_Aeroport_Aeroport();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new Application_Model_Aeroport;
            $item->set_labelAeroport($form->getValue('label'))
                    ->set_labelPays($form->getValue('pays'))
                    ->set_labelVille($form->getValue('ville'));
            $item->addAeroport();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de l'aeroport réussi.";
            $session->redirection = "/Aeroport/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function updAction()
    {
        $form = new Application_Form_Aeroport_Aeroport();
        $item = new Application_Model_Aeroport;
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getAeroport($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('label')->setValue($item->get_labelAeroport());
                $form->getElement('pays')->setValue($item->get_labelPays());
                $form->getElement('ville')->setValue($item->get_labelVille());
            }
            $this->view->form = $form;
        } else {
            $item->set_noAeroport($this->getRequest()->getParam('id'))
                    ->set_labelAeroport($form->getValue('label'))
                    ->set_labelPays($form->getValue('pays'))
                    ->set_labelVille($form->getValue('ville'));
            $item->addAeroport();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/Aeroport/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

}