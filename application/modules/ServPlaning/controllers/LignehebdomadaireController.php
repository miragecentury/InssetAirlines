<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_LignehebdomadaireController extends Zend_Controller_Action
{
     public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction(){
        $this->view->listeHeb = Application_Model_ApplicationVar::get('LstVolAPlan_S');
    }
    public function addPlanificationAction(){
        
    }
}

?>