<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_LignemensuelleController extends Zend_Controller_Action
{
     public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction(){
        $this->view->derniereSemaine = $this->verifSemaineFinMois();
        $this->view->nbrJourAvantFinMois = $this->calculNbrJoursAvantFinMois();
        $this->view->listeMen = Application_Model_ApplicationVar::get('LstVolAPlan_M');
    }
    public function addPlanificationAction(){

    }
    /**
     * Fonction verifiant que la semaine courante n'est pas la fin de mois
     *
     * @access protected
     * @author pewho
     * @return true|false
     */
    protected function verifSemaineFinMois(){
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop->modify("next week");
        if ((int)$date->format('m') == (int)$dateStop->format('m')){
            return false;
        }
        else{
            return true;
        }

    }
    /**
     * Fonction calculant le nombre de jour avant la fin du mois
     *
     * @access protected
     * @author pewho
     * @return int
     */
    protected function calculNbrJoursAvantFinMois(){
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop->modify("last day of this month");
        $soustrac = $dateStop->format('d') - $date->format('d');
        return $soustrac;
    }
}
?>