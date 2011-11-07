<?php

class ServCommercial_GestreservationController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        
    }

    public function newreservationAction() {
        
    }

    public function updreservationAction() {
        
    }

    public function delreservationAction() {
        
    }

    public function validreservationAction() {
        
    }
}