<?php

class ServMaintenance_Form_Constructeur extends Zend_Form {

    public function init() {  
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Nom du Constructeur');
        $label->setRequired();
        $label->addValidator(new Zend_Validate_Alnum(TRUE));
        $label->addValidator(new Zend_Validate_StringLength(array('min'=>4,'max'=>25)));
        
        $this->addElement($label);
        
        
        $adresse = new Zend_Form_Element_Text('adresse');
        $adresse->setLabel('Adresse:');
        $adresse->addValidator(new Zend_Validate_Int());
        $adresse->addValidator(new Zend_Validate_GreaterThan(0));
        
        $this->addElement($adresse);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);
        
        $this->addElement($submit);
        
    }

}

?>
