<?php

class ServDRH_GestpiloteController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        
    }

    public function newpiloteAction() {
        
    }

    public function updpiloteAction() {
        
    }

    public function delpiloteAction() {
        
    }
}