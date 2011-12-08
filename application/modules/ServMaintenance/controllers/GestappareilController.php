<?php

class ServMaintenance_GestappareilController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
        $this->view->render('sidebar/_homeGestAppareilSideBar.phtml');
    }

    public function indexAction() {

        
    }

    public function affavionallAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAll();
    }

    public function affavionhorsserviceAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAllHorsService();
    }

    public function affavionenserviceAction() {
        $this->view->Avions = ServMaintenance_Model_Avion::findAllEnServiceAtCurrentTime();
    }

    public function misehorsserviceAction() {
        $status = $this->getRequest()->getParam('status');
        if ($status == 1) {
            $id = $this->getRequest()->getParam('id');
            $id = intval($id);
            if ($id >= 0) {
                $avion = ServMaintenance_Model_Avion::findOne($id);
                if ($avion instanceof ServMaintenance_Model_Avion) {
                    $this->view->message = 'Confirmer la Mise Hors Service de cet Appareil !!';
                    $this->view->avion = $avion;
                    $this->view->form = new ServMaintenance_Form_Avion_HorsService($id);
                } else {
                    $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestappareil/Misehorsservice');
                }
            } else {
                $this->getResponse()->setHeader('refresh', '0,url=/ServMaintenance/Gestappareil/Misehorsservice');
            }
        } else if ($status == 2 && isset($_POST) && !empty($_POST)) {
            $id = $this->getRequest()->getParam('id');
            $id = intval($id);
            $form = new ServMaintenance_Form_Avion_HorsService($id);
            if ($id >= 0) {
                $avion = ServMaintenance_Model_Avion::findOne($id);
                if ($form->isValid($_POST)) {
                    $id = $this->getRequest()->getParam('id');
                    $id = intval($id);
                    /** TODO:
                     *      Controle de la date
                     */
                    try {
                        $avion->set_dateMiseHorsService(date(DATE_ATOM));
                        $avion->set_enService(0);
                        $avion->save();
                    } catch (Exception $e) {
                        $this->getResponse()->setHeader('refresh', '0,url=/ServMaintenance/Gestappareil/Misehorsservice');
                    }
                    $this->message = 'Appareil' . $avion->get_label() . ' mis Hors Service';
                } else {
                    $this->view->message = 'Confirmer la Mise Hors Service de cet Appareil !!';
                    $this->view->avion = $avion;
                    $this->view->form = new ServMaintenance_Form_Avion_HorsService($id);
                }
            } else {
                $this->getResponse()->setHeader('refresh', '0,url=/ServMaintenance/Gestappareil/Misehorsservice');
            }
        } else {
            $this->view->message = 'Attention la mise Hors Service d\'un Appareil empechera son utilisation définitivement!';
            //$this->view->form = new ServMaintenance_Form_Avion_HorsService();
            $this->view->avions = ServMaintenance_Model_Avion::findAllEnService();
        }
    }

    public function misehorsserviceurgAction() {
        
    }

    public function afflastmaintenanceAction() {
        
    }

    public function newappareilAction() {

        $formAdd = new ServMaintenance_Form_Avion_Ajout();
        $modeles = ServMaintenance_Model_Modele::getAll();
        if (count($modeles) > 0) {
            if (isset($_POST) && !empty($_POST)) {
                if ($formAdd->isValid($_POST)) {
                    $modele = ServMaintenance_Model_Modele::findOne($_POST['noModele']);
                    if ($modele instanceof ServMaintenance_Model_Modele) {

//ok ready to save
                        $avion = new ServMaintenance_Model_Avion();
                        if ($avion instanceof ServMaintenance_Model_Avion) {
                            $avion->set_label($_POST['label']);
                            $avion->set_nbPlaceMax($_POST['nbPlaceMax']);
                            $avion->set_nbHeureVol($_POST['nbHeureVol']);
                            $avion->set_dateMiseService($_POST['dateMiseService']);
                            $avion->set_noModele($_POST['noModele']);
                            $avion->set_enService(ServMaintenance_Model_Avion::ETAT_ENSERVICE);
                            $avion->set_nbIncident(0);
                            $avion->set_dateMiseHorsService(null);
                            try {
                                $avion->save();
                            } catch (Exception $e) {
                                echo $e->getMessage() . $e->getPrevious()->getMessage();
                            }
                            $this->view->message = 'Appareil Ajouté';
                            $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestappareil');
                        } else {
//echec                  
                            $this->view->form = $formAdd;
                            $this->view->message = 'Echec de la Création de l\'Avion - Raison Inconnu';
                        }
                    } else {
//echec
                        $this->view->form = $formAdd;
                        $this->view->message = 'Modèle incohérent';
                    }
                } else {
                    $this->view->form = $formAdd;
                    $this->view->message = 'Données Incohérentes ! Merci de bien compléter les champs !';
                }
            } else {
                $this->view->form = $formAdd;
                $this->view->message = '';
            }
        } else {
            
        }
    }

    public function updappareilAction() {
        
    }

    public function delappareilAction() {
        
    }

}

