<?php

class ServMaintenance_GestappareilController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
    }

    public function indexAction() {
        
    }

    public function affAvionHorsServiceAction() {
        
    }

    public function affAvionEnServiceAction() {
        
    }

    public function miseHorsServiceAction() {
        
    }

    public function newappareilAction() {
        
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

