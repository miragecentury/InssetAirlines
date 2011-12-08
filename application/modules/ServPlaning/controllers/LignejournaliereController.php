<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_LignejournaliereController extends Zend_Controller_Action
{
     public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction(){
        $listeLun = Application_Model_ApplicationVar::get('LstVolAPlan_J_Lun');
    }
}

?>