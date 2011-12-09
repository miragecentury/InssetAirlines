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
        
    }

    public function afflastmaintenanceAction() {
        
    }

    public function newappareilAction() {

        $formAdd = new ServMaintenance_Form_Avion_Ajout();

        if (isset($_POST) && !empty($_POST) && $formAdd->isValid($_POST)) {
            $modele = ServMaintenance_Model_Modele::findOne($_POST['noModele']);
            if ($modele instanceof ServMaintenance_MOdele_Modele) {
                if($_POST['nbMaxPlace'] > $modele->get_nbPlaceMax()){
                    //ok ready to save
                    $avion = ServMaintenance_Model_Avion::getItemFromRaw($_POST);
                    if($avion instanceof ServMaintenance_Model_Avion){
                        //$avion->save();
                    }else{
                        //echec
                    }
                    
                }else{
                    //echec
                }
            } else {
                //echec
            }
        } else {
            $this->view->form = $formAdd;
        }
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

