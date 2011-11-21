<?php

/**
 * Description of Application_Form_Auth_Login
 * 
 * Formulaire simple de login, utilisé par défaut
 *
 * @author pewho
 */
class Application_Form_Index_Contact extends Zend_Form {

    public function init() {

        $this->setMethod('post');
        $this->addElement('text', 'nom', array(
            'label' => 'Nom :',
            'required' => true
        ));
        $this->addElement('text', 'mail', array(
            'label' => 'Mail :',
            'required' => true
        ));
        $this->addElement('text', 'sujet', array(
            'label' => 'Sujet :',
            'required' => true
        ));
        $this->addElement('textarea', 'contenue', array(
            'required' => true
        ));
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Envoyer'
        ));
    }

}

?>
