<?php

class ServMaintenance_Form_Modele extends Zend_Form {

    public function init() {
        
        //**********************************************************************
        
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Nom du Modèle:');
        $label->addValidator(new Zend_Validate_Alnum(TRUE));
        $label->addValidator(new Zend_Validate_StringLength(array('min' => 4, 'max' => 25)));
        $label->addValidator(new Zend_Validate_NotEmpty());
        $label->setRequired(TRUE);

        $this->addElement($label);

        //**********************************************************************

        $rA = new Zend_Form_Element_Text('rayonAction');
        $rA->setLabel('Rayon d\'action du modèle:');
        $rA->addValidator(new Zend_Validate_Alnum(FALSE));
        $rA->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $rA->addValidator(new Zend_Validate_Int());
        $rA->addValidator(new Zend_Validate_NotEmpty());
        $rA->setRequired(TRUE);

        $this->addElement($rA);
        
        //**********************************************************************

        $distMinAtt = new Zend_Form_Element_Text('distMinAtt');
        $distMinAtt->setLabel('Distance Minimum d\'Atterissage en Mètre:');
        $distMinAtt->addValidator(new Zend_Validate_Alnum(FALSE));
        $distMinAtt->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $distMinAtt->addValidator(new Zend_Validate_Int());
        $distMinAtt->setRequired(TRUE);
        $distMinAtt->addValidator(new Zend_Validate_NotEmpty());

        $this->addElement($distMinAtt);
        
        //**********************************************************************

        $distMinDec = new Zend_Form_Element_Text('distMinDec');
        $distMinDec->setLabel('Distance Minimum de Décollage en Mètre:');
        $distMinDec->addValidator(new Zend_Validate_Alnum(FALSE));
        $distMinDec->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $distMinDec->addValidator(new Zend_Validate_Int());
        $distMinDec->setRequired(TRUE);
        $distMinDec->addValidator(new Zend_Validate_NotEmpty());

        $this->addElement($distMinDec);
        
        //**********************************************************************
        
        $dateLancement = new Zend_Form_Element_Text('dateLancement');
        $dateLancement->setLabel('Date de Lancement du Modèle:');
        $dateLancement->addValidator(new Zend_Validate_Alnum(FALSE));
        $dateLancement->addValidator(new Zend_Validate_StringLength(array('min' => 4, 'max' => 4)));
        $dateLancement->addValidator(new Zend_Validate_Int());
        $dateLancement->setRequired(TRUE);
        $dateLancement->addValidator(new Zend_Validate_NotEmpty());
        
        $this->addElement($dateLancement);
        
        //**********************************************************************
        
        $liste_Constructeur = ServMaintenance_Model_Constructeur::GetAll();
        
        $select_value = array();
        
        foreach ($liste_Constructeur as $value) {
            $select_value[$value->get_noConstructeur()] = $value->get_label();
        }
        
        $noConstructeur = new Zend_Form_Element_Select('noConstructeur');
        $noConstructeur->setLabel('Constructeur:');
        $noConstructeur->setMultiOptions($select_value);
        $noConstructeur->setRequired(TRUE);
        $noConstructeur->addValidator(new Zend_Validate_NotEmpty());
        
        $this->addElement($noConstructeur);
        
        //**********************************************************************
        
        $submit = new Zend_Form_Element_Submit('Valider');
        $submit->setValue('Ajouter');
        
        $this->addElement($submit);
        
    }

    public function updateForm(ServMaintenance_Model_Modele $modele) {
        
        $label = $this->getElement('label');
        $label->setValue($modele->get_label());
        
        //**********************************************************************
        
        $rA = $this->getElement('rayonAction');
        $rA->setValue($modele->get_rayonAction());
        
        //**********************************************************************
        
        $distMinAtt = $this->getElement('distMinAtt');
        $distMinAtt->setValue($modele->get_distMinAtt());
        
        //**********************************************************************
        
        $distMinDec = $this->getElement('distMinDec');
        $distMinDec->setValue($modele->get_distMinDec());
        
        //**********************************************************************
        
        $dateLancement = $this->getElement('dateLancement');
        $dateLancement->setValue($modele->get_dateLancement());
        
        //**********************************************************************
        
        $noConstructeur = $this->getElement('noConstructeur');
        $noConstructeur->setValue($modele->get_noConstructeur());
        
        //**********************************************************************
        $submit = $this->getElement('Valider');
        $submit->setName('Modifier');
    }

}

?>
