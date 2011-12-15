<?php

class AgenceVoyage_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeAgenceVoyageSidebar.phtml');
    }

    public function indexAction()
    {
        //Recupération du nom du connecté actuel
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        $this->_email = $authSession->storage;
        $pers = Application_Model_Personne::getPersonneByMail($this->_email);
        $this->view->pers = $pers;

        $agence = new ServCommercial_Model_Agence;
        $agence = $agence->getAgencebylabel($pers->get_nom());
        if ($agence != null) {
            $reservation = new ServCommercial_Model_VolHasAgence;
            $reservation = $reservation->getReservationbyAgence($agence[0]->get_noAgence());
            $this->view->reservation = $reservation;
        }
    }

    public function newAction()
    {
        //Recupération du nom du connecté actuel
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        $this->_email = $authSession->storage;
        $pers = Application_Model_Personne::getPersonneByMail($this->_email);
        $this->view->pers = $pers;
        $agence = new ServCommercial_Model_Agence;
        $agence = $agence->getAgencebylabel($pers->get_nom());
        if ($agence != null) {
            $form = new AgenceVoyage_Form_Reservation();

            if (empty($_POST) || !$form->isValid($_POST)) {
                $this->view->form = $form;
                $today = new DateTime(date(DATE_ATOM));
                $infourweeks = new DateTime(date(DATE_ATOM));
                $infourweeks = $infourweeks->modify('+4 week');
                $this->view->vol = ServPlaning_Model_Vol::findAllVolsInIntervalByEtat($today,$infourweeks,0);
            } else {
                $item = new ServCommercial_Model_VolHasAgence();
                $item->set_Vol_noVol($form->getValue('noVol'))
                        ->set_Agence_noAgence($agence[0]->get_noAgence())
                        ->set_nbReservation($form->getValue('nbReservation'))
                        ->set_enAttentedeTraitement(0)
                        ->set_valider(0)
                        ->set_heurePost(date('Y-m-d H:i:s'));
                $item->addReservation();
                $session = new Zend_Session_Namespace('Redirect');
                $session->message = "Ajout de la réservation réussi.";
                $session->redirection = "/AgenceVoyage";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
            }
        }
    }

}

