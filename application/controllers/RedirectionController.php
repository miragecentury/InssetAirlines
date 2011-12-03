<?php

/**
 * Module d'affichage des message de succes et d'echec
 * fonctionne grace à 2 variables stockées dans la session
 * (namespace Redirect)
 * -> message affiche le message
 * -> redirection donne le chemin de redirection
 *
 * @author pewho
 */
class RedirectionController extends Zend_Controller_Action
{

    protected $_redirection;
    protected $_message;
    protected $_session;

    public function init()
    {
        $this->view->render('user/_sidebar.phtml');
        $this->view->render('user/_utilisateurSidebar.phtml');
        $this->view->render('user/_login.phtml');
        //recupération de la session
        $this->_session = $this->_getSession();
    }

    public function successAction()
    {
        //redirection automatique au bout de 3 secondes
        if ($this->_session) {
            $this->view->success = $this->_message;
            $this->getResponse()->setHeader('refresh', '3,url=' . $this->_redirection);
        } else {
            $this->view->success = 'Succes !';
            $this->getResponse()->setHeader('refresh', '3,url=/');
        }
    }

    public function failAction()
    {
        //redirection automatique au bout de 3 secondes
        if ($this->_session) {
            $this->view->fail = $this->_message;
            $this->getResponse()->setHeader('refresh', '3,url=' . $this->_redirection);
        } else {
            $this->view->fail = 'Succes !';
            $this->getResponse()->setHeader('refresh', '3,url=/');
        }
    }

    protected function _getSession()
    {
        $session = new Zend_Session_Namespace('Redirect');
        if (!empty($session->message) && isset($session->message)
            && !empty($session->redirection) && isset($session->redirection)) {
            $this->_redirection = $session->redirection;
            $this->_message = $session->message;
            $this->_unloadSession();
            return true;
        } else {
            $this->_unloadSession();
            return false;
        }
    }
    protected function _unloadSession(){
        $session = new Zend_Session_Namespace('Redirect');
        unset($session);
    }
}

?>
