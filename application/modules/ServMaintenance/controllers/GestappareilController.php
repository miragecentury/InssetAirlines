<?php

class ServMaintenance_GestappareilController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {

        $Avions = ServMaintenance_Model_Avion::findAll();



        $this->view->listeAvion = '
            <table>
            <tr>
                <th>Numero:</th>
                <th>Label:</th>
                <th>Date Mise en Service:</th>
                <th>Date Mise Hors Service</th>
                <th></th>
            </tr>
        ';

        foreach ($Avions as $avion) {
            var_dump(ServPlaning_Model_Vol::getVolByAvion($avion->get_noAvion()));
        }
        
        $this->view->listeAvion.='</table>';
    }

    public function newappareilAction() {
        
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

