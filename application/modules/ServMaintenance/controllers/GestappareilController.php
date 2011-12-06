<?php

class ServMaintenance_GestappareilController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
        $this->view->render('sidebar/_homeGestAppareilSideBar.phtml');
    }

    public function indexAction() {
        
    }

    public function affavionallAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAll();
    }

    public function affavionhorsserviceAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAllHorsService();
    }

    public function affavionenserviceAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAllEnService();
    }

    public function misehorsserviceAction() {
        $status = $this->getRequest()->getParam('status');
        if ($status == 1) {
            
        } else if ($status == 2) {
            
        } else if ($status == 3) {
            
        } else {
            $this->view->message = 'Attention la mise Hors Service d\'un Appareil empechera son utilisation définitivement!';
            $this->view->form = new ServMaintenance_Form_Avion_HorsService();
            $this->view->avions = ServMaintenance_Model_Avion::findAllEnService();
        }
    }

    public function misehorsserviceurgAction() {
        
    }

    public function afflastmaintenanceAction() {
        
    }

    public function newappareilAction() {

        $formAdd = new ServMaintenance_Form_Avion_Ajout();

        if (isset($_POST) && !empty($_POST) && $formAdd->isValid($_POST)) {
            var_dump($_POST['noModele']);
            $modele = ServMaintenance_Model_Modele::findOne($_POST['noModele']);
            if ($modele instanceof ServMaintenance_Model_Modele) {

                //ok ready to save
                $avion = new ServMaintenance_Model_Avion();
                if ($avion instanceof ServMaintenance_Model_Avion) {
                    $avion->set_label($_POST['label']);
                    $avion->set_nbPlaceMax($_POST['nbPlaceMax']);
                    $avion->set_nbHeureVol($_POST['nbHeureVol']);
                    $avion->set_dateMiseService($_POST['dateMiseService']);
                    $avion->set_noModele($_POST['noModele']);
                    $avion->set_enService('1');
                    $avion->set_nbIncident(0);
                    $avion->set_dateMiseHorsService(null);
                    try {
                        $avion->save();
                    } catch (Exception $e) {
                        echo $e->getMessage() . $e->getPrevious()->getMessage();
                    }
                    $this->view->message = 'Appareil Ajouté';
                    $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestappareil');
                } else {
                    //echec                  
                    $this->view->form = $formAdd;
                    $this->view->message = 'Echec de la Création de l\'Avion - Raison Inconnu';
                }
            } else {
                //echec
                $this->view->form = $formAdd;
                $this->view->message = 'Modèle incohérent';
            }
        } else {
            $this->view->form = $formAdd;
            $this->view->message = '';
        }
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

