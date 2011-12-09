<?php

class ServMaintenance_GesttypemaintenanceController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
    }

    public function indexAction() {
        
    }

    public function newtypemaintenanceAction() {
        
    }

    public function updtypemaintenanceAction() {
        
    }

    public function deltypemaintenanceAction() {
        
    }

}


