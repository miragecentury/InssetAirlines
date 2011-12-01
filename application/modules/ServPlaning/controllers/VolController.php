<?php

class ServPlaning_VolController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServPlaning_Model_Vol::getListeVolHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServPlaning_Form_Vol();
            $this->view->form = $form;
        } else {
            $item = new ServPlaning_Model_Vol();
            $item->set_labelvol($request->getParam('labelvol'))
                    ->set_labelAeroportDeco($request->getParam('labelAeroportDeco'))
                    ->set_labelAeroportAtte($request->getParam('labelAeroportAtte'))
                    ->set_noAvion($request->getParam('noAvion'))
                    ->set_noLigne($request->getParam('noLigne'))
                    ->set_heuredecollage($request->getParam('heuredecollage'))
                    ->set_heureAtterissage($request->getParam('heureAtterissage'));
            ;
            $item->addVol();
            $this->_redirect('ServPlaning/Vol');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServPlaning_Model_Vol();
            $item = $item->getVol($request->getParam('id'));
            $form = new ServPlaning_Form_Vol();
            $form->getElement('labelvol')->setValue($item->get_labelvol());
            $form->getElement('labelAeroportDeco')->setValue($item->get_labelAeroportDeco());
            $form->getElement('labelAeroportAtte')->setValue($item->get_labelAeroportAtte());
            $form->getElement('noAvion')->setValue($item->get_noAvion());
            $form->getElement('noLigne')->setValue($item->get_noLigne());
            $form->getElement('heuredecollage')->setValue($item->get_heuredecollage());
            $form->getElement('heureAtterissage')->setValue($item->get_heureAtterissage());
            $this->view->form = $form;
        } else {
            $item = new ServPlaning_Model_Vol();
            $item->set_noVol($request->getParam('id'))
                    ->set_labelvol($request->getParam('labelvol'))
                    ->set_labelAeroportDeco($request->getParam('labelAeroportDeco'))
                    ->set_labelAeroportAtte($request->getParam('labelAeroportAtte'))
                    ->set_noAvion($request->getParam('noAvion'))
                    ->set_noLigne($request->getParam('noLigne'))
                    ->set_heuredecollage($request->getParam('heuredecollage'))
                    ->set_heureAtterissage($request->getParam('heureAtterissage'));
            $item->addVol();
            $this->_redirect('ServPlaning/Vol');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServPlaning_Model_Vol;
            $Mod->delVol($request->getParam('id'));
            $this->_redirect('ServPlaning/Vol');
        } else {
            $Mod = new ServPlaning_Model_Vol;
            $item = $Mod->getVol($request->getParam('id'));
            $this->view->item = $item->getVolHTML();
            $this->view->id = $request->getParam('id');
        }
    }

}

