<?php

class ServDRH_GestpiloteController extends Zend_Controller_Action {

    public function init() {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');  
        
        /* 
         * Vérifie que l'utilisateur possède les droits d'accès au service DRH          
         * grâce aux ACL
         */
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_DRH')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirection/fail');
        }
    }

    public function indexAction() {  
        /*
         * Instancie les objets employe, personne et adresse ainsi que 
         * les listes des employé, métiers et adresses pour afficher les données
         * déjà présentes en BDD
         */
        $employe = new ServDRH_Model_Employe();
        $personne = new Application_Model_Personne();
        $adresse = new Application_Model_Adresse();
        $listeEmployes = array();
        $listeMetiers = array();
        $listeAdresses = array();

        /*
         * Génère les données des différentes listes pour les afficher
         */
        $employes = $employe->getEmployes();        
        foreach ($employes as $row) {
            $noPersonne = $row->get_Personne_noPersonne();
            $personne = Application_Model_Personne::getPersonneById($noPersonne);            
            $listeEmployes[] = $personne;
            $listeMetiers[] = $row->get_labelMetier();
            $listeAdresses[] = $adresse->getAdresse($personne->get_noAdresse());
        }
        $this->view->AllPersonnes = $listeEmployes;  
        $this->view->ListeMetiers = $listeMetiers;
        $this->view->ListeAdresses = $listeAdresses;
    }

    /*
     * Permet d'ajouter une nouvelle personne et/ou employé
     */
    public function newpiloteAction() {
        //Enregistrement d'une nouvelle personne et/ou employé
        $form = new ServDRH_Form_gestpilote();  
        /*
         * Oblige la création d'un password lors d'un nouvel ajout de personne
         * et/ou employé 
         */
        $form->getElement('password')->setRequired(true);
        $form->getElement('passwordConfirm')->setRequired(true);
        
        $erreurHabilitations = false;
               
        //Vérifie si le formulaire est posté pour un enregistrement
        if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
            //Récupère les données du formulaire
            $donneesForm = $this->getRequest()->getPost();
            //Vérifie si les données sont valides
            if ($form->isValid($donneesForm)) {
                //Vérifie que les mdp sont identiques
                if ($this->getRequest()->getParam('password') == $this->getRequest()->getParam('passwordConfirm')) {
                    if (($this->getRequest()->getParam('labelMetier') != "Pilote") &&
                        (sizeof($this->getRequest()->getParam('habilitation')) > 0)) {
                            $form->populate($donneesForm);
                            $this->view->$erreurHabilitations = "<p><center>Attention : 
                                L'employé n'est pas un pilote, il ne peut avoir 
                                d'habilitation(s) !</center></p>";
                            $this->view->form = $form;                            
                            $erreurHabilitations = true;
                    }
                    if ($erreurHabilitations == false) {
                        /*
                         * Initialise les objets personne et adresse
                         * qui vont permettre de sauvegarder les données en BDD
                         */
                        $personne = new Application_Model_Personne;
                        $adresse = new Application_Model_Adresse;

                        /*Vérifie si la personne du formulaire existe ou non dans
                         * la BDD en recherchant le n° INSEE
                         */
                        $personne = $personne->getPersonneByNoInsee($this->getRequest()->getParam('noINSEE'));                                         
                        if (is_null($personne->get_noPersonne())) {
                            //Enregistrement de l'adresse
                            $adresse->set_numero($this->getRequest()->getParam('numero'));
                            $adresse->set_porte($this->getRequest()->getParam('porte'));
                            $adresse->set_adresse($this->getRequest()->getParam('labelAdresse'));
                            $adresse->set_etage($this->getRequest()->getParam('etage'));
                            $adresse->set_immeuble($this->getRequest()->getParam('immeuble'));
                            $adresse->set_codepostal($this->getRequest()->getParam('cp'));
                            $adresse->set_etatProvince($this->getRequest()->getParam('etatProvince'));
                            $adresse->set_labelVille($this->getRequest()->getParam('ville'));
                            $adresse->set_labelPays($this->getRequest()->getParam('pays'));                        
                            /*
                             * Ajoute l'adresse en BDD et récupère l'id généré lors
                             * de l'ajout
                             */
                            $noAdresse = $adresse->addAdresse();

                            /*
                             * Récupère la date de naissance et vérifie si celle-ci
                             * est valide (fonction checkdate())
                             */
                            $jour = $this->getRequest()->getParam('jourNaissance');
                            $mois = $this->getRequest()->getParam('moisNaissance'); 
                            $annee = $this->getRequest()->getParam('anneeNaissance');   
                            if (checkdate($mois, $jour, $annee) == true) {                        
                                //Enregistrement de la personne 
                                $personne->set_nom(
                                    $this->getRequest()->getParam('nom'));
                                $personne->set_prenom(
                                    $this->getRequest()->getParam('prenom'));
                                $personne->set_prenom2(
                                    $this->getRequest()->getParam('prenom2'));
                                $personne->set_prenom3(
                                    $this->getRequest()->getParam('prenom3'));
                                $personne->set_dateNaissance(
                                    $annee."-".$mois."-".$jour);
                                $personne->set_noINSEE(
                                    $this->getRequest()->getParam('noINSEE'));
                                $personne->set_noAdresse($noAdresse);
                                $personne->set_labelPays(
                                    $this->getRequest()->getParam('pays'));
                                $personne->set_role(
                                    $this->getRequest()->getParam('role'));
                                $personne->set_password(
                                    $this->getRequest()->getParam('password'));
                                $personne->set_password_salt(
                                    $this->getRequest()->getParam('passwordConfirm'));
                                $personne->set_email(
                                    $this->getRequest()->getParam('email'));                                       

                                /*
                                 * Enregistre les données en BDD et récupère l'id
                                 * généré lors de l'ajout
                                 */                            
                                $noPersonne = $personne->savePersonneById('');

                                /*Récupère la personne que l'on vient d'enregistrer
                                $personne = $personne->getPersonneByNoInsee(
                                    $this->getRequest()->getParam('noINSEE'));*/

                                /*
                                 * Vérifie si la personne saisie dans le formulaire
                                 * est un employé
                                 */
                                if ($this->getRequest()->getParam('labelMetier') != ''){
                                    //Initialise un objet employe
                                    $employe = new ServDRH_Model_Employe;

                                    /*
                                     * Enregistre l'employé dans la BDD
                                     */
                                    $employe->set_labelMetier(
                                        $this->getRequest()->getParam('labelMetier'));
                                    $employe->set_Personne_noPersonne($noPersonne);
                                    $employe->saveEmploye();                                                               

                                    if ($this->getRequest()->getParam('labelMetier') == 'Pilote') {                                    
                                        if (sizeof($this->getRequest()->getParam('habilitation')) > 0) {
                                            //Initialise un objet qualification
                                            $qualifications = new ServDRH_Model_Qualification;
                                            /*
                                             * Enregistre les qualifications, s'il y en a,
                                             * de l'employé
                                             */
                                            for ($i = 0; $i < sizeof($this->getRequest()->getParam('habilitation')); $i++) {                        
                                                $noHabilitation = 
                                                    $form->getElement('habilitation')->getValue();
                                                $qualifications->set_Employe_Personne_noPersonne(
                                                    $noPersonne);
                                                $qualifications->set_Habilitation_noHabilitation(
                                                    $noHabilitation[$i]);
                                                $qualifications->save();
                                            }                                                                                  
                                        }
                                    }

                                    /*
                                     * Confirme l'ajout de l'employé et redirige
                                     * l'utilisateur vers la page gestpilote
                                     */
                                    echo "<center>Employé ajouté<br />
                                          Redirection en cours...</center>";                               
                                    $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                                } else {
                                    /*
                                     * Confirme l'ajout de la personne et redirige
                                     * l'utilisateur vers la page gestpilote
                                     */
                                    echo '<center>Personne ajoutée
                                         Redirection en cours...</center>';
                                    $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                                }
                            } else {
                                /*
                                 * Réaffiche le formulaire avec les données précédentes
                                 * et affiche une message d'erreur
                                 */                            
                                $form->populate($donneesForm);
                                $this->view->erreurDate = "<center>Attention : 
                                    Date invalide</center>";
                                $this->view->form = $form;                                 
                            }                            
                        } else {
                            /* Confirme que la personne existe déjà et redirige
                             * l'utilisateur vers la page gestpilote
                             */
                            echo "<center>Personne déjà existante<br />
                                  Redirection en cours...</center>";
                            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                        }  
                    }
               } else {
                   /*
                    * Réaffiche le formulaire avec les données saisies et
                    * affiche un message d'erreur
                    */
                   $form->populate($donneesForm);
                   $this->view->erreurMdp = "<center>Attention : les mots de passe
                       ne correspondent pas !</center>";
                   $this->view->form = $form;
               }
            } else {
                /*
                 * Réaffiche le formulaire avec les données précédemment saisies
                 * suite au mauvais format d'un ou plusieurs données
                 */
                $form->populate($donneesForm);
                $this->view->form = $form;
            }
        } else if ($this->getRequest()->getParam('annuler') == 'Annuler') {
                    /*
                     * Redirige l'utilisateur vers la page gestpilote 
                     * en cas d'annulation
                     */
                    $this->_redirect('/ServDRH/gestpilote');
               } else {
                    /*
                     * Affiche le formulaire vierge pour que l'utilisateur puisse
                     * saisir les informations
                     */  
                    $this->view->form = $form;
               }
    }

    /*
     * Permet de mettre à jour un employé
     */
    public function updpiloteAction() {        
        //Vérifie que l'id passé en paramètre est un entier
        if (is_numeric($_GET['id'])) {            
            //Instancie un objet personne
            $personne = new Application_Model_Personne;
            //Récupère les données de la personne dont l'id est donné en paramètre
            $personne = $personne->getPersonneById($_GET['id']);                
            //Vérifie que la personne existe 
            if (!is_null($personne)) {       
                /*
                 * Instancie les objets employe, adresse, qualification et updForm
                 */
                $employe = new ServDRH_Model_Employe;
                $adresse = new Application_Model_Adresse;            
                $qualification = new ServDRH_Model_Qualification;
                $updForm = new ServDRH_Form_gestpilote;

                //Récupère les données de la personne demandée            
                $employe = $employe->getEmployeByPersonneNoPersonne($personne->get_noPersonne());
                $adresse = $adresse->getAdresse($personne->get_noAdresse());
                $qualifications = $qualification->getQualificationsByNoPersonne($_GET['id']);        
                $qualificationsActuelles = array();
                foreach ($qualifications as $qualification) {
                    $qualificationsActuelles[] = $qualification->get_Habilitation_noHabilitation();
                }
                
                //Permet de contrôler la saisie des habilitations
                $erreurHabilitations = false;
                
                //Enregistrement des modifications
                if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
                    if ($this->getRequest()->isPost()) {
                        //Récupèration des données du formulaire
                        $donneesForm = $this->getRequest()->getPost();
                        //Vérifie que le formulaire est valide
                        if ($updForm->isValid($donneesForm)) {
                            /*
                             * Vérifie que le n°INSEE est le même ou 
                             * qu'il n'existe pas en cas de modification
                             */
                            $noINSEE = $personne->get_noINSEE();
                            $personne = $personne->getPersonneByNoInsee(
                                $this->getRequest()->getParam('noINSEE'));                            
                            if (is_null($personne->get_noPersonne()) || 
                               ($this->getRequest()->getParam('noINSEE') == $noINSEE)) {
                                //Vérifie que les mdp sont identiques
                                if ($this->getRequest()->getParam('password') == $this->getRequest()->getParam('passwordConfirm')) {
                                    /*
                                     * Vérifie que les habilitations sont bien saisies 
                                     * pour une pilote
                                     */
                                    if (($this->getRequest()->getParam('labelMetier') != "Pilote") &&
                                       (sizeof($this->getRequest()->getParam('habilitation')) > 0)) {
                                        /*
                                         * Si une ou plusieurs habilitations sont 
                                         * cochées et qu'il ne s'agit pas d'un
                                         * pilote, on affiche l'erreur et réaffiche
                                         * le formulaire avec les données précédentes
                                         */
                                        $updForm->populate($donneesForm);
                                        $this->view->erreurHabilitations = "<p><center>Attention : 
                                            L'employé n'est pas un pilote, il ne peut avoir 
                                            d'habilitation(s) !</center></p>";
                                        $this->view->updForm = $updForm;             
                                        //Empeche de valider le formulaire
                                        $erreurHabilitations = true;
                                    }

                                    /*
                                     * Si les habilitations sont bien saisies et
                                     * qu'il s'agit bien d'un pilote 
                                     * ou qu'aucune habilitation n'est saisie
                                     * 
                                     */
                                    if ($erreurHabilitations == false) {
                                        //Récupère la date de naissance dans le bon format
                                        $jour = $this->getRequest()->getParam('jourNaissance');
                                        $mois = $this->getRequest()->getParam('moisNaissance');
                                        $annee = $this->getRequest()->getParam('anneeNaissance');
                                        $dateNaissance = $annee."-".$mois."-".$jour;

                                        //Vérifie si la date indiquée est valide
                                        if (checkdate($mois, $jour, $annee) == true) {;
                                            //Récupère les données du formulaire                         
                                            $personne->set_noPersonne($_GET['id'])
                                                     ->set_nom($this->getRequest()->getParam('nom'))
                                                     ->set_prenom($this->getRequest()->getParam('prenom'))
                                                     ->set_prenom2($this->getRequest()->getParam('prenom2'))
                                                     ->set_prenom3($this->getRequest()->getParam('prenom3'))
                                                     ->set_dateNaissance($dateNaissance)
                                                     ->set_noINSEE($this->getRequest()->getParam('noINSEE'))
                                                     ->set_noAdresse($adresse->get_noAdresse())
                                                     ->set_email($this->getRequest()->getParam('email'))
                                                     ->set_role($this->getRequest()->getParam('role'))
                                                     ->set_password($this->getRequest()->getParam('password'))
                                                     ->set_password_salt($this->getRequest()->getParam('passwordConfirm'));                    
                                            $adresse->set_numero($this->getRequest()->getParam('numero'))
                                                    ->set_adresse($this->getRequest()->getParam('labelAdresse'))
                                                    ->set_immeuble($this->getRequest()->getParam('immeuble'))
                                                    ->set_etage($this->getRequest()->getParam('etage'))
                                                    ->set_porte($this->getRequest()->getParam('porte'))
                                                    ->set_codepostal($this->getRequest()->getParam('cp'))
                                                    ->set_etatProvince($this->getRequest()->getParam('etatProvince'))
                                                    ->set_labelVille($this->getRequest()->getParam('ville'))
                                                    ->set_labelPays($this->getRequest()->getParam('pays'));
                                            $employe->set_Personne_noPersonne($_GET['id']);
                                            $employe->set_labelMetier($this->getRequest()->getParam('labelMetier'));                    

                                            //Supprime les qualifications déselectionnées s'il y en a
                                            $qualificationsCheck = $this->getRequest()->getParam('habilitation');                    
                                            $nbQualificationsChecked = sizeof(
                                                $this->getRequest()->getParam('habilitation'));
                                            $nbQualificationsPrecedentes = sizeof($qualificationsActuelles);
                                            $nbDelete = 0;
                                            while ($nbDelete < ($nbQualificationsPrecedentes - $nbQualificationsChecked)) {
                                                for ($i = 0; $i < $nbQualificationsPrecedentes; $i++) {
                                                    $existe = false;
                                                    $j = 0;
                                                    while (($existe == false) && ($j < $nbQualificationsChecked)) {
                                                        if ($qualificationsActuelles[$i] == $qualificationsCheck[$j]) {
                                                            $existe = true;
                                                        }
                                                        $j++;                            
                                                    };
                                                    if ($existe == false) {
                                                        $qualification->delete($_GET['id'], $qualificationsActuelles[$i]);
                                                        $nbDelete++;
                                                    }
                                                }
                                            }

                                            //Ajoute les qualifications selectionnées
                                            for ($i = 0; $i < sizeof($this->getRequest()->getParam('habilitation')); $i++) {                        
                                                $noHabilitation = $updForm->getElement('habilitation')->getValue();
                                                $qualification->set_Employe_Personne_noPersonne($_GET['id']);
                                                $qualification->set_Habilitation_noHabilitation($noHabilitation[$i]);
                                                $qualification->save();
                                            }                  

                                            //Sauvegarde les changements de l'employé
                                            $personne->savePersonneById('');
                                            $adresse->addAdresse();
                                            $employe->saveEmploye();

                                            $this->view->update = "<center><p>Modification effectuée</p>
                                                  Redirection en cours...</center>";
                                            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                                        } else {
                                            echo "<p>Date invalide</p>";
                                            $updForm->populate($donneesForm);
                                            $this->view->updForm = $updForm; 
                                        }
                                    }
                                } else {                                
                                    //Remplit le formulaire avec les anciennes données
                                    $updForm->populate($donneesForm);
                                    $this->view->erreurMdp = "<center> Attention : 
                                        Les mots de passe ne correspondent pas !</center>";
                                    $this->view->updForm = $updForm; 
                                }
                            } else {
                                //Remplit le formulaire avec les anciennes données
                                $updForm->populate($donneesForm);
                                $this->view->erreurNoINSEE = "<center> Attention : 
                                    Le n°INSEE a été modifié et existe déjà !</center>";
                                $this->view->updForm = $updForm; 
                            }
                        } else {
                            //Remplit le formulaire avec les anciennes données
                            $updForm->populate($donneesForm);
                            $this->view->updForm = $updForm; 
                        }                        
                    }       
                //Annulation et redirection vers la page gestpilote
                } else if ($this->getRequest()->getParam('annuler') == 'Annuler') {
                    $this->_redirect('/ServDRH/gestpilote');
                //Affichage des données de la personne sélectionnée
                } else {
                    $updForm->getElement('nom')->setValue($personne->get_nom());
                    $updForm->getElement('prenom')->setValue($personne->get_prenom());
                    $updForm->getElement('prenom2')->setValue($personne->get_prenom2());
                    $updForm->getElement('prenom3')->setValue($personne->get_prenom3());

                    //$updForm->getElement('dateNaissance')->setValue($personne->get_dateNaissance());
                    $dateNaissance = $personne->get_dateNaissance();
                    $jour = substr($dateNaissance, 8, 2);
                    $mois = substr($dateNaissance, 5, 2);
                    $annee = substr($dateNaissance, 0, 4);
                    $updForm->getElement('jourNaissance')->setValue($jour);
                    $updForm->getElement('moisNaissance')->setValue($mois);
                    $updForm->getElement('anneeNaissance')->setValue($annee);

                    $updForm->getElement('noINSEE')->setValue($personne->get_noINSEE());
                    $updForm->getElement('numero')->setValue($adresse->get_numero());
                    $updForm->getElement('labelAdresse')->setValue($adresse->get_adresse());
                    $updForm->getElement('immeuble')->setValue($adresse->get_immeuble());
                    $updForm->getElement('etage')->setValue($adresse->get_etage());
                    $updForm->getElement('porte')->setValue($adresse->get_porte());
                    $updForm->getElement('cp')->setValue($adresse->get_codepostal());
                    $updForm->getElement('etatProvince')->setValue($adresse->get_etatProvince());
                    $updForm->getElement('ville')->setValue($adresse->get_labelVille());
                    $updForm->getElement('pays')->setValue($adresse->get_labelPays());
                    $updForm->getElement('email')->setValue($personne->get_email());
                    $updForm->getElement('role')->setValue($personne->get_role()); 
                    $updForm->getElement('habilitation')->setValue($qualificationsActuelles);
                    if ($employe->get_Personne_noPersonne() != null) {
                        $updForm->getElement('labelMetier')->setValue($employe->get_labelMetier());
                    }    

                    if (is_null($this->getRequest()->getParam('enregistrer')) 
                       && (is_null($this->getRequest()->getParam('annuler')))) {
                        $this->view->updForm = $updForm;              
                    } 
                }
            } else {
                echo "<center><p>Personne inexistante</p>
                     <p>Redirection en cours...</p></center>";                
                $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
            }
        } else {
            $this->_redirect('/ServDRH/gestpilote');
        }
    }
    
    /*
     * Permet de supprimer un employé, ses habilitations le cas échéant 
     * Conserve cependant les données de la personne dans la BDD
     */
    public function delpiloteAction() {
        /*
         * Vérifie si l'id passé en paramètre est un entier
         */
        if (isset($_GET['id'])) {
        if (is_numeric($_GET['id'])) {
            //Instancie un objet employe
            $employe = new ServDRH_Model_Employe;                        

            //Vérifie que l'employé associé à l'id passé en paramètre existe 
            $employe = $employe->getEmployeByPersonneNoPersonne($_GET['id']); 
            if (!is_null($employe->get_Personne_noPersonne())) {                
                $this->view->employe = $employe;     
                //Si l'utilsateur valide la suppression
                if (isset($_GET['rep'])) {
                    if ($_GET['rep'] == 'oui') {
                        /*
                         * Si l'employe est un "pilote"
                         * on supprime aussi ses habilitations, s'il y en a
                         */
                        if ($employe->get_labelMetier() == 'Pilote') {
                            //Instancie un objet qualification
                            $qualification = new ServDRH_Model_Qualification;
                            //Récupère les habilitations de l'employé à supprimer
                            $qualifications = $qualification->getQualificationsByNoPersonne($_GET['id']);
                            //Supprime les habilitations de l'employé
                            for ($i=0; $i<sizeof($qualifications); $i++) {
                                $qualifications[$i]->delete($_GET['id'], 
                                    $qualifications[$i]->get_Habilitation_noHabilitation());
                            }
                        }
                        //Supprime l'employé
                        $employe->delEmploye($_GET['id']);
                        /*
                         * Confirme la suppression et redirige l'utilisateur 
                         * vers la page gestpilote
                         */
                        $this->view->delete = "<center><p>Suppression réussie</p>
                            Redirection en cours...</center>";
                        $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                    }
                    /* 
                     * Si l'utilisateur annule la suppression, 
                     * il est redirigé vers la page gestpilote
                     */
                    if ($_GET['rep'] == 'non') {
                        $this->_redirect('/ServDRH/gestpilote');
                    }
                }
            } else {
                /* 
                 * Confirme l'inexistance de l'employé et redirige l'utilisateur
                 * vers la page gestpilote
                 */
                $this->view->erreurEmploye = "<center><p>Employé inexistant</p>
                    Redirection en cours...</center>";
                $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
            }                
        } else {
            /*
             * Confirme la non validité de l'id passé en paramètre et renvoi
             * l'utilisateur vers la page gestpilote
             */
            $this->view->erreurId = "<center><p>L'id de l'employé n'est pas 
                valable</p> Redirection en cours...</center>";
            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
        }
        } else {
            $this->view->erreurGetId = "<center><p>L'id de l'employé est 
                manquant</p> Redirection en cours...</center>";
            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
        }
    }
    
    /*
     * Permet de valider ou non, modifier ou supprimer les demandes de congés des employés
     */
    public function congespiloteAction() {
        //Vérifie si le paramètre id existe et est un entier
        if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            //Récupère l'employé correspondant à l'id passé en paramètre
            $employe = new ServDRH_Model_Employe();
            $employeSelect = $employe->getEmployeByPersonneNoPersonne($_GET['id']);
            //Vérifie si l'employé existe
            if (!is_null($employeSelect->get_Personne_noPersonne())) {
                //Si l'employé existe, on récupère la liste de ses congés
                $conge = new ServDRH_Model_Conge;
                $conges = $conge->getCongesByNoPersonne($_GET['id']);
                //Vérifie si la liste de ses congés est vide ou non
                if (!empty ($conges)) {
                    //Affiche la liste des congés
                    $this->view->conges = $conges;
                    /*
                     * Vérifie si l'utilisateur souhaite valider ou refuser 
                     * une demande de congé dont l'id est passé en paramètre
                     */
                    if (isset($_GET['conge']) && is_numeric($_GET['conge'])) {
                        //Récupère la demande de congé
                        $congeSelect = $conge->getCongeByNoConge($_GET['conge']);
                        //Vérifie si la demande de congé existe
                        if (!is_null($congeSelect)) {
                            if (isset($_GET['action'])) {
                                if ($_GET['action'] == "valid") {
                                    $congeSelect->set_enAttenteDeTraitement(0);
                                    $congeSelect->set_valider(1);
                                    $congeSelect->saveConge();     
                                    $this->_redirect('/ServDRH/gestpilote/congespilote?id='.$_GET['id']);
                                }
                                if ($_GET['action'] == "refus") {
                                    $congeSelect->set_enAttenteDeTraitement(0);
                                    $congeSelect->set_valider(-1);
                                    $congeSelect->saveConge();
                                    $this->_redirect('/ServDRH/gestpilote/congespilote?id='.$_GET['id']);
                                }
                            }
                       } else {
                           $this->view->erreurConge = "<center><p>Congé inexistant</p>
                               Redirection en cours...</center>";
                           $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                       }               
                    } else {
                        $this->view->erreurIdConge = "<center><p>Id congé invalide</p>
                            Redirection en cours...</center>";
                        $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote/congespilote?id='.$_GET['id']);
                    }
                } else {
                    $this->view->aucunConges = "<center><p>Aucun congés pour cet employé</p>
                        Redirection en cours...</center>";
                    $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                }
            } else {
               $this->view->erreurInexistant = "<center><p>Employé inexistant</p>
                   Redirection en cours...</center>";
               $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
            }
        } else {
             $this->view->erreurIdEmploye = "<center><p>Id employé invalide</p>
                   Redirection en cours...</center>";
             $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
        }
    }
    
    /*
     * Permet de mettre à jour une demande de congé
     */
    public function updcongepiloteAction() {     
        //Vérifie que l'id de l'employé et de la demande de congé existent
        if (isset($_GET['id']) && isset($_GET['conge'])) {
            //Vérifie si ce sont des entiers
            if (is_numeric($_GET['id']) && is_numeric($_GET['conge'])) {
                //Récupère la demande de congé et l'employé correspondant pour 
                //vérifier s'ils existent
                $conge = new ServDRH_Model_Conge;
                $employe = new ServDRH_Model_Employe;                
                $congeSelect = $conge->getCongeByNoConge($_GET['conge']);
                $employeSelect = $employe->getEmployeByPersonneNoPersonne($_GET['id']);
                
                //Vérifie qu'ils existent et que la demande correspond à l'employé
                if (!is_null($congeSelect) && 
                   (!is_null($employeSelect) && 
                   $congeSelect->get_noPersonne() == $employeSelect->get_Personne_noPersonne())) {
                    //Initialise le formulaire de modification
                    $updForm = new ServDRH_Form_gestcongepilote;
                    
                    //Récupère les dates de la demande de congé sous forme décomposée
                    $jourDateDebut = substr($congeSelect->get_dateDebut(), 8, 2);
                    $moisDateDebut = substr($congeSelect->get_dateDebut(), 5, 2);
                    $anneeDateDebut = substr($congeSelect->get_dateDebut(), 0, 4);                        
                    $jourDateFin = substr($congeSelect->get_dateFin(), 8, 2);
                    $moisDateFin = substr($congeSelect->get_dateFin(), 5, 2);
                    $anneeDateFin = substr($congeSelect->get_dateFin(), 0, 4);
                    $jourDateDebutAnnee = substr($congeSelect->get_dateDebut_Annee(), 8, 2);
                    $moisDateDebutAnnee = substr($congeSelect->get_dateDebut_Annee(), 5, 2);
                    $anneeDateDebutAnnee = substr($congeSelect->get_dateDebut_Annee(), 0, 4);
                    
                    //Affiche le formulaire avec les données de la BDD
                    if ($this->getRequest()->getParam('enregistrer') != "Enregistrer") {
                        $motif = $congeSelect->get_motif();
                        $valider = $congeSelect->get_valider();
                        $enAttente = $congeSelect->get_enAttenteDeTraitement();
                        $typeConge = $congeSelect->get_labelTypeConge();

                        $updForm->getElement('jourDateDebut')
                                ->setValue($jourDateDebut);
                        $updForm->getElement('moisDateDebut')
                                ->setValue($moisDateDebut);
                        $updForm->getElement('anneeDateDebut')
                                ->setValue($anneeDateDebut);
                        $updForm->getElement('jourDateFin')
                                ->setValue($jourDateFin);
                        $updForm->getElement('moisDateFin')
                                ->setValue($moisDateFin);
                        $updForm->getElement('anneeDateFin')
                                ->setValue($anneeDateFin);
                        $updForm->getElement('valider')
                                ->setValue($valider);
                        $updForm->getElement('enAttente')
                                ->setValue($enAttente);
                        $updForm->getElement('motif')
                                ->setValue($motif);
                        $updForm->getElement('labelTypeConge')
                                ->setValue($typeConge);                
                        $updForm->getElement('jourDateDebutAnnee')
                                ->setValue($jourDateDebutAnnee);
                        $updForm->getElement('moisDateDebutAnnee')
                                ->setValue($moisDateDebutAnnee);
                        $updForm->getElement('anneeDateDebutAnnee')
                                ->setValue($anneeDateDebutAnnee);
                        $this->view->updForm = $updForm;                     
                    }
                    
                    //S'il s'agit d'un modification de la demande de congé
                    if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {                                                                   
                        //Si le formulaire est posté
                        if ($this->getRequest()->isPost()) {
                            //Récupère les données du formulaire posté
                            $donneesForm = $this->getRequest()->getPost();
                            //Vérifie que les données soient valides
                            if ($updForm->isValid($donneesForm)) {  
                                //Vérifie que les dates saisies soient valide
                                if (checkdate($donneesForm['moisDateDebut'], 
                                              $donneesForm['jourDateDebut'], 
                                              $donneesForm['anneeDateDebut']) == true) {
                                    if (checkdate($donneesForm['moisDateFin'], 
                                                  $donneesForm['jourDateFin'], 
                                                  $donneesForm['anneeDateFin']) == true) {
                                        if (checkdate($donneesForm['moisDateDebutAnnee'],
                                                      $donneesForm['jourDateDebutAnnee'],
                                                      $donneesForm['anneeDateDebutAnnee']) == true) {                                    
                                            if ($donneesForm['jourDateDebutAnnee'] == 1 
                                                && $donneesForm['moisDateDebutAnnee'] == 1) {
                                                //Vérifie la bonne saisie de l'état d'une demande avant d'enregistrer
                                                if ((($donneesForm['valider'] == 0) &&
                                                    ($donneesForm['enAttente'] == 1)) ||
                                                    (($donneesForm['valider'] != 0) && 
                                                    ($donneesForm['enAttente']) == 0)) {
                                                    
                                                    //Réformate les dates dans le format de la BDD
                                                    $dateDebut = 
                                                        $donneesForm['anneeDateDebut']."-"
                                                        .$donneesForm['moisDateDebut']."-"
                                                        .$donneesForm['jourDateDebut'];
                                                    $dateFin = 
                                                        $donneesForm['anneeDateFin']."-"
                                                        .$donneesForm['moisDateFin']."-"
                                                        .$donneesForm['jourDateFin'];
                                                    $dateDebutAnnee = 
                                                        $donneesForm['anneeDateDebutAnnee']."-"
                                                        .$donneesForm['moisDateDebutAnnee']."-"
                                                        .$donneesForm['jourDateDebutAnnee'];
                                                    //Récupère les informations du formulaire
                                                    $congeSelect->set_dateDebut($dateDebut);
                                                    $congeSelect->set_dateFin($dateFin);
                                                    $congeSelect->set_valider(
                                                        $this->getRequest()->getParam('valider'));
                                                    $congeSelect->set_enAttenteDeTraitement(
                                                        $this->getRequest()->getParam('enAttente'));
                                                    $congeSelect->set_motif(
                                                        $this->getRequest()->getParam('motif'));
                                                    $congeSelect->set_labelTypeConge(
                                                        $this->getRequest()->getParam('labelTypeConge'));
                                                    $congeSelect->set_dateDebut_Annee($dateDebutAnnee);  
                                                    //Enregistre les modifications
                                                    $congeSelect->saveConge();
                                                    
                                                    //Affiche une confirmation et renvoi l'utilisateur vers la page congespilote
                                                    $this->view->enregistrer = "<center><p>Modification effectuée
                                                        </p>Redirection en cours...</center>";
                                                    $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote/congespilote?id='.$_GET['id']);
                                               } else {
                                                   $this->view->erreurValidation = 
                                                       "<center><p>Attention : La demande
                                                       ne peut être validée ou refusée 
                                                       que si elle est indiquée comme 
                                                       finie.</p></center>";
                                                   $updForm->populate($donneesForm);
                                                   $this->view->updForm = $updForm;
                                               }
                                           } else {
                                                $this->view->erreurDateDebutAnnee = 
                                                    "<center><p>Attention : La date  
                                                    de début d'année doit être du 
                                                    type '01/01/aaaa'</p></center>";
                                                $updForm->populate($donneesForm);
                                                $this->view->updForm = $updForm;
                                           }
                                        } else {
                                            $this->view->erreurDateDebutAnnee = 
                                                "<center><p>Attention : La date de 
                                                début d'année n'est pas valide</p>
                                                </center>";
                                            $updForm->populate($donneesForm);
                                            $this->view->updForm = $updForm;
                                        }
                                    } else {
                                        $this->view->erreurDateFin = 
                                          "<center><p>Attention : La date de 
                                          fin n'est pas valide</p></center>";
                                        $updForm->populate($donneesForm);
                                        $this->view->updForm = $updForm;
                                    }
                                } else {
                                   $this->view->erreurDateDebut = 
                                      "<center><p>Attention : La date de début n'est 
                                      pas valide</p></center>";
                                   $updForm->populate($donneesForm);
                                   $this->view->updForm = $updForm;
                                }
                            } else {
                                $updForm->populate($donneesForm);
                                $this->view->updForm = $updForm;
                            }
                        }
                    }

                    //Si l'utilisateur annule la modification, 
                    //on le renvoi vers la liste des congés de l'employé
                    if ($this->getRequest()->getParam('annuler')) {
                        $this->_redirect('/ServDRH/gestpilote/congespilote?id='.$_GET['id']);
                    }
                } else {
                    //Si la demande de congé et/ou l'id de l'employé sont invalides
                    //on renvoit l'utilisateur vers la liste des pilotes
                    $this->view->erreurInexistant = "<center><p>La demande de 
                        congé n° ".$_GET['conge']." et/ou l'employé n° "
                        .$_GET['id']." n'est pas valide</p> 
                        Redirection en cours...</center>";
                    $this->getResponse()->setHeader(
                        'refresh', 
                        '3,url=/ServDRH/gestpilote');                    
                }
            }
        }        
    }
    
    /*
     * Permet de supprimer une demande de congé
     */
    public function delcongepiloteAction() {
        //Vérifie que l'id de l'employé et de la demande de congé existe
        if (isset($_GET['id']) && isset($_GET['conge'])) {
            //Vérifie que ce sont des entiers
            if (is_numeric($_GET['id']) && is_numeric($_GET['conge'])) {
                //Récupère la demande de congé dont l'id est passé en paramètre
                $conge = new ServDRH_Model_Conge();
                $congeSelect = $conge->getCongeByNoConge($_GET['conge']);
                //Vérifie que la demande de congé existe
                if (!is_null($congeSelect)) {
                    //Vérifie qu'une réponse existe
                    if (isset($_GET['rep'])) {     
                        //Si la réponse est oui, on supprime la demande
                        if ($_GET['rep'] == 'oui') {
                            $congeSelect->delete($_GET['conge']);
                            $this->view->delete = "<center><p>Suppression réussie</p>
                                Redirection en cours...</center>";
                            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                        }
                        //Si la réponse est non, on redirige l'utilisateur vers 
                        //la page congespilote
                        if ($_GET['rep'] == 'non') {
                            $this->_redirect("/ServDRH/gestpilote/congespilote?id=".$_GET['id']);
                        }
                    } else {
                        //Affiche la confirmation pour supprimer la demande de congé
                        $this->view->confirmation = "<center><p>Souhaitez-vous 
                            supprimer la demande de congé n° ".$_GET['conge']." 
                            ?</p></center>";
                    }                    
                }
            } else {
                //Si l'id de l'employé ou de la demande de congé n'est pas valide
                $this->view->erreurId = "<center><p>L'id de l'employé ou du 
                    congé n'est pas valide</p>Redirection en cours...</center>";
                $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
            }
        } else {
            //S'il manque l'un ou les deux id (employé et conge)
            $this->view->erreurGetId = "<center><p>L'id de l'employé ou du 
                    congé est manquant</p>Redirection en cours...</center>";
            $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
        }
    }
}