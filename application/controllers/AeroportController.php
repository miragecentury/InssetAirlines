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
        $this->view->all = Application_Model_Aeroport::getListeAeroportHTML();
    }

    public function detailAction()
    {
        $Mod = new Application_Model_Aeroport;
        $item = $Mod->getAeroport($this->getRequest()->getParam('id'));
        $this->view->item = $item->getAeroportHTML();
        $this->view->id = $this->getRequest()->getParam('id');
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new Application_Model_Aeroport;
            $Mod->delAeroport($request->getParam('id'));
            $this->_redirect('/Aeroport/');
        } else {
            $Mod = new Application_Model_Aeroport;
            $item = $Mod->getAeroport($request->getParam('id'));
            $this->view->item = $item->getAeroportHTML();
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
            $this->_redirect('/Aeroport/');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new Application_Model_Aeroport;
            $item = $item->getAeroport($request->getParam('id'));
            $form = new Application_Form_Aeroport_Aeroport();
            $form->getElement('label')->setValue($item->get_labelAeroport());
            $form->getElement('pays')->setValue($item->get_labelPays());
            $form->getElement('ville')->setValue($item->get_labelVille());
            $this->view->form = $form;
        } else {
            $item = new Application_Model_Aeroport;
            $item->set_noAeroport($request->getParam('id'))
                    ->set_labelAeroport($request->getParam('label'))
                    ->set_labelPays($request->getParam('pays'))
                    ->set_labelVille($request->getParam('ville'));
            $item->addAeroport();
            $this->_redirect('/Aeroport');
        }
    }

}