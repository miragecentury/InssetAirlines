<?php

class ServStrategique_GestvolController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServStratSidebar.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Strat')) {
            $session = Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirect/success');
        }
    }

    public function indexAction()
    {
        //Chargement de la liste des lignes existantes
        $lignes = ServStrategique_Model_Ligne::getListeLigne();
        $aeroport = new Application_Model_Aeroport();

        //parcours de ligne pour remplacer l'id par le nom de la ville
        foreach ($lignes as $ligne) {
            $aeroport = new Application_Model_Aeroport();
            $aeroDeco = $aeroport->getAeroport($ligne->get_noAeroportDeco());
            $aeroAtt = $aeroport->getAeroport($ligne->get_noAeroportAtte());
            $ligne->set_noAeroportDeco($aeroDeco->get_labelVille());
            $ligne->set_noAeroportAtte($aeroAtt->get_labelVille());
        }

        //envoi de la ligne
        $this->view->lignes = $lignes;
    }

    public function newvolAction()
    {
        //Chargement de la form associé
        $addVolForm = new ServStrategique_Form_addLigne();
        $this->view->form = $addVolForm;
        $session = new Zend_Session_Namespace('Redirect');

        //initialisation d'un objet ligne
        $ligne = new ServStrategique_Model_Ligne();

        //si le formulaire est valide et en cas d'aeroport de depart = aeroport d'arrivé
        if (!empty($_POST) && $addVolForm->isValid($_POST) &&
            $addVolForm->getValue('aeroDep') == $addVolForm->getValue('aeroAtt')) {
            $this->view->errorMessage = "L'aeroport de départ ne peut être le même
                que celui d'arrivée";
            //sinon si le formulaire est valide
        } else if (!empty($_POST) && $addVolForm->isValid($_POST)) {
            //setter
            $ligne->set_noAeroportAtte($addVolForm->getValue('aeroAtt'))
                ->set_noAeroportDeco($addVolForm->getValue('aeroDep'))
                ->set_etat($addVolForm->getValue('etat'))
                ->set_duree($addVolForm->getValue('duree'));
            switch ($addVolForm->getValue('type')) {
                case 1:
                    $ligne->set_jours($addVolForm->getValue('recurence'));
                    break;
                case 2:
                    $ligne->set_semaines($addVolForm->getValue('recurence'));
                    break;
                case 3:
                $ligne->set_mois($addVolForm->getValue('recurence'));
                    break;
                case 4:
                $ligne->set_annees($addVolForm->getValue('recurence'));
                    break;
                default:
                    $session->message = "insertion impossible, veuillez donner le type de récurence !";
                    $session->redirection = '/ServStrategique/gestvol';
                    $this->_redirect('/redirection/fail');
            }

            //enregistrement
            $reussite = $ligne->addLigne();

            if ($reussite) {
                $session->message = 'La ligne a bien été ajouté !';
                $session->redirection = '/ServStrategique/gestvol';
                $this->_redirect('/redirection/success');
            } else {
                $session->message = "Erreur lors de l'ajout de la ligne !";
                $session->redirection = '/ServStrategique/gestvol';
                $this->_redirect('/redirection/fail');
            }
        } else {
            $this->view->errorMessage = 'Le formulaire est invalide !';
        }
    }

    public function updvolAction()
    {
        //Chargement de la form associé
        $addVolForm = new ServStrategique_Form_addLigne();
        $this->view->form = $addVolForm;

        //session
        $session = new Zend_Session_Namespace('Redirect');

        //initialisation d'un objet ligne
        $id = (int) $this->getRequest()->getParam('id');
        $ligne = ServStrategique_Model_Ligne::getLigne($id);

        //si la ligne n'existe pas
        if (is_null($ligne)) {
            $session->message = "Erreur : la ligne n'existe pas !";
            $session->redirection = '/ServStrategique/gestvol';
            $this->_redirect('/redirection/fail');
        }

        //Préremplissage de la form
        $addVolForm->setDefaults(array(
            'aeroDep' => $ligne->get_noAeroportDeco(),
            'aeroAtt' => $ligne->get_noAeroportAtte(),
            'duree' => $ligne->get_duree(),
            'etat' => $ligne->getStatusLigne()
        ));

        //si le formulaire est valide et en cas d'aeroport de depart = aeroport d'arrivé
        if (!empty($_POST) && $addVolForm->isValid($_POST) &&
            $addVolForm->getValue('aeroDep') == $addVolForm->getValue('aeroAtt')) {
            $this->view->errorMessage = "L'aeroport de départ ne peut être le même
                que celui d'arrivée";
            //sinon si le formulaire est valide
        } else if (!empty($_POST) && $addVolForm->isValid($_POST)) {
            $ligne->set_noAeroportAtte($addVolForm->getValue('aeroAtt'))
                ->set_noAeroportDeco($addVolForm->getValue('aeroDep'))
                ->set_etat($addVolForm->getValue('etat'))
                ->set_duree($addVolForm->getValue('duree'));
            switch ($addVolForm->getValue('type')) {
                case 1:
                    $ligne->set_jours($addVolForm->getValue('recurence'));
                    $ligne->set_semaines(NULL);
                    $ligne->set_mois(NULL);
                    $ligne->set_annees(NULL);
                    break;
                case 2:
                    $ligne->set_jours(Null);
                    $ligne->set_semaines($addVolForm->getValue('recurence'));
                    $ligne->set_mois(NULL);
                    $ligne->set_annees(NULL);
                    break;
                case 3:
                    $ligne->set_jours(Null);
                    $ligne->set_semaines(NULL);
                    $ligne->set_mois($addVolForm->getValue('recurence'));
                    $ligne->set_annees(NULL);
                    break;
                case 4:
                    $ligne->set_jours(Null);
                    $ligne->set_semaines(NULL);
                    $ligne->set_mois(NULL);
                    $ligne->set_annees($addVolForm->getValue('recurence'));
                    break;
                default:
                    $session->message = "insertion impossible, veuillez donner le type de récurence !";
                    $session->redirection = '/ServStrategique/gestvol';
                    $this->_redirect('/redirection/fail');
            }

            //enregistrement
            $reussite = $ligne->addLigne();

            //redirection
            if ($reussite) {
                $session->message = 'La ligne a bien été modifié !';
                $session->redirection = '/ServStrategique/gestvol';
                $this->_redirect('/redirection/success');
            } else {
                $session->message = "Erreur lors de la modifier de la ligne !";
                $session->redirection = '/ServStrategique/gestvol';
                $this->_redirect('/redirection/fail');
            }
        } else {
            $this->view->errorMessage = 'Le formulaire est invalide !';
        }
    }

    public function delvolAction()
    {
        //session
        $session = new Zend_Session_Namespace('Redirect');

        //initialisation d'un objet ligne
        $id = (int) $this->getRequest()->getParam('id');
        $ligne = ServStrategique_Model_Ligne::getLigne($id);

        //si la ligne n'existe pas
        if (is_null($ligne)) {
            $session->message = "Erreur : la ligne n'existe pas !";
            $session->redirection = '/ServStrategique/gestvol';
            $this->_redirect('/redirection/fail');
        }
        //Suppression
        $reussite = $ligne->delLigne($id);

        //redirection
        if ($reussite) {
            $session->message = 'La ligne a bien été supprimé !';
            $session->redirection = '/ServStrategique/gestvol';
            $this->_redirect('/redirection/success');
        } else {
            $session->message = "Erreur lors de la suppression de la ligne !";
            $session->redirection = '/ServStrategique/gestvol';
            $this->_redirect('/redirection/fail');
        }
    }

}

