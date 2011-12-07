<?php

class ServMaintenance_Form_TypeMaintenance extends Zend_Form {

    private $noModele;

    public function __construct($noModele = null) {

        $this->noModele = $noModele;
        parent::__construct();
    }

    public function init() {
        //**********************************************************************
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Appellation');
        $label->addValidator(new Zend_Validate_Alnum(TRUE));
        $label->setRequired(TRUE);
        $label->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 25)));

        parent::addElement($label);

        //**********************************************************************

        $dureeMaintenance = new Zend_Form_Element_Text('dureeMaintenance');
        $dureeMaintenance->setLabel('Duree Minimum de la Maintenance en Jour:');
        $dureeMaintenance->addValidator(new Zend_Validate_Int());
        $dureeMaintenance->setValue(0);
        $dureeMaintenance->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $dureeMaintenance->setRequired(TRUE);

        parent::addElement($dureeMaintenance);

        //**********************************************************************

        $periode = new Zend_Form_Element('periode');
        $periode->setLabel('Heure de Vol entre les différentes Révisions');
        $periode->addValidator(new Zend_Validate_Int());
        $periode->setValue(0);
        $periode->addValidator(new Zend_Validate_GreaterThan(5));
        $periode->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $periode->setRequired(TRUE);

        parent::addElement($periode);
        //**********************************************************************

        if ($this->noModele === null) {
            $Modeles = ServMaintenance_Model_Modele::getAll();
            $listModeles = array();
            foreach ($Modeles as $Modele) {
                if ($Modele instanceof ServMaintenance_Model_Modele) {
                    $Constructeur = ServMaintenance_Model_Constructeur::FindOne($Modele->get_noConstructeur());
                    if ($Constructeur instanceof ServMaintenance_Model_Constructeur) {
                        $listModeles[$Modele->get_noModele()] = $Modele->get_label() . ' - ' . $Constructeur->get_label();
                    }
                }
            }
            $noModele = new Zend_Form_Element_Select('noModele');
            $noModele->setLabel('Modèle concerné:');
            $noModele->setMultiOptions($listModeles);
        } else {
            $noModele = new Zend_Form_Element_Hidden('noModele');
            $noModele->setValue($this->noModele);
        }
        $noModele->addValidator(new Zend_Validate_Int());
        $noModele->addValidator(new Zend_Validate_StringLength(array('min' => 0, 'max' => 10)));
        $noModele->setRequired(TRUE);

        parent::addElement($noModele);

        //**********************************************************************

        $submit = new Zend_Form_Element_Submit('Valider');
        $submit->setLabel('Ajouter le Type de Maintenance');

        parent::addElement($submit);
    }

    public function updateForm(ServMaintenance_Model_TypeMaintenance $TypeMaintenance) {
        
        //**********************************************************************
        
        parent::removeElement('noModele');
        parent::removeElement('label');
        
        //**********************************************************************
        
        $dureeMaintenance = parent::getElement('dureeMaintenance');
        $dureeMaintenance->setValue($TypeMaintenance->get_dureeMaintenance());
        
        //**********************************************************************
        
        $periode = parent::getElement('periode');
        $periode->setValue($TypeMaintenance->get_periode());
        
        //**********************************************************************
        $submit = parent::getElement('Valider');
        $submit->setLabel('Modifier');
        
    }

}

?>
