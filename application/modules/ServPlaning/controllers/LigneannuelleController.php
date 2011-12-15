<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_LigneannuelleController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction() {
        $this->view->derniereSemaine = $this->verifSemaineFinAnnee();
        $this->view->nbrJourAvantFinAnnee = $this->calculNbrJoursAvantFinAnnee();
        $this->view->listeAnn = Application_Model_ApplicationVar::get('LstVolAPlan_A');
    }

    public function addplanificationAction() {
        
    }

    /**
     * Fonction verifiant que la semaine courante n'est pas la fin de mois
     *
     * @access protected
     * @author pewho
     * @return true|false
     */
    protected function verifSemaineFinAnnee() {
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop->modify("next week");
        if ((int) $date->format('y') == (int) $dateStop->format('y')) {
            return false;
        } else {
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
    protected function calculNbrJoursAvantFinAnnee() {
        /*
          $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
          $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
          $dateStop->setDate( $dateStop->format('Y'), 12, 31 );
          //on les formates
          $dateStop = $dateStop->format('d/m/Y');
          $date = $date->format('d/m/Y');
          //on les explode
          $dateStop = explode('/',$dateStop);
          $date = explode('/', $date);
          //on recupere le timestamp de chacun
          $dateStop = mktime(0,0,0,$dateStop[1],$dateStop[0],$dateStop[2]);
          $date = mktime(0,0,0,$date[1],$date[0],$date[2]);
          //calcule
          $result = $dateStop - $date;
          $soustrac = ($result/86400)-1;
          return $soustrac;
         */
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateEndAnnee = new DateTime();
        $dateEndAnnee->setDate($date->format('Y'), 12, 31);
        $dateEndAnnee->setTime(0, 0, 0);
        $diff = $date->diff($dateEndAnnee, TRUE);
        return $diff->days;
    }

}

?>