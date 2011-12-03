<?php

class ServStrategique_GestvolController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
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
        $this->view->lignes = $lignes;
    }

    public function newvolAction()
    {
        //Chargement de la form associé
        $addVolForm = new ServStrategique_Form_addLigne();
        $this->view->form = $addVolForm;

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
            $ligne->set_labelAeroportAtte($addVolForm->getValue('aeroAtt'))
                ->set_labelAeroportDeco($addVolForm->getValue('aeroDep'))
                ->set_jours($addVolForm->getValue('jour'))
                ->set_semaines($addVolForm->getValue('semaine'))
                ->set_mois($addVolForm->getValue('mois'))
                ->set_annees($addVolForm->getValue('annee'));

            //enregistrement
            $reussite = $ligne->addLigne();
            $session = new Zend_Session_Namespace('Redirect');
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
        $session = new Zend_Session_Namespace('Redirect');

        //initialisation d'un objet ligne
        $id = (int) $this->getRequest()->getParam('id');
        $ligne = ServStrategique_Model_Ligne::getLigne($id);

        //si la ligne n'existe pas
        if (is_null($ligne)){
            $session->message = "Erreur : la ligne n'existe pas !";
            $session->redirection = '/ServStrategique/gestvol';
            $this->_redirect('/redirection/fail');
        }

        //Préremplissage de la form
        $addVolForm->setDefaults(array(
            'aeroDep' => $ligne->get_labelAeroportDeco(),
            'aeroAtt' => $ligne->get_labelAeroportAtte(),
            'jour' => $ligne->get_jours(),
            'semaine' => $ligne->get_semaines(),
            'mois' => $ligne->get_mois(),
            'annee' => $ligne->get_annees()
        ));

        //si le formulaire est valide et en cas d'aeroport de depart = aeroport d'arrivé
        if (!empty($_POST) && $addVolForm->isValid($_POST) &&
            $addVolForm->getValue('aeroDep') == $addVolForm->getValue('aeroAtt')) {
            $this->view->errorMessage = "L'aeroport de départ ne peut être le même
                que celui d'arrivée";
            //sinon si le formulaire est valide
        } else if (!empty($_POST) && $addVolForm->isValid($_POST)) {
            //setter
            $ligne->set_labelAeroportAtte($addVolForm->getValue('aeroAtt'))
                ->set_labelAeroportDeco($addVolForm->getValue('aeroDep'))
                ->set_jours($addVolForm->getValue('jour'))
                ->set_semaines($addVolForm->getValue('semaine'))
                ->set_mois($addVolForm->getValue('mois'))
                ->set_annees($addVolForm->getValue('annee'));

            //enregistrement
            $reussite = $ligne->addLigne();

            //redirection
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

    public function delvolAction()
    {

    }

}

