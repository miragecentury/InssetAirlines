<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_S3Controller extends Zend_Controller_Action
{
     public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('../../../../views/scripts/user/_ServPlaningSidebar.phtml');
    }

    public function indexAction()
    {
        //recupération de la liste d'incident
        $listeIncident = Application_Model_ApplicationVar::get( 'ListIncident' );
        $listeIncidentS3 = array( );
        //recupération des types Incidents
        $listeTypeIncident = ServExploitation_Model_TypeIncident::getListeTypeIncident();
        //Parcours du tableau ListeIncident
        foreach ( $listeTypeIncident as $typeIncident ) {
            if ( isset( $listeIncident[ $typeIncident->get_idTypeIncident() ][ 3 ] ) ) {
                $listeIncidentS3[ $typeIncident->get_idTypeIncident() ] = $listeIncident[ $typeIncident->get_idTypeIncident() ][ 3 ];
            }
        }
        //envoie e la liste à la vue
        $this->view->listeIncidentS3 = $listeIncidentS3;

        //----------------------------------------------------------------------
        //recupération des vols planifiés pour S+3
        $listeVols = ServPlaning_Model_Vol::getVolsBySemaine( 3 );
        if ( is_array($listeVols )) {
            $page = Zend_Paginator::factory( $listeVols );
            $page->setPageRange( 3 );
            $page->setCurrentPageNumber( $this->_getParam( 'page', 1 ) );
            $page->setItemCountPerPage( $this->_getParam( 'par', 10 ) );
            $this->view->listeVols = $page;
        }
    }

    public function planifierAction()
    {

    }

}

?>