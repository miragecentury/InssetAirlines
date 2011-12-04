<?php

class ServDRH_GesthabilitationController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction() {
        $habilitation = new ServDRH_Model_Habilitation;
        $listeHabilitations = $habilitation->getHabilitations();     
        
        $this->view->Allhabilitations = $listeHabilitations;        
    }

    public function newhabilitationAction() {
         $form = new ServDRH_Form_gesthabilitation();  
 
         if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
            if ($form->isValid($_POST)) {
                $habilitation = new ServDRH_Model_Habilitation;
                       
                $habilitation->set_labelHabilitation($this->getRequest()->getParam('labelHabilitation'));
                $habilitation->set_labelMetier($this->getRequest()->getParam('labelMetier'));
                $habilitation->set_Modele_label($this->getRequest()->getParam('labelModele'));
                $habilitation->saveHabilitation();
                echo "Habilitation ajoutée !<br />";
                echo "<a href='/ServDRH'>Retour</a>";
            }
         } else if ($this->getRequest()->getParam('annuler') == 'Annuler') {
                    $this->_redirect('/ServDRH/gesthabilitation');
                } else {
                    $this->view->form = $form;                    
                }
    }

    public function updhabilitationAction() {
        $habilitation = new ServDRH_Model_Habilitation();     
        $updForm = new ServDRH_Form_gesthabilitation();
        
        $habilitation = $habilitation->getHabilitationById($_GET['id']);
        if ($this->getRequest()->getParam('enregistrer') != 'Enregistrer') {
            $updForm->getElement('labelHabilitation')->setValue(
                $habilitation->get_labelHabilitation());
            $updForm->getElement('labelMetier')->setValue(
                $habilitation->get_labelMetier());
            $updForm->getElement('labelModele')->setValue(
                $habilitation->get_Modele_label());
            $this->view->updForm = $updForm;   
        } else {
            if ($updForm->isValid($_POST)) {
                $habilitation->set_noHabilitation($_GET['id']);
                $habilitation->set_labelHabilitation(
                    $this->getRequest()->getParam('labelHabilitation'));
                $habilitation->set_labelMetier(
                    $this->getRequest()->getParam('labelMetier'));
                $habilitation->set_Modele_label(
                    $this->getRequest()->getParam('labelModele'));
                $habilitation->saveHabilitation();
                echo "<center>Habilitation modifiée !<br />";
                echo "<a href='/ServDRH'>Retour</a></center>";
            }
        }
        
        if ($this->getRequest()->getParam('annuler') == 'Annuler') {
            $this->_redirect('/ServDRH/gesthabilitation');
        }   
    }
    
    public function delhabilitationAction() {
        $habilitation = new ServDRH_Model_Habilitation;

        $habilitation = $habilitation->getHabilitationById($_GET['id']); 
            $this->view->habilitation = $habilitation;
            if (isset($_GET['rep'])) {
                if ($_GET['rep'] == 'oui') {                
                    $habilitation->delHabilitation($_GET['id']);
                    $this->_redirect('/ServDRH/gesthabilitation');
                }
                if ($_GET['rep'] == 'non') {
                    $this->_redirect('/ServDRH/gesthabilitation');
                }
            }
    }
}