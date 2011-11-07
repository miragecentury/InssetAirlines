<?php

/**
 * Description of UtilisateurController
 *
 * @author pewho
 */
class UtilisateurController extends Zend_Controller_Action
{

    private $_acl;
    private $_email;
    private $_personneActuelle;

    public function init()
    {
        $this->view->render('user/_sidebar.phtml');
        $this->view->render('user/_utilisateurSidebar.phtml');
        $this->view->render('user/_login.phtml');
        $this->_acl = Zend_Registry::get('Acl');

        //Rediredtion auto si pas authentifié
        /* TODO : A activer lorsque le probleme des acl (heritage) sera reglé
          $authSession = new Zend_Session_Namespace('Zend_Auth');
          if (!$this->_acl->isAllowed($authSession->role, 'Auth')) {
          $this->_redirect('/');
          }
         */
    }

    public function indexAction()
    {
        //TODO : Rendre getPersonneByMail static
        $pers = $this->_getPersonneActuelle();
        $this->view->personne = $pers;
    }

    public function modifmdpAction()
    {
        //recupération du profil de la personne connecté
        $pers = $this->_getPersonneActuelle();

        //chargement de la form
        $changeMdpForm = new Application_Form_Utilisateur_ModifMdp();
        $this->view->changeMdpForm = $changeMdpForm;
        $this->view->personne = $pers;

        //si le formulaire est valide
        if ($changeMdpForm->isValid($_POST)) {
            $ancienMdp = $changeMdpForm->getValue('ancienMdp');
            //si le mot de passe courant et le mot de passe renseigné dans la form est ==
            if ($ancienMdp === $pers->get_password()) {
                $pers->set_password($changeMdpForm->getValue('nouveauMdp'));
                if (null !== $pers->get_noPersonne()) {
                    $pers->savePersonneById($pers->get_noPersonne());
                    $this->_redirect('utilisateur');
                } else {
                    $this->view->errorMessage = "Erreur lors de l'enregistrement du mot de passe";
                }
            } else {
                $this->view->errorMessage = "L'ancien mot de passe ne correspond pas !";
            }
        }
    }

    public function profilAction()
    {
        //recupération du profil de la personne connecté
        $pers = $this->_getPersonneActuelle();

        //passage des info de personnes à la vue
        $this->view->personne = $pers;

        //recupération de l'adresse associé à la personne
        $adresse = Application_Model_Adresse::getAdresse($pers->get_noAdresse());

        //passage des info sur l'addresse à la vue
        $this->view->adresse = $adresse;

        //récupération des id Telephone associés à personne

        $noTels =
            Application_Model_PersonneHasTelephoneMapper::getTelephonesByIdPersonne(
                $pers->get_noPersonne());

        //recupération des num de telephone associés
        $telephone = array();
        foreach ($noTels as $noTel) {
            $idTel = intval($noTel['noTelephone']);
            $telephone[] = Application_Model_Telephone::getTelephone($idTel);
        }

        //passage des numéros de tel à la vue;
        $this->view->telephone = $telephone;
    }

    //GETTERS
    protected function _get_email()
    {

        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!empty($authSession->storage) && isset($authSession->storage)) {
            $this->_email = $authSession->storage;
        } else {
            $this->_redirect('/');
        }
    }

    protected function _getPersonneActuelle()
    {
        //TODO : creer un systeme permetant sa perenité apres chargement ...(session)
        if ($this->_personneActuelle === null) {
            $this->_get_email();
            $pers = Application_Model_Personne::getPersonneByMail($this->_email);
            $this->_personneActuelle = $pers;
        }
        return $this->_personneActuelle;
    }

}

