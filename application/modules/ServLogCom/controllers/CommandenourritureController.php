<?php

class ServLogCom_CommandenourritureController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServLogCommandeSidebar.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Log')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/fail');
        }
    }

    public function indexAction()
    {
        $this->view->all = ServLogCom_Model_CommandeNourriture::getListeCommandeNourriture();
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServLogCommandeAdminSidebar.phtml');
        $form = new ServLogCom_Form_CommandeNourriture();
        if (empty($_POST) || !$form->isValid($_POST)) {
           $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_CommandeNourriture();
            $item->set_dateLivraison($this->getRequest()->getParam('dateLivraison'))
                    ->set_dateCommande($this->getRequest()->getParam('dateCommande'))
                    ->set_idAeroportLivraison($this->getRequest()->getParam('idAeroportLivraison'));
            $id = $item->addCommandeNourriture();
            //Ajout des menu pour chaque commande en base de donnée
            if ($form->getValue('lstmenu') != null) {
                $estcommande = new ServLogCom_Model_EstCommande;
                foreach ($form->getValue('lstmenu') as $val) {
                    $estcommande->set_idMenu($val);
                    $estcommande->set_noCommandeNourriture($id);
                    $estcommande->add();
                }
            }
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout de la commande réussi.";
            $session->redirection = "/ServLogCom/Commandenourriture/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function updAction()
    {
        //Menu top
        $this->view->render('sidebar/_homeServLogCommandeAdminSidebar.phtml');
        // Récupération de tout les estcommande déja présent pour cette id de Commande
        // Tableau de stockage des menus déja dans la base pour cette commande
        $tab = array();
        $estcommande = new ServLogCom_Model_EstCommande;
        $items = $estcommande->getbyCommande($this->getRequest()->getParam('id'));
        if ($items != null) {
            foreach ($items as $val) {
                $tab[] = $val->get_idMenu();
            }
        }
        //Initialisation du formulaire commande nourriture et remplissage auto
        $form = new ServLogCom_Form_CommandeNourriture();
        $item = new ServLogCom_Model_CommandeNourriture();
        // Si premiere page (pas d'info en post pour enregistre et zapé
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getCommandeNourriture($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('dateLivraison')->setValue($item->get_dateLivraison());
                $form->getElement('dateCommande')->setValue($item->get_dateCommande());
                $form->getElement('idAeroportLivraison')->setValue($item->get_idAeroportLivraison());
                $form->getElement('lstmenu')->setValue($tab);
            }
            $this->view->form = $form;
            //Si seconde page
        } else {
            // Creation d'un item a partir des info récuperer dans le form (requete)
            $item->set_noCommandeNourriture($this->getRequest()->getParam('id'))
                    ->set_dateLivraison($this->getRequest()->getParam('dateLivraison'))
                    ->set_dateCommande($this->getRequest()->getParam('dateCommande'))
                    ->set_idAeroportLivraison($this->getRequest()->getParam('idAeroportLivraison'));
            $item->addCommandeNourriture();
            // Creation d'un second tableau stockant la nouvelles selection de Menu
            $tab2 = $form->getElement('lstmenu')->getValue();
            // Separation entre les deux tableau précédent de ce qui est a ajouter dans la base de donnée et a delete
            $tabcreate = array_diff($tab2,$tab);
            $tabdelete = array_diff($tab,$tab2);
            //Create
            $itemadd = new ServLogCom_Model_EstCommande;
            foreach ($tabcreate as $val) {
                $itemadd->set_noCommandeNourriture($this->getRequest()->getParam('id'));
                $itemadd->set_idMenu($val);
                $itemadd->add();
            }
            //Delete
            $moddel = new ServLogCom_Model_EstCommande;
            foreach ($tabdelete as $val) {
                // trouver grace a $this->getRequest()->getParam('id') => id du Menu et $val => id du Regime Alim
                $itemdel = $estcommande->getbyMenuAndCommande($val,$this->getRequest()->getParam('id'));
                // Delete
                $moddel->del($itemdel[0]->get_id());
            }


            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Commandenourriture/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServLogCommandeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_CommandeNourriture;
        $item = $mod->getCommandeNourriture($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServLogCom/Commandenourriture/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if($item != null) {
                $mod->delCommandeNourriture($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('CommandenourritureController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                $session->message = "Echec de supression.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/fail');
            }
        } else {
            $this->view->item = $item;
            $this->view->id = $this->getRequest()->getParam('id');
        }
    }

    public function detailAction()
    {
        $this->view->render('sidebar/_homeServLogCommandeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_CommandeNourriture;
        $this->view->item = $mod->getCommandeNourriture($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');

        $menu = new ServLogCom_Model_Menu;
        $estcommande = ServLogCom_Model_EstCommande::getbyCommande($this->getRequest()->getParam('id'));
        if ($estcommande != null) {
            $this->view->tab = array();
            foreach ($estcommande as $val) {
                $this->view->tab[] = $menu->getMenu($val->get_idMenu())->get_labelMenu();
            }
        }
    }

    public function adminAction()
    {
        $this->view->all = ServLogCom_Model_CommandeNourriture::getListeCommandeNourriture();
        $this->view->render('sidebar/_homeServLogCommandeAdminSidebar.phtml');
    }
}

