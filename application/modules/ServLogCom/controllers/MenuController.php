<?php

class ServLogCom_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
        $this->view->render('sidebar/_homeServLogSidebar.phtml');
        $this->view->render('sidebar/_homeServLogMenuSidebar.phtml');
        $this->_acl = Zend_Registry::get('Acl');
        //ACL
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        if (!$this->_acl->isAllowed($authSession->role, 'Mod_Serv_Log')) {
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Vous n'avez pas les droits pour acceder à ce service";
            $session->redirection = "/";
            $this->_redirect('/redirection/fail');
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
            $item->addMenu();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Ajout du menu réussi.";
            $session->redirection = "/ServLogCom/Menu/admin";
            $this->_redirect('/redirection/success');
        }
    }

    public function updAction()
    {
        $this->view->render('sidebar/_homeServLogMenuAdminSidebar.phtml');
        $form = new ServLogCom_Form_Menu();
        $item = new ServLogCom_Model_Menu();
        if (empty($_POST) || !$form->isValid($_POST)) {
            $item = $item->getMenu($this->getRequest()->getParam('id'));
            if ($item != null) {
                $form->getElement('labelMenu')->setValue($item->get_labelMenu());
            }
            $this->view->form = $form;
        } else {
            $item->set_idMenu($this->getRequest()->getParam('id'))
                    ->set_labelMenu($this->getRequest()->getParam('labelMenu'));
            $item->addMenu();
            $session = new Zend_Session_Namespace('Redirect');
            $session->message = "Modification réussi.";
            $session->redirection = "/ServLogCom/Menu/admin";
            $this->_redirect('/redirection/success');
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
            if($item != null) {
                $mod->delMenu($this->getRequest()->getParam('id'));
                $session->message = "Supression réussi.";
                $this->_redirect('/redirection/success');
            } else {
                Zend_Registry::get('Log')->log('MenuController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                $session->message = "Echec de supression.";
                $this->_redirect('/redirection/fail');
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
    }
}

