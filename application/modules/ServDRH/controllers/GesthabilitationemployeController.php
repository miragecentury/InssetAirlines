<?php

class ServDRH_GesthabillitationemployeController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        
    }

    public function addhabillitationAction() {
        
    }

    public function delhabillitationAction() {
        
    }

}