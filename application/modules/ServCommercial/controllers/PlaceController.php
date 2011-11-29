<?php

class ServCommercial_PlaceController extends Zend_Controller_Action
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
            $all = ServCommercial_Model_Place::getListePlaceHTML(false);
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('PlaceController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
            $all = ServCommercial_Model_Place::getListePlaceHTML();
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('PlaceController : index : Acces a la base de donnée impossible', Zend_Log::ALERT);
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
            $form = new ServCommercial_Form_Place();
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Place();
            $item->set_noVol($request->getParam('noVol'))
                    ->set_noAgence($request->getParam('noAgence'))
                    ->set_Personne_noPersonne($request->getParam('noPersonne'));
            try {
                $item->addPlace();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('PlaceController : new : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Place/admin');
        }
    }

    public function updAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('submit') != "Valider") {
            $item = new ServCommercial_Model_Place();
            try {
                $item = $item->getPlace($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('PlaceController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $form = new ServCommercial_Form_Place();
            if ($item != null) {
                $form->getElement('noVol')->setValue($item->get_noVol());
                $form->getElement('noAgence')->setValue($item->get_noAgence());
                $form->getElement('noPersonne')->setValue($item->get_Personne_noPersonne());
            }
            $this->view->form = $form;
        } else {
            $item = new ServCommercial_Model_Place();
            $item->set_noPlace($request->getParam('id'))
                    ->set_noVol($request->getParam('noVol'))
                    ->set_noAgence($request->getParam('noAgence'))
                    ->set_Personne_noPersonne($request->getParam('noPersonne'));
            try {
                $item->addPlace();
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('PlaceController : upd : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Place/admin');
        }
    }

    public function delAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('ok') === "ok") {
            $Mod = new ServCommercial_Model_Place();
            try {
                $Mod->delPlace($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('PlaceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            $this->_redirect('ServCommercial/Place/admin');
        } else {
            $Mod = new ServCommercial_Model_Place();
            try {
                $item = $Mod->getPlace($request->getParam('id'));
            } catch (Zend_Exception $e) {
                Zend_Registry::get('Log')->log('PlaceController : del : Acces a la base de donnée impossible', Zend_Log::ALERT);
                return FALSE;
            }
            if ($item != null) {
                $this->view->item = $item->getPlaceHTML();
            } else {
                $this->view->item = "Cette Place n'existe pas dans la base de donnée!<br/>";
            }
            $this->view->id = $request->getParam('id');
        }
    }

    public function detailAction()
    {
        $Mod = new ServCommercial_Model_Place();
        try {
            $item = $Mod->getPlace($this->getRequest()->getParam('id'));
        } catch (Zend_Exception $e) {
            Zend_Registry::get('Log')->log('PlaceController : detail : Acces a la base de donnée impossible', Zend_Log::ALERT);
            return FALSE;
        }
        if ($item != null) {
            $this->view->item = $item->getPlaceHTML();
        } else {
            $this->view->item = "Cette Place n'existe pas dans la base de donnée!<br/>";
        }
        $this->view->id = $this->getRequest()->getParam('id');
    }

}