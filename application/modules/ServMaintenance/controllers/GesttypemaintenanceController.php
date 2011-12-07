<?php

class ServMaintenance_GesttypemaintenanceController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
        $this->view->render('sidebar/_homeGestTypeMaintenanceSideBar.phtml');
    }

    public function indexAction() {
        $modeles = ServMaintenance_Model_Modele::getAll();
        $ListeModeles = array();
        $ListeConstructeur = array();
        $ListeTypesMaintenance = array();

        $ListeConstructeurRaw = ServMaintenance_Model_Constructeur::GetAll();
        foreach ($ListeConstructeurRaw as $Constructeur) {
            if ($Constructeur instanceof ServMaintenance_Model_Constructeur) {
                $ListeConstructeur[$Constructeur->get_noConstructeur()] = $Constructeur;
            }
        }

        foreach ($modeles as $modele) {
            if ($modele instanceof ServMaintenance_Model_Modele) {
                $TypesMaintenances = ServMaintenance_Model_TypeMaintenance::findAllByModele($modele->get_noModele());
                $ListeModeles[$modele->get_noModele()] = $modele;
                $ListeTypesMaintenance[$modele->get_noModele()] = $TypesMaintenances;
            }
        }
        //var_dump($ListeModeles);
        //var_dump($ListeTypesMaintenance);
        //var_dump($ListeConstructeur);
        $this->view->ListeModeles = $ListeModeles;
        $this->view->ListeTypesMaintenance = $ListeTypesMaintenance;
        $this->view->ListeConstructeur = $ListeConstructeur;
    }

    public function newtypemaintenanceAction() {
        
    }

    public function updtypemaintenanceAction() {
        
    }

    public function deltypemaintenanceAction() {
        
    }

}

