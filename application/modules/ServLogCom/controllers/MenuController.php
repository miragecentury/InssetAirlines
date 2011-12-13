<?php

class ServLogCom_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServLogCommandeSidebar.phtml');
        $this->view->render('sidebar/_homeServLogMenuSidebar.phtml');
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
        $this->view->all = ServLogCom_Model_Menu::getListeMenu();
    }

    public function adminAction()
    {
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        $this->view->all = ServLogCom_Model_Menu::getListeMenu();
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        $form = new ServLogCom_Form_Menu;
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_Menu;
            $item->set_labelMenu($form->getValue('labelMenu'));
            $id = $item->addMenu();
            // Ajout des regime alimentaire pour chaque menu en base de donnée
            if ($form->getValue('regime') != null) {
                $incompatible = new ServLogCom_Model_Incompatible;
                foreach ($form->getValue('regime') as $val) {
                    $incompatible->set_idMenu($id);
                    $incompatible->set_idRegimeAlimentaire($val);
                    $incompatible->add();
                }
            }
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout du menu réussi.";
            $session->redirection = "/ServLogCom/Menu/admin";
            //$this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function updAction()
    {
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        // Récupération de tout les incompatible déja présent pour cette id de Menu
        $tab = array();
        $incompatible = new ServLogCom_Model_Incompatible;
        $incompatible = $incompatible->getbyMenu($this->getRequest()->getParam('id'));
        if ($incompatible != null) {
            foreach ($incompatible as $val) {
                $tab[] = $val->get_idRegimeAlimentaire();
            }
        }
        $form = new ServLogCom_Form_Menu();
        $item = new ServLogCom_Model_Menu();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getMenu($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('labelMenu')->setValue($item->get_labelMenu());
                $form->getElement('regime')->setValue($tab);
            }
            $this->view->form = $form;
        } else {
            $item->set_idMenu($this->getRequest()->getParam('id'))
                    ->set_labelMenu($this->getRequest()->getParam('labelMenu'));
            $item->addMenu();
            $tab2 = $form->getElement('regime')->getValue();
            // a creer
            $tabcreate = array_diff($tab2, $tab);
            $incompatible = new ServLogCom_Model_Incompatible;
            foreach ($tabcreate as $val) {
                $incompatible->set_idMenu($this->getRequest()->getParam('id'));
                $incompatible->set_idRegimeAlimentaire($val);
                $incompatible->add();
            }

            // a delete
            $tabdelete = array_diff($tab, $tab2);
            $incompatible = new ServLogCom_Model_Incompatible;
            foreach ($tabdelete as $val) {
                // trouver grace a $this->getRequest()->getParam('id') => id du Menu et $val => id du Regime Alim
                $tabe = $incompatible->getbyMenuAndRegime($this->getRequest()->getParam('id'), $val);
                // Delete
                $incompatible->del($tabe[0]->get_id());
            }

            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Menu/admin";

            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        $mod = new ServLogCom_Model_Menu;
        $item = $mod->getMenu($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServLogCom/Menu/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $mod->delMenu($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('MenuController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        $mod = new ServLogCom_Model_Menu;


        $this->view->item = $mod->getMenu($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');

        $regime = new ServLogCom_Model_RegimeAlimentaire;
        $incompatible = ServLogCom_Model_Incompatible::getbyMenu($this->getRequest()->getParam('id'));
        if ($incompatible != null) {
            $this->view->tab = array();
            foreach ($incompatible as $val) {
                $this->view->tab[] = $regime->getRegimeAlimentaire($val->get_idRegimeAlimentaire())->get_labelRegimeAlimentaire();
            }
        }
    }

}

