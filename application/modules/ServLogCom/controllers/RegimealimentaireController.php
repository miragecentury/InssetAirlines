<?php

class ServLogCom_RegimealimentaireController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaireHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServLogCom_Form_RegimeAlimentaire();
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_RegimeAlimentaire();
            $item->set_labelRegimeAlimentaire($request->getParam('labelRegimeAlimentaire'));
            $item->addRegimeAlimentaire();
            $this->_redirect('ServLogCom/Regimealimentaire');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServLogCom_Model_RegimeAlimentaire();
            $item = $item->getRegimeAlimentaire($request->getParam('id'));
            $form = new ServLogCom_Form_RegimeAlimentaire();
            $form->getElement('labelRegimeAlimentaire')->setValue($item->get_labelRegimeAlimentaire());
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_RegimeAlimentaire();
            $item->set_noRegimeAlimentaire($request->getParam('id'))
                    ->set_labelRegimeAlimentaire($request->getParam('labelRegimeAlimentaire'));
            $item->addRegimeAlimentaire();
            $this->_redirect('ServLogCom/Regimealimentaire');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServLogCom_Model_RegimeAlimentaire;
            $Mod->delRegimeAlimentaire($request->getParam('id'));
            $this->_redirect('ServLogCom/Regimealimentaire');
        } else {
            $Mod = new ServLogCom_Model_RegimeAlimentaire;
            $item = $Mod->getRegimeAlimentaire($request->getParam('id'));
            $this->view->item = $item->getRegimeAlimentaireHTML();
            $this->view->id = $request->getParam('id');
        }
    }

}

