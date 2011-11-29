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
        try {
            $all = ServCommercial_Model_Agence::getListeAgenceHTML(false);
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AgenceController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le 
                formulaire de contact.<br/>";
    }

    public function adminAction()
    {
        try {
            $all = ServCommercial_Model_Agence::getListeAgenceHTML();
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AgenceController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($all != null)
            $this->view->all = $all;
        else
            $this->view->all = "Erreur dans la base de donnée, 
                veuillez contacter l'administrateur du site via le 
                formulaire de contact.<br/>";
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
            if ($request->getParam('dateCloture') != null)
                $item->set_dateCloture($request->getParam('dateCloture'));
            try {
                $item->addAgence();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AgenceController : new : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Agence/admin');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_Agence();
            try {
                $item = $item->getAgence($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AgenceController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $form = new ServCommercial_Form_Agence();
            if ($item != null) {
                $form->getElement('labelAgence')->setValue($item->get_labelAgence());
                $form->getElement('dateLancement')->setValue($item->get_dateLancement());
                $form->getElement('dateCloture')->setValue($item->get_dateCloture());
                $form->getElement('accesExtranet')->setValue($item->get_accesExtranet());
                $form->getElement('noAdresse')->setValue($item->get_noAdresse());
            }
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Agence();
            $item->set_noAgence($request->getParam('id'))
                    ->set_labelAgence($request->getParam('labelAgence'))
                    ->set_dateLancement($request->getParam('dateLancement'))
                    ->set_accesExtranet($request->getParam('accesExtranet'))
                    ->set_noAdresse($request->getParam('noAdresse'));
            if ($request->getParam('dateCloture') != null)
                $item->set_dateCloture($request->getParam('dateCloture'));
            try {
                $item->addAgence();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AgenceController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Agence');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_Agence();
            try {
                $Mod->delAgence($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AgenceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Agence/admin');
        } else {
            $Mod = new ServCommercial_Model_Agence();
            try {
                $item = $Mod->getAgence($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('AgenceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            if ($item != null) {
                $this->view->item = $item->getAgenceHTML();
            } else {
                $this->view->item = "Cette Agence n'existe pas dans la base de donnée!<br/>";
            }
            $this->view->id = $request->getParam('id');
        }
    }

    public function detailAction()
    {
        $Mod = new ServCommercial_Model_Agence;
        try {
            $item = $Mod->getAgence($this->getRequest()->getParam('id'));
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('AgenceController : detail : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($item != null) {
            $this->view->item = $item->getAgenceHTML();
        } else {
            $this->view->item = "Cette Agence n'existe pas dans la base de donnée!<br/>";
        }
        $this->view->id = $this->getRequest()->getParam('id');
    }

}