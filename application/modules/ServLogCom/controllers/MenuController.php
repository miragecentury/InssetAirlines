<?php

class ServLogCom_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServLogCom_Model_Menu::getListeMenuHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServLogCom_Form_Menu();
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_Menu();
            $item->set_labelMenu($request->getParam('labelMenu'));
            $item->addMenu();
            $this->_redirect('ServLogCom/Menu');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServLogCom_Model_Menu();
            $item = $item->getMenu($request->getParam('id'));
            $form = new ServLogCom_Form_Menu();
            $form->getElement('labelMenu')->setValue($item->get_labelMenu());
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_Menu();
            $item->set_idMenu($request->getParam('id'))
                    ->set_labelMenu($request->getParam('labelMenu'));
            $item->addMenu();
            $this->_redirect('ServLogCom/Menu');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServLogCom_Model_Menu;
            $Mod->delMenu($request->getParam('id'));
            $this->_redirect('ServLogCom/Menu');
        } else {
            $Mod = new ServLogCom_Model_Menu;
            $item = $Mod->getMenu($request->getParam('id'));
            $this->view->item = $item->getMenuHTML();
            $this->view->id = $request->getParam('id');
        }
    }

}

