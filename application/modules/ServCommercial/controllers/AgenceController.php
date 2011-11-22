<?php

class ServCommercial_AgenceController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServCommercial_Model_Agence::getListeAgenceHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServCommercial_Form_Agence();
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Agence();
            $item->set_labelAgence($request->getParam('labelAgence'))
                    ->set_dateLancement($request->getParam('dateLancement'))
                    ->set_accesExtranet($request->getParam('accesExtranet'))
                    ->set_noAdresse($request->getParam('noAdresse'));
            if($request->getParam('dateCloture')!=null)
                $item->set_dateCloture($request->getParam('dateCloture'));
            $item->addAgence();
            $this->_redirect('ServCommercial/Agence');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_Agence();
            $item = $item->getAgence($request->getParam('id'));
            $form = new ServCommercial_Form_Agence();
            $form->getElement('labelAgence')->setValue($item->get_labelAgence());
            $form->getElement('dateLancement')->setValue($item->get_dateLancement());
            $form->getElement('dateCloture')->setValue($item->get_dateCloture());
            $form->getElement('accesExtranet')->setValue($item->get_accesExtranet());
            $form->getElement('noAdresse')->setValue($item->get_noAdresse());
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Agence();
            $item->set_noAgence($request->getParam('id'))
                    ->set_labelAgence($request->getParam('labelAgence'))
                    ->set_dateLancement($request->getParam('dateLancement'))
                    ->set_accesExtranet($request->getParam('accesExtranet'))
                    ->set_noAdresse($request->getParam('noAdresse'));
            if($request->getParam('dateCloture')!=null)
                $item->set_dateCloture($request->getParam('dateCloture'));
            $item->addAgence();
            $this->_redirect('ServCommercial/Agence');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_Agence();
            $Mod->delAgence($request->getParam('id'));
            $this->_redirect('ServCommercial/Agence');
        } else {
            $Mod = new ServCommercial_Model_Agence();
            $item = $Mod->getAgence($request->getParam('id'));
            $this->view->item = $item->getAgenceHTML();
            $this->view->id = $request->getParam('id');
        }
    }

}