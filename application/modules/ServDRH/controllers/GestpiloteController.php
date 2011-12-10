<?php

class ServDRH_GestpiloteController extends Zend_Controller_Action {

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
            $this->_redirect('/redirection/fail');
        }
    }

    public function indexAction() {        
        $employe = new ServDRH_Model_Employe();
        $personne = new Application_Model_Personne();
        $adresse = new Application_Model_Adresse();
        $listePilotes = array();
        $listeMetiers = array();
        $listeAdresses = array();

        $listeEmployes = $employe->getEmployes();        
        foreach ($listeEmployes as $row) {
            $noPersonne = $row->get_Personne_noPersonne();
            $personne = Application_Model_Personne::getPersonneById($noPersonne);            
            $listePilotes[] = $personne;
            $listeMetiers[] = $row->get_labelMetier();
            $listeAdresses[] = $adresse->getAdresse($personne->get_noAdresse());
        }
        $this->view->AllPersonnes = $listePilotes;  
        $this->view->ListeMetiers = $listeMetiers;
        $this->view->ListeAdresses = $listeAdresses;
    }

    public function newpiloteAction() {
        $form = new ServDRH_Form_gestpilote();  
        
        //Enregistrement d'une nouvelle personne et/ou employé
        if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
            $donneesForm = $this->getRequest()->getPost();
            //Si les données sont valides
            if ($form->isValid($donneesForm)) {
                //Si les mdp correspondent
                if ($this->getRequest()->getParam('password') == $this->getRequest()->getParam('passwordConfirm')) {
                    $personne = new Application_Model_Personne;
                    $adresse = new Application_Model_Adresse;
                    $personne = $personne->getPersonneByNoInsee($this->getRequest()->getParam('noINSEE'));                     
                    //Si la personne n'existe pas encore dans la BDD
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
                        //$adresse->set_noPersonne($personne->get_noPersonne());
                        $noAdresse = $adresse->addAdresse();
                        
                        
                        //$adresse = $adresse->getAdresseByNoPersonne($personne->get_noPersonne());
                        
                        //enregiste la personne 
                        $dateNaissance = $this->getRequest()->getParam('dateNaissance');
                        $jour = substr($dateNaissance, 8, 2);
                        $mois = substr($dateNaissance, 6, 2);
                        $annee = substr($dateNaissance,0, 4);
                        if (checkdate($mois, $jour, $annee)) {                        
                            $personne->set_nom($this->getRequest()->getParam('nom'));
                            $personne->set_prenom($this->getRequest()->getParam('prenom'));
                            $personne->set_prenom2($this->getRequest()->getParam('prenom2'));
                            $personne->set_prenom3($this->getRequest()->getParam('prenom3'));
                            //$personne->set_dateNaissance($this->getRequest()->getParam('dateNaissance'));
                            $personne->set_noINSEE($this->getRequest()->getParam('noINSEE'));
                            $personne->set_noAdresse($noAdresse);
                            $personne->set_labelPays($this->getRequest()->getParam('pays'));
                            $personne->set_role($this->getRequest()->getParam('role'));
                            $personne->set_password($this->getRequest()->getParam('password'));
                            $personne->set_password_salt($this->getRequest()->getParam('passwordConfirm'));
                            $personne->set_email($this->getRequest()->getParam('email'));                                       
                            $personne->savePersonneById('');

                            //Récupère la personne que l'on vient d'enregistrer
                            $personne = $personne->getPersonneByNoInsee(
                                $this->getRequest()->getParam('noINSEE'));


                            //Modifie la personne que l'on souhaite ajouter
                            //pour lui affecter l'adresse saisie
                            $personne->set_noAdresse($noAdresse);     
                            $personne->savePersonneById('');

                            //Si la personne est un employé (Pilote, etc.)
                            if ($this->getRequest()->getParam('labelMetier') != ''){
                                //$personne = $personne->getPersonneByNoInsee($this->getRequest()->getParam('noINSEE'));
                                $employe = new ServDRH_Model_Employe;
                                $qualifications = new ServDRH_Model_Qualification;

                                $employe->set_labelMetier($this->getRequest()->getParam('labelMetier'));
                                $employe->set_Personne_noPersonne($personne->get_noPersonne());
                                $employe->saveEmploye();                                                               

                                for ($i = 0; $i < sizeof($this->getRequest()->getParam('habilitation')); $i++) {                        
                                    $noHabilitation = $form->getElement('habilitation')->getValue();
                                    $qualifications->set_Employe_Personne_noPersonne($personne->get_noPersonne());
                                    $qualifications->set_Habilitation_noHabilitation($noHabilitation[$i]);
                                    $qualifications->save();
                                }                                                                                  

                                echo '<center>Employé ajouté</center>';
                                $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                            } else {
                                echo '<center>Personne ajoutée';
                                $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                            }
                        } else {
                            echo "Date invalide";
                            $form->populate($donneesForm);
                            $this->view->form = $form;                                 
                        }                            
                    } else {
                        echo "<center>Personne déjà existante</center>";
                        $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                    }      
               } else {
                   echo "<p align='center'>Les mots de passe ne correspondent pas !</p>";
                   $form->populate($donneesForm);
                   $this->view->form = $form;
               }
            } else {
                $form->populate($donneesForm);
                $this->view->form = $form;
            }
        } else if ($this->getRequest()->getParam('annuler') == 'Annuler') {
            $this->_redirect('/ServDRH/gestpilote');
        } else {
            $this->view->form = $form;
        }
    }

    public function updpiloteAction() {        
        //Si l'id recherché est bien un nombre
        if (is_numeric($_GET['id'])) {            
            $personne = new Application_Model_Personne;
            $personne = $personne->getPersonneById($_GET['id']);
            //Si l'employé recherché existe
            if (!is_null($personne)) {                                
                $employe = new ServDRH_Model_Employe;
                $adresse = new Application_Model_Adresse;            
                $qualification = new ServDRH_Model_Qualification;
                $updForm = new ServDRH_Form_gestpilote();

                //Récupère les données de la BDD             
                $employe = $employe->getEmployeByPersonneNoPersonne($personne->get_noPersonne());
                $adresse = $adresse->getAdresse($personne->get_noAdresse());
                $qualifications = $qualification->getQualificationsByNoPersonne($_GET['id']);        
                $qualificationsActuelles = array();
                foreach ($qualifications as $qualification) {
                    $qualificationsActuelles[] = $qualification->get_Habilitation_noHabilitation();
                }
                
                //Enregistrement des modifications
                if ($this->getRequest()->getParam('enregistrer') == 'Enregistrer') {
                    if ($this->getRequest()->isPost()) {
                        //Si les données sont valides
                        $donneesForm = $this->getRequest()->getPost();
                        if ($updForm->isValid($donneesForm)) {
                            //Si les mdp sont identiques
                            if ($this->getRequest()->getParam('password') == $this->getRequest()->getParam('passwordConfirm')) {
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
                                             //->set_dateNaissance($this->getRequest()->getParam('dateNaissance'))
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

                                    //Sauvegarde les changements dans les tables correspodantes
                                    $personne->savePersonneById('');
                                    $adresse->addAdresse();
                                    $employe->saveEmploye();

                                    echo "<center><p>Modification effectuée</p>
                                          <p>Redirection en cours...</p></center>";
                                    $this->getResponse()->setHeader('refresh', '3,url=/ServDRH/gestpilote');
                                } else {
                                    echo "<p>Date invalide</p>";
                                    $updForm->populate($donneesForm);
                                    $this->view->updForm = $updForm; 
                                }                                
                            } else {
                                echo "<center>Les mots de passe ne correspondent pas !</center>";
                                //Remplit le formulaire avec les anciennes données
                                $updForm->populate($donneesForm);
                                $this->view->updForm = $updForm; 
                            }
                        } else {
                            //echo "<center>Formulaire non valide</center>";
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

    public function delpiloteAction() {
        if (is_numeric($_GET['id'])) {
            $employe = new ServDRH_Model_Employe;

            $employe = $employe->getEmployeByPersonneNoPersonne($_GET['id']); 
            $this->view->employe = $employe;
            if (isset($_GET['rep'])) {
                if ($_GET['rep'] == 'oui') {                
                    $employe->delEmploye($_GET['id']);
                    $this->_redirect('/ServDRH/gestpilote');
                }
                if ($_GET['rep'] == 'non') {
                    $this->_redirect('/ServDRH/gestpilote');
                }
            }        
        } else {
            $this->_redirect('/ServDRH/gestpilote');
        }
    }
    
    public function congespiloteAction() {
        if ((isset($_GET['conge'])) && ($_GET['conge'] != '')) {
            $conge = new ServDRH_Model_Conge;
            $conge = $conge->getCongeByNoConge($_GET['conge']);                
            $conge->set_enAttentedeTraitement('0');
            $conge->set_valider('1');                
            $conge->saveConge();                
        }        
    }
}