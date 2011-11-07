<?php

class ServMaintenance_GestconstructeurController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        
    }

    public function newconstructeurAction() {
        
    }

    public function updconstructeurAction() {
        
    }

    public function delconstructeurAction() {
        
    }

}

