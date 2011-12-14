<?php

class ServLogCom_RegimealimentaireController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServLogCommandeSidebar.phtml');
        $this->view->render('sidebar/_homeServLogMenuSidebar.phtml');
        $this->view->render('sidebar/_homeServLogRegimeSidebar.phtml');
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
        $this->view->all = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaire();
    }

    public function adminAction()
    {
        $this->view->all = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaire();
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
    }

    public function newAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $form = new ServLogCom_Form_RegimeAlimentaire();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_RegimeAlimentaire();
            $item->set_labelRegimeAlimentaire($form->getValue('labelRegimeAlimentaire'));
            $id = $item->addRegimeAlimentaire();
            if ($form->getValue('LstMenu') != null) {
                $incompatible = new ServLogCom_Model_Incompatible;
                foreach ($form->getValue('LstMenu') as $val) {
                    $incompatible->set_idMenu($val);
                    $incompatible->set_idRegimeAlimentaire($id);
                    $incompatible->add();
                }
            }
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout d'un regime alimentaire réussi.";
            $session->redirection = "/ServLogCom/Regimealimentaire/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function updAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $tab = array();
        $incompatible = new ServLogCom_Model_Incompatible;
        $incompatible = $incompatible->getbyRegime($this->getRequest()->getParam('id'));
        if ($incompatible != null) {
            foreach ($incompatible as $val) {
                $tab[] = $val->get_idMenu();
            }
        }
        $form = new ServLogCom_Form_RegimeAlimentaire();
        $item = new ServLogCom_Model_RegimeAlimentaire();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getRegimeAlimentaire($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('labelRegimeAlimentaire')->setValue($item->get_labelRegimeAlimentaire());
                $form->getElement('LstMenu')->setValue($tab);
            }
            $this->view->form = $form;
        } else {
            $item->set_noRegimeAlimentaire($this->getRequest()->getParam('id'))
                    ->set_labelRegimeAlimentaire($this->getRequest()->getParam('labelRegimeAlimentaire'));
            $tab2 = $form->getElement('LstMenu')->getValue();
            // a creer
            $tabcreate = array_diff($tab2, $tab);
            $incompatible = new ServLogCom_Model_Incompatible;
            foreach ($tabcreate as $val) {
                $incompatible->set_idMenu($val);
                $incompatible->set_idRegimeAlimentaire($this->getRequest()->getParam('id'));
                $incompatible->add();
            }

            // a delete
            $tabdelete = array_diff($tab, $tab2);
            $incompatible = new ServLogCom_Model_Incompatible;
            foreach ($tabdelete as $val) {
                // trouver grace a $this->getRequest()->getParam('id') => id du Menu et $val => id du Regime Alim
                $tabe = $incompatible->getbyMenuAndRegime($val, $this->getRequest()->getParam('id'));
                // Delete
                $incompatible->del($tabe[0]->get_id());
            }
            //Ajout du menu
            $item->addRegimeAlimentaire();

            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Regimealimentaire/admin";
            $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
        }
    }

    public function delAction()
    {
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_RegimeAlimentaire;
        $item = $mod->getRegimeAlimentaire($this->getRequest()->getParam('id'));
        $session = new Zend_Session_Namespace('Redirect');
        $session->redirection = "/ServLogCom/Regimealimentaire/admin";
        if ($this->getRequest()->getParam('ok') === "ok") {
            if ($item != null) {
                $mod->delRegimeAlimentaire($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect(Zend_Registry::get('BaseUrl') . '/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('RegimeAlimentaireController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
        $this->view->render('sidebar/_homeServLogRegimeAdminSidebar.phtml');
        $mod = new ServLogCom_Model_RegimeAlimentaire;
        $this->view->item = $mod->getRegimeAlimentaire($this->getRequest()->getParam('id'));
        $this->view->id = $this->getRequest()->getParam('id');

        $incompatible = ServLogCom_Model_Incompatible::getbyRegime($this->getRequest()->getParam('id'));
        $menu = new ServLogCom_Model_Menu;
        if ($incompatible != null) {
            $this->view->tab = array();
            foreach ($incompatible as $val) {
                $this->view->tab[] = $menu->getMenu($val->get_idMenu())->get_labelMenu();
            }
        }
    }

}

