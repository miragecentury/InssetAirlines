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
        $all = Application_Model_Aeroport::getListeAeroportHTML(false);
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le formulaire de contact.<br/>";
    }
    
    public function adminAction()
    {
        $all = Application_Model_Aeroport::getListeAeroportHTML();
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le formulaire de contact.<br/>";
    }

    public function detailAction()
    {
        $Mod = new Application_Model_Aeroport;
        $item = $Mod->getAeroport($this->getRequest()->getParam('id'));
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
            $Mod->delAeroport($request->getParam('id'));
            $this->_redirect('/Aeroport/admin');
        } else {
            $Mod = new Application_Model_Aeroport;
            $item = $Mod->getAeroport($request->getParam('id'));
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
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new Application_Form_Aeroport_Aeroport();
            $this->view->form = $form;
        } else {
            $item = new Application_Model_Aeroport;
            $item->set_labelAeroport($request->getParam('label'))
                    ->set_labelPays($request->getParam('pays'))
                    ->set_labelVille($request->getParam('ville'));
            $item->addAeroport();
            $this->_redirect('/Aeroport/admin');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new Application_Model_Aeroport;
            $item = $item->getAeroport($request->getParam('id'));
            if ($item != null) {
                $form = new Application_Form_Aeroport_Aeroport();
                $form->getElement('label')->setValue($item->get_labelAeroport());
                $form->getElement('pays')->setValue($item->get_labelPays());
                $form->getElement('ville')->setValue($item->get_labelVille());
                $this->view->form = $form;
            }
        } else {
            $item = new Application_Model_Aeroport;
            $item->set_noAeroport($request->getParam('id'))
                    ->set_labelAeroport($request->getParam('label'))
                    ->set_labelPays($request->getParam('pays'))
                    ->set_labelVille($request->getParam('ville'));
            $item->addAeroport();
            $this->_redirect('/Aeroport/admin');
        }
    }

}