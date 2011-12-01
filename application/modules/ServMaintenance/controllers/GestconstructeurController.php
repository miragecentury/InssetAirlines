<?php

class ServMaintenance_GestconstructeurController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        $liste_constructeur = ServMaintenance_Model_Constructeur::GetAll();

        //var_dump($liste_constructeur);

        $this->view->html_liste = '<table style="border-style: solid; border-width: 1px;">
            <tr style="border-style: solid; border-width: 1px;">
                <td style="width: 30px;">Id</td><td style="width: 150px;">Nom Constructeur</td><td>LinkToAdresse</td><td></td>
            </tr>';
        
        foreach ($liste_constructeur as $value) {
            //var_dump($value);echo '<br/>';
            $this->view->html_liste.='
                <tr style="border-style: solid; border-width: 1px;">
                    <td>' . $value->get_noConstructeur() . '</td><td>' . $value->get_label() . '</td><td>' . $value->get_noAdresse() . '</td><td><a href="' . $this->view->baseUrl() . '/ServMaintenance/Gestconstructeur/delconstructeur?id=' . $value->get_noConstructeur() . '">X</a> </td>
                </tr>';
        }

        $this->view->html_liste.= '</table>';
    }

    public function newconstructeurAction() {
        $newForm = new ServMaintenance_Form_Constructeur();
        if (!empty($_POST) && $newForm->isValid($_POST)) {
            $this->view->message = 'Ajout réussi';
            $constructeur = new ServMaintenance_Model_Constructeur();
            $constructeur->set_label($_POST['label'])->set_noAdresse($_POST['adresse']);
            try {
                $constructeur->Save();
            } catch (Exception $e) {
                $this->view->message = 'Echec de l\'ajout du constructeur';
            }
        } else {
            $this->view->newForm = $newForm;
        }
    }

    public function delconstructeurAction() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            if (preg_match('#^[0-9]{1,10}$#', $_GET['id']) && $_GET['id'] > 0) {
                $this->view->message = 'Constructeur trouvé';
                try {
                    $constructeur = ServMaintenance_Model_Constructeur::FindOne($_GET['id']);
                    if (is_a($constructeur, 'ServMaintenance_Model_Constructeur') && $constructeur != NULL) {
                        $constructeur->Del();
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

