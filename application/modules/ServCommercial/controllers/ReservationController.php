<?php

class ServCommercial_ReservationController extends Zend_Controller_Action
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
        $this->view->all = ServCommercial_Model_VolHasAgence::getListeReservation();
    }

    public function adminAction()
    {
        $this->view->all = ServCommercial_Model_VolHasAgence::getListeReservation();
    }

    public function newAction()
    {
        $form = new ServCommercial_Form_Reservation();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_VolHasAgence();
            $item->set_Vol_noVol($form->getValue('noVol'))
                    ->set_Agence_noAgence($form->getValue('noAgence'))
                    ->set_nbReservation($form->getValue('nbReservation'))
                    ->set_enAttentedeTraitement($form->getValue('enAttentedeTraitement'))
                    ->set_valider($form->getValue('valider'));
            $item->addReservation();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de l'agence réussi.";
            $session->redirection = "/ServCommercial/Reservation/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $form = new ServCommercial_Form_Reservation();
        $item = new ServCommercial_Model_VolHasAgence();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $id = $this->getRequest()->getParam('id');
            $item = $item->getReservation($id[0], $id[1]);

            if ($item != null) {
                $form->getElement('noVol')->setValue($item->get_Vol_noVol())->setAttrib('readonly', 'readonly');
                $form->getElement('noAgence')->setValue($item->get_Agence_noAgence())->setAttrib('readonly', 'readonly');
                $form->getElement('nbReservation')->setValue($item->get_nbReservation());
                $form->getElement('enAttentedeTraitement')->setValue($item->get_enAttentedeTraitement());
                $form->getElement('valider')->setValue($item->get_valider());
            }
            $this->view->form = $form;
        } else {
            $item->set_Vol_noVol($form->getValue('noVol'))
                    ->set_Agence_noAgence($form->getValue('noAgence'))
                    ->set_nbReservation($form->getValue('nbReservation'))
                    ->set_enAttentedeTraitement($form->getValue('enAttentedeTraitement'))
                    ->set_valider($form->getValue('valider'));
            $item->updReservation();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServCommercial/Reservation/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $Mod = new ServCommercial_Model_VolHasAgence();
        $id = $this->getRequest()->getParam('id');
        $item = $Mod->getReservation($id[0], $id[1]);
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServCommercial/Reservation/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $Mod->delReservation($id[0], $id[1]);
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('ReservationController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                $session->message = "Echec de supression.";
                $this->_redirect('/redirection/fail');
            }
        } else {
            $this->view->item = $item;
            $this->view->id0 = $id[0];
            $this->view->id1 = $id[1];
        }
    }

    public function detailAction()
    {
        $Mod = new ServCommercial_Model_VolHasAgence;
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $this->view->item = $Mod->getReservation($id[0], $id[1]);
        $this->view->id0 = $id[0];
        $this->view->id1 = $id[1];
    }

}