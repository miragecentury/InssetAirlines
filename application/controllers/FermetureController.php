<?php

class FermetureController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->view->render(Zend_Registry::get('BaseUrl') . 'user/_frontSidebar.phtml');
        $this->view->render(Zend_Registry::get('BaseUrl') . 'user/_login.phtml');
        $this->_helper->layout->setLayout('front');
    }

    public function indexAction()
    {
        Zend_Registry::get('Log')->log("test",ZEND_LOG::ALERT);
    }


}

