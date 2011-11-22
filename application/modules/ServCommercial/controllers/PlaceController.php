<?php

class ServCommercial_PlaceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServCommercial_Model_Place::getListePlaceHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServCommercial_Form_Place();
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Place();
            $item->set_noVol($request->getParam('noVol'))
                    ->set_noAgence($request->getParam('noAgence'))
                    ->set_Personne_noPersonne($request->getParam('noPersonne'));
            $item->addPlace();
            $this->_redirect('ServCommercial/Place');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_Place();
            $item = $item->getPlace($request->getParam('id'));
            $form = new ServCommercial_Form_Place();
            $form->getElement('noVol')->setValue($item->get_noVol());
            $form->getElement('noAgence')->setValue($item->get_noAgence());
            $form->getElement('noPersonne')->setValue($item->get_Personne_noPersonne());
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Place();
            $item->set_noPlace($request->getParam('id'))
                    ->set_noVol($request->getParam('noVol'))
                    ->set_noAgence($request->getParam('noAgence'))
                    ->set_Personne_noPersonne($request->getParam('noPersonne'));
            $item->addPlace();
            $this->_redirect('ServCommercial/Place');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_Place();
            $Mod->delPlace($request->getParam('id'));
            $this->_redirect('ServCommercial/Place');
        } else {
            $Mod = new ServCommercial_Model_Place();
            $item = $Mod->getPlace($request->getParam('id'));
            $this->view->item = $item->getPlaceHTML();
            $this->view->id = $request->getParam('id');
        }
    }

}