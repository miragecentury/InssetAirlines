<?php

class ServDRH_GestpiloteController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        $employe = new ServDRH_Model_Employe;
        $personne = new Application_Model_Personne;
        $listePilotes = array();
        
        $listeEmployes = $employe->getEmployes();
        foreach ($listeEmployes as $row) {
            if ($row->get_labelMetier() == "Pilote") {
                $noPersonne = $row->get_Personne_noPersonne();
                $listePilotes[] = $personne->getPersonneById($noPersonne);
            }
        }
        $this->view->AllPilotes = $listePilotes;
    }

    public function newpiloteAction() {
        
    }

    public function updpiloteAction() {
        
    }

    public function delpiloteAction() {
        
    }
}