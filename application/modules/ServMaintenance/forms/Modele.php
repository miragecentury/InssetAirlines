<?php

class ServMaintenance_Form_Modele extends Zend_Form {

    public function init() {
        $label = new Zend_Form_Element_Text('label');
        $label->addValidator(new Zend_Validate_Alnum(TRUE));
        $label->addValidator(new Zend_Validate_StringLength(array('min' => 4, 'max' => 25)));
    }

    public function updateForm(ServMaintenance_Model_Modele $modele) {
        
    }

}

?>
