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
        $this->view->listeLun = Application_Model_ApplicationVar::get('LstVolAPlan_J_Lun');
        $this->view->listeMar = Application_Model_ApplicationVar::get('LstVolAPlan_J_Mar');
        $this->view->listeMer = Application_Model_ApplicationVar::get('LstVolAPlan_J_Mer');
        $this->view->listeJeu = Application_Model_ApplicationVar::get('LstVolAPlan_J_Jeu');
        $this->view->listeVen = Application_Model_ApplicationVar::get('LstVolAPlan_J_Ven');
        $this->view->listeSam = Application_Model_ApplicationVar::get('LstVolAPlan_J_Sam');
        $this->view->listeDim = Application_Model_ApplicationVar::get('LstVolAPlan_J_Dim');

    }
    public function addPlanificationAction(){

    }
}

?>