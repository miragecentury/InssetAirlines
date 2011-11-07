<?php

/**
 * Description of Application_Form_Auth_Login
 * 
 * Formulaire simple de login, utilisé par défaut
 *
 * @author pewho
 */
class Application_Form_Auth_Login extends Zend_Form {
    public function init() {
     
        $this->setMethod('post');
        $this->addElement('text','username',array(
           'label' => 'Login :',
            'required' => true,
            'filters' => array('StringTrim')
        ));
        $this->addElement('password','password',array(
            'label' => 'Mot de passe :',
            'required' => true
        ));
        $this->addElement('submit','submit',array(
            'ignore' => true,
            'label' => 'Login'
        ));
    }

}

?>
