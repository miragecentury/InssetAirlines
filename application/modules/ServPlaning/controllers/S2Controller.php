<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_S2Controller extends Zend_Controller_Action
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
        $listeIncidentS2 = array( );
        //recupération des types Incidents
        $listeTypeIncident = ServExploitation_Model_TypeIncident::getListeTypeIncident();
        //Parcours du tableau ListeIncident
        foreach ( $listeTypeIncident as $typeIncident ) {
            if ( isset( $listeIncident[ $typeIncident->get_idTypeIncident() ][ 2 ] ) ) {
                $listeIncidentS2[ $typeIncident->get_idTypeIncident() ] = $listeIncident[ $typeIncident->get_idTypeIncident() ][ 2 ];
            }
        }
        //envoie e la liste à la vue
        $this->view->listeIncidentS2 = $listeIncidentS2;

        //----------------------------------------------------------------------
        //recupération des vols planifiés pour S+2
        $listeVols = ServPlaning_Model_Vol::getVolsBySemaine( 2 );
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