<?php

class ServMaintenance_GestconstructeurController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection( false );
        $this->view->render( '../../../../views/scripts/user/_sidebar.phtml' );
        $this->view->render( '../../../../views/scripts/user/_login.phtml' );
        $this->view->render( 'sidebar/_homeMaintenanceSideBar.phtml' );
        $this->view->render( 'sidebar/_homeGestConstructeurSideBar.phtml' );
    }

    /**
     *  Affichage de la liste des Constructeurs + boutton de suppression à chaque Constructeur
     */
    public function indexAction()
    {
        $liste_constructeur = ServMaintenance_Model_Constructeur::GetAll();
        $this->view->lstConstructeur = $liste_constructeur;
    }

    /**
     * Ajout d'un constructeur
     */
    public function newconstructeurAction()
    {
        $newForm = new ServMaintenance_Form_Constructeur();
        if ( !empty( $_POST ) && $newForm->isValid( $_POST ) ) {
            $this->view->message = 'Ajout réussi !';
            //Adresse ...
            $adresse = new Application_Model_Adresse();
            $adresse->set_numero( $newForm->getValue( 'numero' ) );
            $adresse->set_porte( $newForm->getValue( 'porte' ) );
            $adresse->set_etage( $newForm->getValue( 'etage' ) );
            $adresse->set_immeuble( $newForm->getValue( 'immeuble' ) );
            $adresse->set_adresse( $newForm->getValue( 'adresse' ) );
            $adresse->set_codepostal( $newForm->getValue( 'codePostal' ) );
            $adresse->set_labelVille( $newForm->getValue( 'ville' ) );
            $adresse->set_etatProvince( $newForm->getValue( 'etatProvince' ) );
            $adresse->set_labelPays( $newForm->getValue( 'pays' ) );
            $adresse->set_commentaire( $newForm->getValue( 'commentaire' ) );
            //Save adresse ...
            try {
                $idAdresse = $adresse->addAdresse();
            } catch ( Exception $e ) {
                $this->view->message = "Echec de l'ajout de l'adresse";
            }
            //Constructeur ...
            $constructeur = new ServMaintenance_Model_Constructeur();
            $constructeur->set_label( $_POST[ 'label' ] )->set_noAdresse( $idAdresse );
            //Save constructeur ...
            try {
                $constructeur->Save();
            } catch ( Exception $e ) {
                $this->view->message = 'Echec de l\'ajout du constructeur';
            }
        } else {
            $this->view->message = 'Merci de bien remplir le formulaire !';
            $this->view->newForm = $newForm;
        }
    }

    /**
     *  Suppresion d'un constructeur
     *  //Attention (voir si on autorise la supression qui n'est pas logique)
     */
    public function delconstructeurAction()
    {
        $id = ( int ) $this->getRequest()->getParam( 'id' );

        if ( isset( $id ) && !empty( $id ) ) {
            if ( preg_match( '#^[0-9]{1,10}$#', $id ) && $id > 0 ) {

                try {
                    $constructeur = ServMaintenance_Model_Constructeur::FindOne( $id );
                    if ( is_a( $constructeur, 'ServMaintenance_Model_Constructeur' ) && $constructeur != NULL ) {
                        $constructeur->Del();
                        $this->view->message = 'Constructeur Supprimer';
                        $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                            '/ServMaintenance/Gestconstructeur' );
                        //Redirect
                        $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                            '/ServMaintenance/Gestconstructeur' );
                    } else {
                        $this->view->message = 'Aucun Controleur avec cette id';
                        //Redirect
                        $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                            '/ServMaintenance/Gestconstructeur' );
                    }
                } catch ( Exception $e ) {
                    $this->view->message = 'Id Incohérente - Aucun Constructeur';
                    //Redirect
                    $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                        '/ServMaintenance/Gestconstructeur' );
                }
            } else {
                $this->view->message = 'Erreur de Paramètre - Redirection';
                //Redirect
                $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                    '/ServMaintenance/Gestconstructeur' );
            }
        } else {
            $this->view->message = 'Erreur de Parcours - Redirection';
            //Redirect
            $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                '/ServMaintenance/Gestconstructeur' );
        }
    }

}

