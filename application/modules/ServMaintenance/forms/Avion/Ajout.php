<?php

class ServMaintenance_Form_Avion_Ajout extends Zend_Form {

    public function init() {

        //**********************************************************************

        $label = new Zend_Form_Element('label');
        $label->setRequired(TRUE);
        $label->setLabel('Appellation :');
        $label->addValidator(new Zend_Validate_Alpha(TRUE));
        $label->addValidator(new Zend_Validate_StringLength(array('min' => 4, 'max' => 25)));
        
        $this->addElement($label);

        //**********************************************************************

        $nbPlaceMax = new Zend_Form_Element_Text('nbPlaceMax');
        $nbPlaceMax->setLabel('Nombre de Place Maximum :');
        $nbPlaceMax->setRequired(TRUE);
        $nbPlaceMax->addValidator(new Zend_Validate_Int());
        $nbPlaceMax->addValidator(new Zend_Validate_GreaterThan(0));

        $this->addElement($nbPlaceMax);
        
        //**********************************************************************

        $nbHeureVol = new Zend_Form_Element_Text('nbHeureVol');
        $nbHeureVol->setRequired(TRUE);
        $nbHeureVol->setLabel('Nomnre d\'heure de Vol :');
        $nbHeureVol->addValidator(new Zend_Validate_Int());
        $nbHeureVol->addValidator(new Zend_Validate_GreaterThan(0));
        
        $this->addElement($nbHeureVol);

        //**********************************************************************

        $dateMiseService = new Zend_Form_Element_Text('dateMiseService');
        $dateMiseService->setRequired(TRUE);
        $dateMiseService->setLabel('Date de mise en Service :');
        $dateMiseService->addValidator(new Zend_Validate_Date(array('format' => 'yyyy-mm-dd')));
        
        $this->addElement($dateMiseService);

        //**********************************************************************

        $modeles = ServMaintenance_Model_Modele::getAll();

        $lst_modeles = array();
        foreach ($modeles as $value) {
            $lst_modeles[$value->get_noModele()] = $value->get_label();
        }
        
        $nomodele = new Zend_Form_Element_Select('noModele');
        $nomodele->setLabel('Modèle de l \'avion');
        $nomodele->isRequired(TRUE);
        $nomodele->addMultiOptions($lst_modeles);
        $nomodele->addValidator(new Zend_Validate_Int());
        
        $this->addElement($modeles);

        //**********************************************************************
    }

    public function updateForm(ServMaintenance_Model_Avion $avion) {
        
        //**********************************************************************
        
        parent::removeElement('noModele');
        parent::removeElement('nbHeureVol');
        parent::removeElement('dateMiseService');
        
        //**********************************************************************
        
        $label = parent::getElement('label');
        $label->setValue($avion->get_label());
        
        //**********************************************************************
        
        $nbPlaceMax = parent::getElement('nbPlaceMax');
        $nbPlaceMax->setValue($avion->get_nbPlaceMax());
        
        //**********************************************************************

    }

    public static function POSTtoRaw($post) {
        
    }

}

?>
