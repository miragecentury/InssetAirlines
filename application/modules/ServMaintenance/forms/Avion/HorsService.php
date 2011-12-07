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
        $dateHorsService->setLabel(('Date de Mise Hors Service ('.DATE_ATOM.')'));
        $dateHorsService->addValidator(new Zend_Validate_Alnum(TRUE));
        $dateHorsService->addValidator(new Zend_Validate_Date(array('format' => DATE_ATOM)));
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
