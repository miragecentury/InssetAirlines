<?php

class ServCommercial_ReservationController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServComSidebar.phtml');
        $this->view->render('sidebar/_homeServComReservationSidebar.phtml');
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
        $this->view->render('sidebar/_homeServComReservationAdminSidebar.phtml');
        $this->view->all = ServCommercial_Model_VolHasAgence::getListeReservation();
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServComReservationAdminSidebar.phtml');
        $form = new ServCommercial_Form_Reservation();
        $formS = new ServPlaning_Form_SearchVol();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
            $this->view->formS = $formS;
            $noAeroD = $this->getRequest()->getParam('noAeroD');
            $noAeroA = $this->getRequest()->getParam('noAeroA');
            if(isset($noAeroD)&&
               isset($noAeroA)) {
                // A modifier en fonction des Aeroport;
                echo "$noAeroD=>$noAeroA";
                $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
            } else {
                $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
            }
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
        $this->view->render('sidebar/_homeServComReservationAdminSidebar.phtml');
        $form = new ServCommercial_Form_Reservation();
        $formS = new ServPlaning_Form_SearchVol();
        $item = new ServCommercial_Model_VolHasAgence();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getReservation($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('noVol')->setValue($item->get_Vol_noVol());
                $form->getElement('noAgence')->setValue($item->get_Agence_noAgence());
                $form->getElement('nbReservation')->setValue($item->get_nbReservation());
                $form->getElement('enAttentedeTraitement')->setValue($item->get_enAttentedeTraitement());
                $form->getElement('valider')->setValue($item->get_valider());
            }
            $this->view->form = $form;
            $this->view->formS = $formS;
            $noAeroD = $this->getRequest()->getParam('noAeroD');
            $noAeroA = $this->getRequest()->getParam('noAeroA');
            if(isset($noAeroD)&&
               isset($noAeroA)) {
                // A modifier en fonction des Aeroport;
                echo "$noAeroD=>$noAeroA";
                $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
            } else {
                $this->view->vol = ServPlaning_Model_Vol::getVolsDuJour();
            }
        } else {
            $item->set_idVolHasAgence($this->getRequest()->getParam('id'))
                    ->set_Vol_noVol($form->getValue('noVol'))
                    ->set_Agence_noAgence($form->getValue('noAgence'))
                    ->set_nbReservation($form->getValue('nbReservation'))
                    ->set_enAttentedeTraitement($form->getValue('enAttentedeTraitement'))
                    ->set_valider($form->getValue('valider'));
            $item->addReservation();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServCommercial/Reservation/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServComReservationAdminSidebar.phtml');
        $Mod = new ServCommercial_Model_VolHasAgence();
        $item = $Mod->getReservation($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServCommercial/Reservation/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $item->delReservation($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('ReservationController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $this->view->render('sidebar/_homeServComReservationAdminSidebar.phtml');
        $Mod = new ServCommercial_Model_VolHasAgence;
        $this->view->item = $Mod->getReservation($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');
    }

}