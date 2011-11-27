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
        $this->view->render( 'user/_sidebar.phtml' );
        $this->view->render( 'user/_utilisateurSidebar.phtml' );
        $this->view->render( 'user/_login.phtml' );
        $this->_acl = Zend_Registry::get( 'Acl' );

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
        if ( !empty( $_POST ) && $changeMdpForm->isValid( $_POST ) ) {
            $ancienMdp = $changeMdpForm->getValue( 'ancienMdp' );
            //si le mot de passe courant et le mot de passe renseigné dans la form est ==
            if ( $ancienMdp === $pers->get_password() ) {
                $pers->set_password( $changeMdpForm->getValue( 'nouveauMdp' ) );
                if ( null !== $pers->get_noPersonne() ) {
                    $pers->savePersonneById( $pers->get_noPersonne() );
                    $this->_personneActuelle = null;
                    $this->_redirect( '/utilisateur' );
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
        $adresse = Application_Model_Adresse::getAdresse( $pers->get_noAdresse() );

        //passage des info sur l'addresse à la vue
        $this->view->adresse = $adresse;

        //récupération des id Telephone associés à personne

        $telephones =
            Application_Model_PersonneView::getTelephonesByPersonne(
                $pers->get_noPersonne()
        );

        //passage des numéros de tel à la vue;
        $this->view->telephones = $telephones;
    }

    public function modifemailAction()
    {
        //Récupération de la personne actuelle
        $pers = $this->_getPersonneActuelle(); //chargement de la form
        //Chargement de la vue
        $changeEmailForm = new Application_Form_Utilisateur_ModifEmail();
        $this->view->changeEmailForm = $changeEmailForm;
        $this->view->personne = $pers;

        //Si le form est valide :
        if ( !empty( $_POST ) && $changeEmailForm->isValid( $_POST ) ) {
            $idPers = $pers->get_noPersonne();
            if ( isset( $idPers ) && !empty( $idPers ) ) {
                $email = $changeEmailForm->getValue( 'email' );
                $pers->set_email( $email );
                $pers->savePersonneById( $pers->get_noPersonne() );
                //Changement de login pour la ssesion en cours
                $authSession = new Zend_Session_Namespace( 'Zend_Auth' );
                $authSession->storage = $email;
                //reinit
                $this->_personneActuelle = null;
                $this->_redirect( '/utilisateur/profil/' );
            } else {
                $this->view->errorMessage = "Non connecté, veuiller vous logger";
            }
        } else {
            $this->view->errorMessage = "Veuiller remplir le formulaire";
        }
    }

    public function modifadresseAction()
    {
        //Récupération de la personne actuelle
        $pers = $this->_getPersonneActuelle(); //chargement de la form
        //Chargement de la vue
        $changeAdresseForm = new Application_Form_Utilisateur_modifAdresse();
        $this->view->changeAdresseForm = $changeAdresseForm;
        $this->view->personne = $pers;

        //recupération de l'adresse
        $adresse = Application_Model_Adresse::getAdresse( $pers->get_noAdresse() );

        //Si le formulaire est valide
        if ( !empty( $_POST ) && $changeAdresseForm->isValid( $_POST ) ) {

            $adresse->set_numero( $changeAdresseForm->getValue( 'numero' ) );
            $adresse->set_porte( $changeAdresseForm->getValue( 'porte' ) );
            $adresse->set_etage( $changeAdresseForm->getValue( 'etage' ) );
            $adresse->set_immeuble( $changeAdresseForm->getValue( 'immeuble' ) );
            $adresse->set_adresse( $changeAdresseForm->getValue( 'adresse' ) );
            $adresse->set_codepostal( $changeAdresseForm->getValue( 'codePostal' ) );
            $adresse->set_labelVille( $changeAdresseForm->getValue( 'ville' ) );
            $adresse->set_etatProvince( $changeAdresseForm->getValue( 'etatProvince' ) );
            $adresse->set_labelPays( $changeAdresseForm->getValue( 'pays' ) );
            $adresse->set_commentaire( $changeAdresseForm->getValue( 'commentaire' ) );

            $adresse->addAdresse();

            //reinit
            $this->_redirect( '/utilisateur/profil/' );
            $this->_PersonneActuelle = null;
        } else {
            $this->view->errorMessage = 'Le formulaire est invalide !';
        }
    }

    public function modiftelephoneAction()
    {
        //recupération de la personne courante
        $pers = $this->_getPersonneActuelle();

        //chargement de la form
        $changeTelephoneForm = new Application_Form_Utilisateur_ModifTelephone();

        $this->view->personne = $pers;


        //récupération de l'objet telephone concerné
        $tel = Application_Model_Telephone::getTelephone(
                $this->getRequest()->getParam( 'id' ) );

        //récupération de l'objet Personne_has_Telephone
        $assoc = Application_Model_PersonneHasTelephone::getAssoc(
                $pers->get_noPersonne(), $this->getRequest()->getParam( 'id' ) );
        //Pretection du parametre en get (id)
        //Si l'association n'existe pas, id changé a la main -> annulation de la requete
        if ( $assoc == null ) {
            $this->view->changeTelephoneForm = $changeTelephoneForm;
            $this->view->errorMessage = "Annulation de la requete,
                ce numero ne vous appartient pas ou n'existe pas!";
            $this->getResponse()->setHeader('refresh', '2,URL=../../');
        } else {

            //preremplissage de la form
            $changeTelephoneForm->setDefaults( array(
                'labelTelephone' => $assoc->get_labelTelephone(),
                'numTelephone' => $tel->get_numTelephone(),
            ) );

            //chargement de la form (fin)
            $this->view->changeTelephoneForm = $changeTelephoneForm;

            //Si le formulaire est valide
            if ( isset( $_POST ) &&
                !empty( $_POST ) &&
                $changeTelephoneForm->isValid( $_POST ) ) {

                //Modif 1 : numéro de téléphone changé
                if ( isset( $_POST[ 'numTelephone' ] ) &&
                    !empty( $_POST[ 'numTelephone' ] ) ) {
                    //setter
                    $tel->set_numTelephone( $this->_request->getParam( 'numTelephone' ) );

                    //sauvegarde
                    $tel->addTelephone();
                }

                //Modif 2 : label de téléphone
                if ( isset( $_POST[ 'labelTelephone' ] ) &&
                    !empty( $_POST[ 'labelTelephone' ] ) ) {
                    //setter
                    $assoc->set_labelTelephone( $this->_request->getParam( 'labelTelephone' ) );

                    //sauvegarde
                    $assoc->addAssoc();
                }
                //conservation de l'id
                $this->getRequest()->setParam( 'id', $this->getRequest()->getParam( 'id' ) );

                //réinit
                $this->_redirect( '/utilisateur/profil/' );
                $this->_PersonneActuelle = null;
            } else {
                $this->view->errorMessage = 'Le formulaire est invalide !';
            }
        }
    }

    public function deletetelephoneAction()
    {
        //recupération de la personne courante
        $pers = $this->_getPersonneActuelle();
        $this->view->personne = $pers;

        //récupération de l'objet Personne_has_Telephone
        $assoc = Application_Model_PersonneHasTelephone::getAssoc(
            $pers->get_noPersonne(), $this->getRequest()->getParam( 'id' ) );
        if ( $assoc == null ) {

            $this->view->errorMessage = "Annulation de la requete,
                ce numero ne vous appartient pas ou n'existe pas!";
            $this->getResponse()->setHeader( 'refresh', '2,url=../../' );
        } else {
            $assoc->delAssoc();
            unset( $assoc );
        }

        //réinit
        $this->_PersonneActuelle = null;
    }

    //GETTERS
    protected function _get_email()
    {

        $authSession = new Zend_Session_Namespace( 'Zend_Auth' );
        if ( !empty( $authSession->storage ) && isset( $authSession->storage ) ) {
            $this->_email = $authSession->storage;
        } else {
            $this->_redirect( '/' );
        }
    }

    protected function _getPersonneActuelle()
    {
        //TODO : creer un systeme permetant sa perenité apres chargement ...(session)
        if ( $this->_personneActuelle === null ) {
            $this->_get_email();
            $pers = Application_Model_Personne::getPersonneByMail( $this->_email );
            $this->_personneActuelle = $pers;
        }
        return $this->_personneActuelle;
    }

}

