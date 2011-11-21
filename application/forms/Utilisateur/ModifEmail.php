<?php

/**
 * Description of ModifEmail
 *
 * @author pewho
 */
class Application_Form_Utilisateur_ModifEmail extends Zend_Form
{

    public function init()
    {
        //Methode du form
        $this->setMethod('POST');

        //1er element
        $email = new Zend_Form_Element_Text('email');
        $email->isRequired(true);
        $email->setLabel('nouvel email');
        $email->setValidators(array(new Zend_Validate_EmailAddress()));
        $this->addElement($email);

        //Submit..
        $this->addElement('submit', 'valider', array('label' => 'Valider'));
    }
}
