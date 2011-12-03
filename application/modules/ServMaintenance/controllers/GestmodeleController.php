<?php

class ServMaintenance_GestmodeleController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        $liste = ServMaintenance_Model_Modele::getAll();

        $this->view->list_html = '<table style="border-style: solid; border-width: 1px;">
            <tr style="border-style: solid; border-width: 1px;">
                <td style="width: 30px;">Id</td>
                <td style="width: 80px;">Modele</td>
                <td style="width: 100px;">Rayon d\'action</td>
                <td style="width: 160px;">Distance Min. Attérissage</td>
                <td style="width: 170px;">Distance Min. de Décollage</td>
                <td style="width: 120px;">Date Lancement</td>
                <td> Constructeur </td>
                <td></td>
                <td></td>
            <tr>
        ';
        foreach ($liste as $value) {
            $constructeur = ServMaintenance_Model_Constructeur::FindOne($value->get_noConstructeur());
            $this->view->list_html.='<tr style="border-style: solid; border-width: 1px;">
                <td>' . $value->get_noModele() . '</td>
                <td>' . $value->get_label() . '</td>
                <td>' . $value->get_rayonAction() . '</td>
                <td>' . $value->get_distMinAtt() . '</td>
                <td>' . $value->get_distMinDec() . '</td>
                <td>' . $value->get_dateLancement() . '</td>
                <td>' . $constructeur->get_label() . '</td>
                <td style="width: 10px;"><a href="' . $this->view->baseUrl() . '/ServMaintenance/Gestmodele/updmodele?id=' . $value->get_noModele() . '">!</a></td>
                <td><a href="' . $this->view->baseUrl() . '/ServMaintenance/Gestmodele/delmodele?id=' . $value->get_noModele() . '">X</a></td>    
            </tr>';
        }
        $this->view->list_html.='</table>';
    }

    public function newmodeleAction() {
        
    }

    public function updmodeleAction() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (preg_match('#^[0-9]{1,10}$#', $_GET['id']) && $_GET['id'] > 0) {
                try {
                    $modele = ServMaintenance_Model_Modele::FindOne($_GET['id']);
                    if (is_a($modele, 'ServMaintenance_Model_Modele') && $modele != NULL) {
                        $form = new ServMaintenance_Form_Modele();
                        $this->view->form = $form;
                        if (isset($_POST) && !empty($_POST) && $form->isValid($_POST)) {
                            $modele = ServMaintenance_Model_Modele::findOne($_GET['id']);
                        } else {
                            $form->updateForm($modele);
                            $this->view->form = $form;
                        }
                    } else {
                        $this->view->message = 'Aucun Controleur avec cette id ' . $_GET['id'];
                        //Redirect
                    }
                } catch (Exception $e) {
                    $this->view->message = 'Id Incohérente - Aucun Constructeur';
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
                    if (is_a($constructeur, 'ServMaintenance_Model_Modele') && $modele != NULL) {
                        $modele->Del();
//Redirect
                    } else {
                        $this->view->message = 'Aucun Controleur avec cette id';
//Redirect
                    }
                } catch (Exception $e) {
                    $this->view->message = 'Id Incohérente - Aucun Constructeur';
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

}

