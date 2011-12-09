<?php

class ServPlaning_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction()
    {
        $liste = Application_Model_Personne::getListePersonne();
        $page = Zend_Paginator::factory($liste);
        $page->setPageRange(3);
        $page->setCurrentPageNumber($this->_getParam('page', 1));
        $page->setItemCountPerPage($this->_getParam('par', 5));
        $this->view->listeMembres = $page;
    }


}

