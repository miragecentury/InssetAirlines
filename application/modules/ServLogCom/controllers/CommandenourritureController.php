<?php

class ServLogCom_CommandenourritureController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->setLfiProtection(false);
        $this->view->render('../../../../views/scripts/user/_sidebar.phtml');
        $this->view->render('../../../../views/scripts/user/_login.phtml');
    }

    public function indexAction()
    {
        $this->view->all = ServLogCom_Model_CommandeNourriture::getListeCommandeNourritureHTML();
    }

    public function newAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $form = new ServLogCom_Form_CommandeNourriture();
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_CommandeNourriture();
            $item->set_dateLivraison($request->getParam('dateLivraison'))
                    ->set_dateCommande($request->getParam('dateCommande'))
                    ->set_idAeroportLivraison($request->getParam('idAeroportLivraison'));
            $item->addCommandeNourriture();
            $this->_redirect('ServLogCom/Commandenourriture');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServLogCom_Model_CommandeNourriture();
            $item = $item->getCommandeNourriture($request->getParam('id'));
            $form = new ServLogCom_Form_CommandeNourriture();
            $form->getElement('dateLivraison')->setValue($item->get_dateLivraison());
            $form->getElement('dateCommande')->setValue($item->get_dateCommande());
            $form->getElement('idAeroportLivraison')->setValue($item->get_idAeroportLivraison());
            $this->view->form = $form;
        } else {
            $item = new ServLogCom_Model_CommandeNourriture();
            $item->set_noCommandeNourriture($request->getParam('id'))
                    ->set_dateLivraison($request->getParam('dateLivraison'))
                    ->set_dateCommande($request->getParam('dateCommande'))
                    ->set_idAeroportLivraison($request->getParam('idAeroportLivraison'));
            $item->addCommandeNourriture();
            $this->_redirect('ServLogCom/Commandenourriture');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServLogCom_Model_CommandeNourriture;
            $Mod->delCommandeNourriture($request->getParam('id'));
            $this->_redirect('ServLogCom/Commandenourriture');
        } else {
            $Mod = new ServLogCom_Model_CommandeNourriture;
            $item = $Mod->getCommandeNourriture($request->getParam('id'));
            $this->view->item = $item->getCommandeNourritureHTML();
            $this->view->id = $request->getParam('id');
        }
    }

    public function detailAction()
    {
        $Mod = new ServLogCom_Model_CommandeNourriture;
        $item = $Mod->getCommandeNourriture($this->getRequest()->getParam('id'));
        $this->view->item = $item->getCommandeNourritureHTML();
        $this->view->id = $this->getRequest()->getParam('id');
    }

}

