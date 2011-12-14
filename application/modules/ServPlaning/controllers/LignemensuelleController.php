<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_LignemensuelleController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction() {
        $this->view->derniereSemaine = $this->verifSemaineFinMois();
        $this->view->nbrJourAvantFinMois = $this->calculNbrJoursAvantFinMois();
        $this->view->listeMen = Application_Model_ApplicationVar::get('LstVolAPlan_M');
    }

    /**
     * Fonction verifiant que la semaine courante n'est pas la fin de mois
     *
     * @access protected
     * @author pewho
     * @return true|false
     */
    protected function verifSemaineFinMois() {
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop->modify("next week");
        if ((int) $date->format('m') == (int) $dateStop->format('m')) {
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
    protected function calculNbrJoursAvantFinMois() {
        $date = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
        $dateStop->modify("last day of this month");
        $soustrac = $dateStop->format('d') - $date->format('d');
        return $soustrac;
    }

    public function addplanificationAction() {
        $noLigne = $this->getRequest()->getParam('noLigne');
        $Ligne = ServStrategique_Model_Ligne::getLigne($noLigne);
        if ($Ligne instanceof ServStrategique_Model_Ligne) {
            if ($Ligne->get_etat() == ServStrategique_Model_Ligne::ETAT_ACTIVE) {
                $Aeroport1 = Application_Model_Aeroport::getStaticAeroport($Ligne->get_noAeroportDeco());
                $Aeroport2 = Application_Model_Aeroport::getStaticAeroport($Ligne->get_noAeroportAtte());
                if ($Aeroport1 instanceof Application_Model_Aeroport && $Aeroport2 instanceof Application_Model_Aeroport) {
                    $this->view->lignelabel = 'Ligne ' . $Ligne->get_noLigne() . ' : (' . $Aeroport1->get_labelAeroport() . ' ' . $Aeroport1->get_labelPays() . ')';
                    $this->view->lignelabel.= '->(' . $Aeroport2->get_labelAeroport() . ' ' . $Aeroport2->get_labelPays() . ')';
                    //var_dump($Ligne);



                    $Start = new DateTime(ServPlaning_Model_Vol::getSemaineAheadFromCurrent(4));
                    $Start->setTime(0, 0, 0);
                    $this->view->Start = $Start;

                    $Start->modify('monday');
                    $End = new DateTime($Start->format(DATE_ATOM));
                    $End->modify('sunday');
                    $End->setTime(24, 0, 0);

                    $Cipher = new DateTime($Start->format(DATE_ATOM));

                    $this->view->End = $End;
                    $this->view->Start = $Start;
                    $form = new ServPlaning_Form_Vol($Start, $End);
                    $this->view->lstM = $form->returnMaintenances();
                    for ($i = 0; $i < 7; $i++) {
                        $s = $Cipher->format(DATE_ATOM);
                        $Cipher->modify('+1days');
                        $e = $Cipher->format(DATE_ATOM);
                        $Vols[] = ServPlaning_Model_Vol::findAllVolsInInterval(new DateTime($s), new  DateTime($e));
                    }
                    if (is_array($Vols) && count($Vols) > 0) {
                        $this->view->lstVols = $Vols;
                    }
                    if (isset($_POST) && !empty($_POST)) {
                        $this->view->message = 'POST';
                        if ($form->isValid($_POST)) {
                            $Avion = ServMaintenance_Model_Avion::findOne($_POST['noAvion']);
                            $DRH = new ServDRH_Model_EmployeMapper();
                            $Personne1 = $DRH->find($_POST['noPersonne1']);
                            $Personne2 = $DRH->find($_POST['noPersonne2']);
                            if ($Avion instanceof ServMaintenance_Model_Avion) {
                                if ($Personne1 instanceof ServDRH_Model_Employe) {
                                    if ($Personne2 instanceof ServDRH_Model_Employe) {
                                        $datedecollage = new DateTime($_POST['datedecollage']);
                                        $dateAtterissage = new DateTime($_POST['dateAtterissage']);
                                        $_POST['datedecollage'] = $datedecollage->format(DATE_ATOM);
                                        $_POST['dateAtterissage'] = $dateAtterissage->format(DATE_ATOM);
                                        $diff = $datedecollage->diff($dateAtterissage, TRUE);
                                        if (
                                                $_POST['datedecollage'] != $_POST['dateAtterissage'] &&
                                                $_POST['datedecollage'] < $_POST['dateAtterissage'] &&
                                                $diff->h >= $Ligne->get_duree()
                                        ) {

                                            $dateAtterissageStr = $dateAtterissage->format(DATE_ATOM);
                                            $datedecollageStr = $datedecollage->format(DATE_ATOM);

                                            if (count(ServMaintenance_Model_TacheMaintenance::findAllByAvionAtDateTimeInterval($datedecollage, $dateAtterissage, $Avion->get_noAvion()) == 0)) {
                                                if (count(ServPlaning_Model_Vol::FindAllVolsByAvionAtDateTimeInterval($datedecollage, $dateAtterissage, $Avion->get_noAvion())) == 0) {
                                                    if (ServPlaning_Model_EnVol::IsLibreAtIntervalByEmploye($datedecollage, $dateAtterissage, $Personne1->get_Personne_noPersonne())) {
                                                        if (ServPlaning_Model_EnVol::IsLibreAtIntervalByEmploye($datedecollage, $dateAtterissage, $Personne2->get_Personne_noPersonne())) {
                                                            $Vol = new ServPlaning_Model_Vol();
                                                            $Vol->set_heuredecollage($datedecollageStr);
                                                            $Vol->set_noAeroportDeco($Ligne->get_noAeroportDeco());
                                                            $Vol->set_heureAtterissage($dateAtterissageStr);
                                                            $Vol->set_noAeroportAtte($Ligne->get_noAeroportAtte());
                                                            $Vol->set_etat(ServPlaning_Model_Vol::ETAT_OK);
                                                            $Vol->set_noAvion($Avion->get_noAvion());
                                                            $Vol->set_noLigne($Ligne->get_noLigne());
                                                            $Vol->set_labelvol($_POST['label']);
                                                            $noVol = $Vol->save();
                                                            if ($noVol != null && FALSE) {
                                                                $EnVol1 = new ServPlaning_Model_EnVol();
                                                                $EnVol2 = new ServPlaning_Model_EnVol();

                                                                $EnVol1->set_heureEnd($dateAtterissageStr);
                                                                $EnVol2->set_heureEnd($dateAtterissageStr);

                                                                $EnVol1->set_heureStart($datedecollageStr);
                                                                $EnVol2->set_heureStart($datedecollageStr);

                                                                $EnVol1->set_noVol($noVol);
                                                                $EnVol2->set_noVol($noVol);

                                                                $EnVol1->set_noEmploye($Personne1->get_Personne_noPersonne());
                                                                $EnVol2->set_noEmploye($Personne2->get_Personne_noPersonne());

                                                                $EnVol1->save();
                                                                $EnVol2->save();
                                                            }
                                                        } else {
                                                            $this->view->message = 'Le Co-Pilote est déjà sur une vol pendant la période donnée!';
                                                            $this->view->form = $form;
                                                        }
                                                    } else {
                                                        $this->view->message = 'Le Pilote est déjà sur une vol pendant la période donnée!';
                                                        $this->view->form = $form;
                                                    }
                                                } else {
                                                    $this->view->message = 'L\'Avion est déjà sur une vol pendant la période donnée!';
                                                    $this->view->form = $form;
                                                }
                                            } else {
                                                $this->view->message = 'L\'Avion est en maintenance pendant la période donnée!';
                                                $this->view->form = $form;
                                            }
                                        } else {
                                            $this->view->message = 'DAte de décollage et d\'atterissage Incohérent!';
                                            $this->view->form = $form;
                                        }
                                    } else {
                                        $this->view->message = 'Le Co-Pilote n\'existe pas!';
                                        $this->view->form = $form;
                                    }
                                } else {
                                    $this->view->message = 'Le pilote n\'existe pas !';
                                    $this->view->form = $form;
                                }
                            } else {
                                $this->view->message = 'L\'appareil n\'existe pas!';
                                $this->view->form = $form;
                            }
                        } else {
                            $this->view->message = 'Données Incohérente';
                            $this->view->form = $form;
                        }
                    } else {
                        $this->view->form = $form;
                    }
                } else {
                    $this->view->message = 'Erreur d\'aéropport sur Ligne';
                    //redirect
                }
            } else {
                $this->view->message = 'Ligne non active';
                //redirect
            }
        } else {
            $this->view->message = 'Erreur de Ligne';
            //redirect
        }
    }

}

?>