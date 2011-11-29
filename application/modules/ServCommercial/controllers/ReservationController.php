<?php

class ServCommercial_ReservationController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        try {
            $all = ServCommercial_Model_VolHasAgence::getListeReservationHTML(false);
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('ReservationController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le 
                formulaire de contact.<br/>";
    }

    public function adminAction()
    {
        try {
            $all = ServCommercial_Model_VolHasAgence::getListeReservationHTML();
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('ReservationController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le 
                formulaire de contact.<br/>";
    }

    public function newAction()
    {
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
            try {
                $item->addReservation();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('ReservationController : new : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Reservation/admin');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_VolHasAgence();
            $id = $request->getParam('id');
            try {
                $item = $item->getReservation($id[0], $id[1]);
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('ReservationController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
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
            try {
                $item->updReservation();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('ReservationController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Reservation/admin');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_VolHasAgence();
            $id = $request->getParam('id');
            try {
                $Mod->delReservation($id[0], $id[1]);
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('ReservationController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Reservation/admin');
        } else {
            $Mod = new ServCommercial_Model_VolHasAgence();
            $id = $request->getParam('id');
            try {
                $item = $Mod->getReservation($id[0], $id[1]);
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('ReservationController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->view->item = $item->getReservationHTML();
            $this->view->id0 = $id[0];
            $this->view->id1 = $id[1];
        }
    }
    public function detailAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $Mod = new ServCommercial_Model_VolHasAgence;
        try {
            $item = $Mod->getReservation($id[0], $id[1]);
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('ReservationController : detail : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($item != null) {
            $this->view->item = $item->getReservationHTML();
        } else {
            $this->view->item = "Cette reservation n'existe pas dans la base de donnée!<br/>";
        }
        $this->view->id0 = $id[0];
        $this->view->id1 = $id[1];
    }

}