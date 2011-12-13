<?php

class ServDRH_GesthabilitationController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_DRH')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/fail');
        }
    }

    /*
     * Permet d'afficher la liste des habilitations ou
     * un lien vers le formulaire d'ajout
     */
    public function indexAction() {
        $habilitation = new ServDRH_Model_Habilitation;
        $listeHabilitations = $habilitation->getHabilitations();

        //Si la liste n'est pas vide
        if (!empty($listeHabilitations)) {
            $this->view->Allhabilitations = $listeHabilitations;
        } else {
            $this->view->aucuneHabilitation = "<center><p>Aucune habilitation
                </p><a href='" . Zend_Registry::get('BaseUrl') .
                "/ServDRH'>Retour</a></center>";
        }
    }

    /*
     * Permet d'ajouter une nouvelle habilitation
     */
    public function newhabilitationAction() {
         //Initialise le formulaire
         $form = new ServDRH_Form_gesthabilitation();

         //Affiche le formulaire vierge
         if ($this->getRequest()->getParam('enregistrer') != 'Enregistrer') {
            $this->view->form = $form;
         }

         //Enregistre les données de la nouvelle habilitation
         if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
            //Récupère les données du formulaire
            $donneesForm = $this->getRequest()->getPost();

            //Vérifie que les données du formulaire sont valides
            if ($form->isValid($donneesForm)) {
                //Récupère les données dans un objet habilitation
                $habilitation = new ServDRH_Model_Habilitation;

                //Vérifie que l'habilitation n'existe pas déjà
                $habilitationSelect = $habilitation->getHabilitationByLabel($donneesForm['labelHabilitation']);
                if (is_null($habilitationSelect->get_labelHabilitation())) {

                    //Ajoute la nouvelle habilitation en BDD
                    $habilitation->set_labelHabilitation($this->getRequest()->getParam('labelHabilitation'));
                    $habilitation->set_labelMetier($this->getRequest()->getParam('labelMetier'));
                    $habilitation->set_Modele_label($this->getRequest()->getParam('labelModele'));
                    $habilitation->saveHabilitation();

                    /*
                     * Confirme l'ajout dans la BDD et renvoi l'utilisateur vers
                     * la liste des habilitations
                     */
                    $this->view->habilitation = "<center><p>Habilitation ajoutée !</p>
                        Redirection en cours...</center>";
                    $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
                } else {
                    //Réaffiche le formulaire avec les données précédentes
                    $form->populate($donneesForm);
                    $this->view->form = $form;
                    $this->view->erreurLabel = "<center><p>Attention :
                        Habilitation déjà existante</p></center>";
                }
            } else {
                //Réaffiche le formulaire avec les données précédentes
                $form->populate($donneesForm);
                $this->view->form = $form;
            }
         }

         /*
          * Renvoi l'utilisateur vers la liste des habilitations
          * en cas d'annulation de l'ajout
          */
         if ($this->getRequest()->getParam('annuler') == 'Annuler') {
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/ServDRH/gesthabilitation');
         }
    }

    /*
     * Permet de modifier une habilitation
     */
    public function updhabilitationAction() {
        //Vérifie si un id est passé en paramètre et si c'est un entier
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            /*
             * Récupère les informations de l'habilitation dont l'id est passé en
             * paramètre
             */
            $habilitation = new ServDRH_Model_Habilitation();
            $habilitationSelect = $habilitation->getHabilitationById($_GET['id']);

            //Vérifie s'il l'habilitation existe
            if (!is_null($habilitationSelect)) {
                //Initialise le formulaire
                $updForm = new ServDRH_Form_gesthabilitation();

                //Si aucune modification n'a été posté
                if ($this->getRequest()->getParam('enregistrer') != 'Enregistrer') {
                    //Remplit le formulaire avec les données de la BDD
                    $updForm->getElement('labelHabilitation')->setValue(
                        $habilitationSelect->get_labelHabilitation());
                    $updForm->getElement('labelMetier')->setValue(
                        $habilitationSelect->get_labelMetier());
                    $updForm->getElement('labelModele')->setValue(
                        $habilitationSelect->get_Modele_label());
                    $this->view->updForm = $updForm;
                }

                //Si le formulaire est posté
                if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
                    //Récupère les données du formulaire
                    $donneesForm = $this->getRequest()->getPost();
                    //Si les données du formulaire sont valides
                    if ($updForm->isValid($donneesForm)) {
                        /*
                         * Vérifie que l'habilitation est la même ou
                         * qu'elle n'existe pas en cas de modification
                         */
                        $habilitation = $habilitation->getHabilitationByLabel($donneesForm['labelHabilitation']);
                        if ($habilitationSelect->get_labelHabilitation() == $donneesForm['labelHabilitation'] ||
                            (is_null($habilitation->get_labelHabilitation()))) {

                            //Récupère les données à modifier
                            $habilitationSelect->set_noHabilitation($_GET['id']);
                            $habilitationSelect->set_labelHabilitation(
                                $this->getRequest()->getParam('labelHabilitation'));
                            $habilitationSelect->set_labelMetier(
                                $this->getRequest()->getParam('labelMetier'));
                            $habilitationSelect->set_Modele_label(
                                $this->getRequest()->getParam('labelModele'));
                            $habilitationSelect->saveHabilitation();

                            /*
                             * Confirme la modification et renvoi l'utilisateur vers
                             * la liste des habilitations
                             */
                            $this->view->habilitation = "<center><p>Habilitation
                                modifiée</p>Redirection en cours...</center>";
                            $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
                         } else {
                            /*
                             * Réaffiche le formulaire avec les données précédentes
                             */
                            $updForm->populate($donneesForm);
                            $this->view->updForm = $updForm;
                            $this->view->erreurLabel = "<center><p>Attention :
                                Habilitation déjà existante</p></center>";
                         }
                    } else {
                        /*
                         * Réaffiche le formulaire avec les données précédentes
                         */
                        $updForm->populate($donneesForm);
                        $this->view->updForm = $updForm;
                    }
                }

                /*
                 * Renvoi l'utilisateur vers la liste des habilitations si la
                 * modification est annulée
                 */
                if ($this->getRequest()->getParam('annuler') == 'Annuler') {
                    $this->_redirect(Zend_Registry::get('BaseUrl') . '/ServDRH/gesthabilitation');
                }
            } else {
                /*
                 * Erreur : habilitation inexistante
                 * Renvoi l'utilisateur vers la liste des habilitations
                 */
                $this->view->erreurId = "<center><p>Habilitation inexistante</p>Redirection en cours...</center>";
                $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
            }
        } else {
            /*
             * Affiche un message d'erreur et renvoi l'utilisateur vers la liste
             * des habilitations
             */
            $this->view->erreurId = "<center><p>L'id est manquant ou n'est pas
                valide</p>Redirection en cours...</center>";
            $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
        }
    }

    /*
     * Permet de supprimer une habilitation
     */
    public function delhabilitationAction() {
        /*
         * Vérifie que l'id passé en paramètre n'est pas manquant
         * et/ou que c'est un entier
         */
        if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            //Récupère l'habilitation correspondant à l'id
            $habilitation = new ServDRH_Model_Habilitation;
            $habilitationSelect = $habilitation->getHabilitationById($_GET['id']);

            //Vérifie que l'habilitation existe
            if (!is_null($habilitationSelect)) {
                //Traite la réponse de l'utilisateur
                $this-> view->habilitation = $habilitationSelect;
                //Si un réponse est donnée
                if (isset($_GET['rep'])) {
                    //Si la suppression est confirmée
                    if ($_GET['rep'] == 'oui') {
                        //Supprime l'habilitation dont l'id est donnée en paramètre
                        $habilitation->delHabilitation($_GET['id']);

                        /*
                         * Confirme la suppression et renvoi l'utilisateur
                         * vers la liste des habilitations
                         */
                        $this->view->supprimer = "<center><p>Habilitation supprimée
                            </p>Redirection en cours...</center>";
                        $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
                    }
                    //Si la suppression est annulée
                    if ($_GET['rep'] == 'non') {
                        //Renvoi l'utilsateur vers la liste des habilitations
                        $this->_redirect(Zend_Registry::get('BaseUrl') . '/ServDRH/gesthabilitation');
                    }
                }
            } else {
                //Erreur : habilitation inexistante
                //Renvoi l'utilisateur vers la liste des habilitations
                $this->view->erreurId = "<center><p>Habilitation inexistante</p>
                    Redirection en cours...</center>";
                $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
            }
        } else {
            //Erreur : id manquant ou invalide
            //Renvoi l'utilisateur vers la liste des habilitations
            $this->view->erreurId = "<center><p>L'id est manquant ou n'est pas
                valide</p>Redirection en cours...</center>";
            $this->getResponse()->setHeader('refresh', '3,url=' . Zend_Registry::get('BaseUrl') .
                '/ServDRH/gesthabilitation');
        }
    }
}