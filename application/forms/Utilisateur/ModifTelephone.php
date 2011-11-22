<?php

/**
 * Description of ModifTelephone
 * Formulaire associé à l'action de modif de Telephone
 *
 * @author pewho
 */
class Application_Form_Utilisateur_ModifTelephone extends Zend_Form
{
    public function init(){

        //Init
        $this->setAction('POST');

        //1er element
        $labelTelephone = new Zend_Form_Element_Text('labelTelephone');
        $labelTelephone->setRequired(true)
            ->setLabel('Description du numéro : ')
            ->setValidators(array(new Zend_Validate_Alnum(array('allowWhiteSpace' => true))));

        $this->addElement($labelTelephone);

        //2e ..
        $numTelephone = new Zend_Form_Element_Text('numTelephone');
        $numTelephone->setRequired(true)
            ->setLabel('Numéro :')
            ->setValidators(new Zend_Validate_Regex(array('patern' => '/^\+[0-9]{11}$|^[0-9]{10}$/')));

        //Submit ..
         $this->addElement('submit','valider',array('label' => 'Valider'));
    }
}

?>
