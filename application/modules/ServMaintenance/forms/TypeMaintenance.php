<?php

class ServMaintenance_Form_TypeMaintenance extends Zend_Form {

    public function init() {
        //**********************************************************************
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Appellation');
        $label->addValidator(new Zend_Validate_Alnum(TRUE));
        $label->setRequired(TRUE);
        $label->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 25)));



        //**********************************************************************

        $dureeMaintenance = new Zend_Form_Element_Text('dureeMaintenance');
        $dureeMaintenance->setLabel('Duree Minimum de la Maintenance:');
        $dureeMaintenance->addValidator(new Zend_Validate_Int());
        $dureeMaintenance->setValue(0);
        $dureeMaintenance->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));

        //**********************************************************************
        
        $periode = new Zend_Form_Element('periode');
        $periode->setLabel('Temps entre les Révisions');
        
        //**********************************************************************
    }

    public function updateForm(ServMaintenance_Model_TypeMaintenance $TypeMaintenance) {
        
    }

}

?>
