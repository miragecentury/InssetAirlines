<?php

/**
 * Description of SController
 *
 * @author pewho
 */
class ServPlaning_SController extends Zend_Controller_Action
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
        $listeIncidentS = array( );
        //recupération des types Incidents
        $listeTypeIncident = ServExploitation_Model_TypeIncident::getListeTypeIncident();
        //Parcours du tableau ListeIncident
        foreach ( $listeTypeIncident as $typeIncident ) {
            if ( isset( $listeIncident[ $typeIncident->get_idTypeIncident() ][ 0 ] ) ) {
                $listeIncidentS[ $typeIncident->get_idTypeIncident() ] = $listeIncident[ $typeIncident->get_idTypeIncident() ][ 0 ];
            }
        }
        //envoie e la liste à la vue
        $this->view->listeIncidentS = $listeIncidentS;


    }

    public function planifierAction()
    {

    }

}

?>
