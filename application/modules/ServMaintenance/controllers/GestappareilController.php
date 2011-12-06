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
        
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

