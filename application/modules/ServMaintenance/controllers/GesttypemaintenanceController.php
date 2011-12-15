<?php

class ServMaintenance_GesttypemaintenanceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection( false );
        $this->view->render( '../../../../views/scripts/user/_sidebar.phtml' );
        $this->view->render( '../../../../views/scripts/user/_login.phtml' );
        $this->view->render( 'sidebar/_homeMaintenanceSideBar.phtml' );
        $this->view->render( 'sidebar/_homeGestTypeMaintenanceSideBar.phtml' );
    }

    public function indexAction()
    {
        $modeles = ServMaintenance_Model_Modele::getAll();
        $ListeModeles = array( );
        $ListeConstructeur = array( );
        $ListeTypesMaintenance = array( );

        $ListeConstructeurRaw = ServMaintenance_Model_Constructeur::GetAll();
        foreach ( $ListeConstructeurRaw as $Constructeur ) {
            if ( $Constructeur instanceof ServMaintenance_Model_Constructeur ) {
                $ListeConstructeur[ $Constructeur->get_noConstructeur() ] = $Constructeur;
            }
        }

        foreach ( $modeles as $modele ) {
            if ( $modele instanceof ServMaintenance_Model_Modele ) {
                $TypesMaintenances = ServMaintenance_Model_TypeMaintenance::findAllByModele( $modele->get_noModele() );
                $ListeModeles[ $modele->get_noModele() ] = $modele;
                $ListeTypesMaintenance[ $modele->get_noModele() ] = $TypesMaintenances;
            }
        }
        $this->view->ListeModeles = $ListeModeles;
        $this->view->ListeTypesMaintenance = $ListeTypesMaintenance;
        $this->view->ListeConstructeur = $ListeConstructeur;
    }

    public function newtypemaintenanceAction()
    {
        if ( isset( $_POST ) && !empty( $_POST ) ) {
            $form = new ServMaintenance_Form_TypeMaintenance();
            if ( $form->isValid( $_POST ) ) {
                if ( ServMaintenance_Model_Modele::findOne( $_POST[ 'noModele' ] ) instanceof ServMaintenance_Model_Modele ) {
                    $TypeMaintenance = new ServMaintenance_Model_TypeMaintenance();
                    $TypeMaintenance->set_label( $_POST[ 'label' ] )
                        ->set_noModele( $_POST[ 'noModele' ] )
                        ->set_periode( $_POST[ 'periode' ] )
                        ->set_dureeMaintenance( $_POST[ 'dureeMaintenance' ] );
                    try {
                        $TypeMaintenance->save();
                        $this->view->message = 'Ajout du Type de Maintenance Confirmé';
                        $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                            '/ServMaintenance/Gesttypemaintenance' );
                    } catch ( Exception $e ) {
                        $this->view->message = 'Erreur Impromptue' . $e->getMessage() . ':' . $e->getPrevious()->getMessage();
                        $this->view->form = $form;
                    }
                } else {
                    $this->message = 'Modèle Incorrecte !';
                    $this->view->form = $form;
                }
            } else {
                $this->message = 'Données de création Incorrecte !';
                $this->view->form = $form;
            }
        } else {
            $noModele = $this->getRequest()->getParam( 'noModele' );
            if ( $noModele === null ) {
                $this->view->form = new ServMaintenance_Form_TypeMaintenance();
            } else {
                if ( preg_match( '#^[0-9]{1,10}$#', $noModele ) && $noModele > 0 ) {
                    $this->view->form = new ServMaintenance_Form_TypeMaintenance( $noModele );
                } else {
                    $this->view->form = new ServMaintenance_Form_TypeMaintenance();
                }
            }
        }
    }

    public function updtypemaintenanceAction()
    {
        $noTypeMaintenance = $this->getRequest()->getParam( 'noTypeMaintenance' );
        if ( isset( $_POST ) && !empty( $_POST ) ) {
            if (
                preg_match( '#^[0-9]{1,10}$#', $noTypeMaintenance ) && $noTypeMaintenance > 0 &&
                ($TypeMaintenance = ServMaintenance_Model_TypeMaintenance::findOne( $noTypeMaintenance )) instanceof ServMaintenance_Model_TypeMaintenance
            ) {
                $form = new ServMaintenance_Form_TypeMaintenance();
                $form->updateForm( $TypeMaintenance );
                if ( $form->isValid( $_POST ) ) {
                    $TypeMaintenance->set_dureeMaintenance( $_POST[ 'dureeMaintenance' ] );
                    $TypeMaintenance->set_periode( $_POST[ 'periode' ] );
                    try {
                        $TypeMaintenance->save();
                        $this->view->message = 'Modification Effectuée';
                        $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                            '/ServMaintenance/Gesttypemaintenance' );
                    } catch ( Exception $e ) {
                        $this->view->message = 'Erreur Inopinée : ' . $e->getMessage() . ' : ' . $e->getPrevious()->getMessage();
                        $this->view->form = $form;
                    }
                } else {
                    $this->view->message = 'Données Incorrectes';
                    $this->view->form = $form;
                }
            } else {
                $this->view->message = 'Type de Maintenance Incorrecte!';
                $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                    '/ServMaintenance/Gesttypemaintenance' );
            }
        } else {
            if ( preg_match( '#^[0-9]{1,10}$#', $noTypeMaintenance ) && $noTypeMaintenance > 0 ) {
                if ( ($TypeMaintenance = ServMaintenance_Model_TypeMaintenance::findOne( $noTypeMaintenance )) instanceof ServMaintenance_Model_TypeMaintenance ) {
                    $form = new ServMaintenance_Form_TypeMaintenance();
                    $form->updateForm( $TypeMaintenance );

                    $this->view->form = $form;
                } else {
                    $this->view->message = 'Type de Maintenance Incorrecte!';
                    $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                        '/ServMaintenance/Gesttypemaintenance' );
                }
            } else {
                $this->view->message = 'Type de Maintenance Incorrecte!';
                $this->getResponse()->setHeader( 'refresh', '2,url=' . Zend_Registry::get( 'BaseUrl' ) .
                    '/ServMaintenance/Gesttypemaintenance' );
            }
        }
    }

    public function deltypemaintenanceAction()
    {

    }

}

