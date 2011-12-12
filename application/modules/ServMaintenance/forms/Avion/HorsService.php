<?php

class ServMaintenance_Form_Avion_HorsService extends Zend_Form {
    
    private $id;

    function __construct($id) {
        $this->id = $id;
        parent::__construct();
    }

    
    public function init() {

        //**********************************************************************
        $dateHorsService = new Zend_Form_Element_Text('dateHorsService');
        $dateHorsService->setLabel(('Date de Mise Hors Service (Y-m-d)'));
        $dateHorsService->addValidator(new Zend_Validate_Date());
        $dateHorsService->setRequired(TRUE);

        parent::addElement($dateHorsService);



        //**********************************************************************

        $Valider = new Zend_Form_Element_Submit('submit');
        $Valider->setName('Confirmer');

        parent::addElement($Valider);
        
        parent::setAction('/ServMaintenance/Gestappareil/Misehorsservice/status/2/id/'.$this->id);
        
        //**********************************************************************
    }

}

?>
