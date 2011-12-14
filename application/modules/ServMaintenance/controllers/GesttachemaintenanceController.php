<?php

class ServMaintenance_GesttachemaintenanceController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
        $this->view->render('sidebar/_homeGestTacheMaintenanceSideBar.phtml');
    }

    public function indexAction() {
        $this->view->nbAff = array();
        //Tâche en cours

        $this->view->nbAff['encoursP'] = ServMaintenance_Model_TacheMaintenance::nbMaintenanceEnCoursAujourdhui(ServMaintenance_Model_TacheMaintenance::TACHE_PREVENTIVE);
        $this->view->nbAff['encoursU'] = ServMaintenance_Model_TacheMaintenance::nbMaintenanceEnCoursAujourdhui(ServMaintenance_Model_TacheMaintenance::TACHE_URGENTE);

        $this->view->lstTacheAPlanifier = ServMaintenance_Model_TacheMaintenance::getMaintenanceUrgenteAPlanifier();

        $this->view->lstTacheplanifier = ServMaintenance_Model_TacheMaintenance::findAllPlanifierAtCurrentTime();
    }

    public function aplanifierAction() {
        $form = new ServMaintenance_Form_TacheMaintenance_planifier();
        $noAvion = $this->getRequest()->getParam('noavion');
        $noTypeMaintenance = $this->getRequest()->getParam('notypemaintenance');

        $Avion = ServMaintenance_Model_Avion::findOne($noAvion);
        $TypeMaintenance = ServMaintenance_Model_TypeMaintenance::findOne($noTypeMaintenance);
        if ($Avion instanceof ServMaintenance_Model_Avion && $TypeMaintenance instanceof ServMaintenance_Model_TypeMaintenance && $Avion->get_noModele() == $TypeMaintenance->get_noModele()) {
            $this->view->label = '<span style="color: red;"> Urgente</span>';
            $form->setForUrg($noAvion, $noTypeMaintenance);
            if (isset($_POST) && !empty($_POST)) {
                
            } else {
                $this->view->form = $form;
            }
        } else {
            $this->view->label = '<span style="color: green;"> Préventive</span>';
            //parse_str($_POST['AvionTypeMaintenance'])
            if (isset($_POST) && !empty($_POST)) {
                if ($form->isValid($_POST)) {
                    parse_str($_POST['AvionTypeMaintenance']);
                    if (isset($noAvion) && isset($noTypeMaintenance)) {
                        var_dump($noAvion, $noTypeMaintenance);
                        $Avion = ServMaintenance_Model_Avion::findOne($noAvion);
                        $TypeMaintenance = ServMaintenance_Model_TypeMaintenance::findOne($noTypeMaintenance);
                        if ($Avion instanceof ServMaintenance_Model_Avion && $TypeMaintenance instanceof ServMaintenance_Model_TypeMaintenance && $Avion->get_noModele() == $TypeMaintenance->get_noModele()) {
                            $dateDebut = new DateTime($_POST['dateDebut']);
                            $dateDebut->setTime(0, 0, 0);
                            $dateEnd = new DateTime($dateDebut->format(DATE_ATOM));
                            $dateEnd->modify('+'.$TypeMaintenance->get_dureeMaintenance().' day');
                            if ($dateDebut->format(DATE_ATOM) > date(DATE_ATOM)) {
                                $Maintenance = ServMaintenance_Model_TacheMaintenance::findAllByAvionAtDateTimeInterval($dateDebut, $dateEnd, $noAvion);
                                var_dump($Maintenance);
                                var_dump($dateDebut);
                                var_dump($dateEnd);
                                if ($dateDebut->format(DATE_ATOM) < ServPlaning_Model_Vol::getSemaineAheadFromCurrent(5)) {
                                    //
                                }
                            } else {
                                $this->view->message = 'Merci de mettre une date supérieur à demain!';
                                $this->view->form = $form;
                            }
                        } else {
                            $this->view->message = 'Données Incohérentes!';
                            $this->view->form = $form;
                        }
                    } else {
                        $this->view->message = 'Données Incohérentes!';
                        $this->view->form = $form;
                    }
                } else {
                    $this->view->message = 'Données Incohérentes!';
                    $this->view->form = $form;
                }
            } else {
                $this->view->form = $form;
            }
        }
    }

    public function completerAction() {
        $id = $this->getRequest()->getParam('id');
        $form = new ServMaintenance_Form_TacheMaintenance_completer($id);
        if (isset($_POST) && !empty($_POST)) {
            if ($form->isValid($_POST)) {
                $maintenance = ServMaintenance_Model_TacheMaintenance::findOne($id);
                if ($maintenance instanceof ServMaintenance_Model_TacheMaintenance) {
                    $maintenance->set_rapport(base64_encode($_POST['rapport']));
                    if ($_POST['retard'] > 0) {
                        $this->view->message = 'Le retard n\'est pas encore implémenté';
                        $this->view->form = $form;
                    } else {
                        $maintenance->save();
                        $this->view->message = 'Rapport Transmis';
                        $this->getResponse()->setHeader('refresh', '1,url=/ServMaintenance/Gesttachemaintenance');
                    }
                } else {
                    $this->view->message = 'Id de la Tâche de Maintenance Incorrecte';
                    $this->getResponse()->setHeader('refresh', '1,url=/ServMaintenance/Gesttachemaintenance');
                }
            } else {
                $this->view->message = 'Données Incohérentes';
                $this->view->form = $form;
            }
        } else {
            $this->view->message = '';
            $this->view->form = $form;
        }
    }

    public function creerAction() {
        if (isset($_POSt) && !empty($_POST)) {
            
        } else {
            
        }
    }

    public function cloturerAction() {
        if (isset($_POST) && !empty($_POST)) {
            
        } else {
            
        }
    }

    public function encoursAction() {
        $this->view->lstencours = ServMaintenance_Model_TacheMaintenance::findAllAtCurrentTime();
    }

}