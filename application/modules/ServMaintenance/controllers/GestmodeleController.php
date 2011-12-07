<?php

class ServMaintenance_GestmodeleController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeMaintenanceSideBar.phtml');
        $this->view->render('sidebar/_homeGestModeleSideBar.phtml');
    }

    public function indexAction() {

        $liste = ServMaintenance_Model_Modele::getAll();

        $this->view->listeModele = $liste;
    }

    public function newmodeleAction() {
        $constructeurs = ServMaintenance_Model_Constructeur::GetAll();
        if (count($constructeurs) > 0) {
            $form = new ServMaintenance_Form_Modele();
            if (isset($_POST) && !empty($_POST)) {
                if ($form->isValid($_POST)) {
                    if (ServMaintenance_Model_Constructeur::findOne($_POST['noConstructeur']) instanceof ServMaintenance_Model_Constructeur) {

                        $modele = ServMaintenance_Model_Modele::GetItemFromRaw($_POST);
                        if ($modele instanceof ServMaintenance_Model_Modele) {
                            $modele->save();

                            $this->view->message = 'Modèle Ajouté';
                            $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
                        } else {
                            $this->view->message = 'Données Invalides X';
                            $this->view->form = $form;
                        }
                    } else {
                        $this->view->message = 'Constructeur Invalide';
                        $this->view->form = $form;
                    }
                } else {
                    $this->view->message = 'Données Invalides';
                    $this->view->form = $form;
                }
            } else {
                $this->view->form = $form;
            }
        } else {
            $this->view->message = 'Ajouter un Constructeur avant un modèle Merci !';
            $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
        }
    }

    public function updmodeleAction() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (preg_match('#^[0-9]{1,10}$#', $_GET['id']) && $_GET['id'] > 0) {
                try {
                    $modele = ServMaintenance_Model_Modele::FindOne($_GET['id']);
                    if (is_a($modele, 'ServMaintenance_Model_Modele') && $modele != NULL) {
                        $form = new ServMaintenance_Form_Modele();

                        if (isset($_POST) && !empty($_POST) && $form->isValid($_POST)) {

                            $cons = ServMaintenance_Model_Constructeur::FindOne($_POST['noConstructeur']);
                            if ($cons instanceof ServMaintenance_Model_Constructeur) {
                                $modele = ServMaintenance_Model_Modele::findOne($_GET['id']);
                                $modele->set_label($_POST['label']);
                                $modele->set_rayonAction($_POST['rayonAction']);
                                $modele->set_distMinAtt($_POST['distMinAtt']);
                                $modele->set_distMinDec($_POST['distMinDec']);
                                $modele->set_dateLancement($_POST['dateLancement']);

                                $modele->set_noConstructeur($_POST['noConstructeur']);

                                try {
                                    $modele->save();
                                } catch (Exception $e) {
                                    $this->view->message = 'Erreur de Modification';
                                    $modele = ServMaintenance_Model_Modele::findOne($_GET['id']);
                                    $form->updateForm($modele);
                                    $this->view->form = $form;
                                }

                                $this->view->message = 'Modification effectué';
                                $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
                            } else {
                                $this->view->message = 'Constructeur Incohérent';
                                $form->updateForm($modele);
                                $this->view->form = $form;
                            }
                        } else {
                            $form->updateForm($modele);
                            $this->view->form = $form;
                        }
                    } else {
                        $this->view->message = 'Aucun Controleur avec cette id ' . $_GET['id'];
                        //Redirect
                    }
                } catch (Exception $e) {
                    $this->view->message = 'Id Incohérente - Aucun Constructeur' . $e->getMessage();
                    //Redirect
                }
            } else {
                $this->view->message = 'Erreur de Paramètre - Redirection';
                //Redirect
            }
        } else {
            $this->view->message = 'Erreur de Parcours - Redirection';
            //Redirect
        }
    }

    public function delmodeleAction() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (preg_match('#^[0-9]{1,10}$#', $_GET['id']) && $_GET['id'] > 0) {
                $this->view->message = 'Modele trouvé';
                try {
                    $modele = ServMaintenance_Model_Modele::FindOne($_GET['id']);
                    if (is_a($modele, 'ServMaintenance_Model_Modele') && $modele != NULL) {
                        $modele->Del();
                        $this->view->message = 'Modèle Supprimer';
                        $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
                    } else {
                        $this->view->message = 'Aucun Controleur avec cette id';
                        $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
                    }
                } catch (Exception $e) {
                    $this->view->message = 'Id Incohérente - Aucun Constructeur';
                    $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
                }
            } else {
                $this->view->message = 'Erreur de Paramètre - Redirection';
                $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
            }
        } else {
            $this->view->message = 'Erreur de Parcours - Redirection';
            $this->getResponse()->setHeader('refresh', '2,url=/ServMaintenance/Gestmodele');
        }
    }

}

