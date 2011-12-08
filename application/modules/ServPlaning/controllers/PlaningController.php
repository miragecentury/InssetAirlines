<?php

class ServPlaning_PlaningController extends Zend_Controller_Action
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
        $this->view->nbPlanJourAFaire = ServStrategique_Model_Ligne::getNbPlanJourRestante();
        $this->view->nbPlanHebAFaire = ServStrategique_Model_Ligne::getNbPlanHebRestante();
        $this->view->nbPlanMoisAFaire = ServStrategique_Model_Ligne::getNbPlanMenRestante();
        $this->view->nbPlanAnnAFaire = ServStrategique_Model_Ligne::getNbPlanAnnRestante();

    }
}

