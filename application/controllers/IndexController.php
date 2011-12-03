<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        $this->view->render('user/_frontSidebar.phtml');
        $this->view->render('user/_login.phtml');
        $this->_helper->layout->setLayout('front');
    }

    public function indexAction() {
        //Spesx_Log::LogALERT('test');
    }

    public function patternAction() {
        
    }

    public function contactAction() {
        $request = $this->getRequest();
        $alnum = new Zend_Validate_Alnum();
        $mail = new Zend_Validate_EmailAddress();

        $contactForm = new Application_Form_Index_Contact($_POST);
        $this->view->contactForm = $contactForm;
        if (isset($_POST) && !empty($_POST)) {
            if ($contactForm->isValid($_POST)) {
                if (!$alnum->isValid($request->getParam('nom'))) {
                    $this->view->messageError = $alnum->getMessages();
                } else if (!$mail->isValid($request->getParam('mail'))) {
                    $this->view->messageError = $mail->getMessages();
                } else if (!$alnum->isValid($request->getParam('sujet'))) {
                    $this->view->messageError = $alnum->getMessages();
                } else {
                    try {
                        $fichierContact = fopen('../data/contact.txt', 'a+');
                        fputs($fichierContact, "Nom : " . $request->getParam('nom') . "\n");
                        fputs($fichierContact, "Mail : " . $request->getParam('mail') . "\n");
                        fputs($fichierContact, "Sujet : " . $request->getParam('sujet') . "\n");
                        fputs($fichierContact, "Contenue : " . $request->getParam('contenue') . "\n\n");
                        fclose($fichierContact);
                    } catch (Exception $e) {
                        Zend_Registry::get('Log')->log('IndexController : contactAction : Impossible d\'ecrire dans le fichier de contact.', Zend_Log::ALERT);
                    }
                }
            }
            
           
        }
    }

}