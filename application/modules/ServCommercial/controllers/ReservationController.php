<?php

class ServCommercial_ReservationController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        $this->view->all = ServCommercial_Model_VolHasAgence::getListeReservationHTML();
    }

    public function newAction() {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServCommercial_Form_Reservation();
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_VolHasAgence();
            $item->set_Vol_noVol($request->getParam('noVol'))
                    ->set_Agence_noAgence($request->getParam('noAgence'))
                    ->set_nbReservation($request->getParam('nbReservation'))
                    ->set_enAttentedeTraitement($request->getParam('enAttentedeTraitement'))
                    ->set_valider($request->getParam('valider'));
            $item->addReservation();
            $this->_redirect('ServCommercial/Reservation');
        }
    }

    public function updAction() {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_VolHasAgence();
            $id=$request->getParam('id');
            $item = $item->getReservation($id[0], $id[1]);
            $form = new ServCommercial_Form_Reservation();
            $form->getElement('noVol')->setValue($item->get_Vol_noVol())->setAttrib('readonly', 'readonly');
            $form->getElement('noAgence')->setValue($item->get_Agence_noAgence())->setAttrib('readonly', 'readonly');
            $form->getElement('nbReservation')->setValue($item->get_nbReservation());
            $form->getElement('enAttentedeTraitement')->setValue($item->get_enAttentedeTraitement());
            $form->getElement('valider')->setValue($item->get_valider());
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_VolHasAgence();
            $item->set_Vol_noVol($request->getParam('noVol'))
                    ->set_Agence_noAgence($request->getParam('noAgence'))
                    ->set_nbReservation($request->getParam('nbReservation'))
                    ->set_enAttentedeTraitement($request->getParam('enAttentedeTraitement'))
                    ->set_valider($request->getParam('valider'));
            $item->updReservation();
            $this->_redirect('ServCommercial/Reservation');
        }
    }

    public function delAction() {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_VolHasAgence();
            $id = $request->getParam('id');
            $Mod->delReservation($id[0], $id[1]);
            $this->_redirect('ServCommercial/Reservation');
        } else {
            $Mod = new ServCommercial_Model_VolHasAgence();
            $id = $request->getParam('id');
            $item = $Mod->getReservation($id[0], $id[1]);
            $this->view->item = $item->getReservationHTML();
            $this->view->id0 = $id[0];
            $this->view->id1 = $id[1];
        }
    }

    public function validAction() {
        
    }
}