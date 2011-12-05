<?php

/**
 * Controller de modification de la plannification entre S et S+3
 *
 * @author pewho
 */
class ServPlaning_ModifplaningController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction(){

    }
}

?>
