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
        try {
            $all = Application_Model_Aeroport::getListeAeroportHTML(false);
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AeroportController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le formulaire de contact.<br/>";
    }

    public function adminAction()
    {
        try {
            $all = Application_Model_Aeroport::getListeAeroportHTML();
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AeroportController : admin : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le formulaire de contact.<br/>";
    }

    public function detailAction()
    {
        $Mod = new Application_Model_Aeroport;
        try {
            $item = $Mod->getAeroport($this->getRequest()->getParam('id'));
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AeroportController : detail : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($item != null) {
            $this->view->item = $item->getAeroportHTML();
        } else {
            $this->view->item = "Cet Aéroport n'existe pas dans la base de donnée!<br/>";
        }
        $this->view->id = $this->getRequest()->getParam('id');
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new Application_Model_Aeroport;
            try {
                $Mod->delAeroport($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AeroportController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('/Aeroport/admin');
        } else {
            $Mod = new Application_Model_Aeroport;
            try {
                $item = $Mod->getAeroport($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AeroportController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            if ($item != null) {
                $this->view->item = $item->getAeroportHTML();
            } else {
                $this->view->item = "Cet Aéroport n'existe pas dans la base de donnée!<br/>";
            }
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
            try {
                $item->addAeroport();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AeroportController : new : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('/Aeroport/admin');
        }
    }

    public function updAction()
    {
        $form = new Application_Form_Aeroport_Aeroport();
        $item = new Application_Model_Aeroport;
        if (empty($_POST) || !$form->isValid($_POST)) {
            try {
                $item = $item->getAeroport($this->getRequest()->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AeroportController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
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
            try {
                $item->addAeroport();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AeroportController : new : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('/Aeroport/admin');
        }
    }

}