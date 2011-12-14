<?php

class ServMaintenance_Form_TacheMaintenance_completer extends Zend_Form {

    private $id;

    public function __construct($id) {
        $this->id = $id;
        parent::__construct(null);
    }

    public function init() {

        $maintenance = ServMaintenance_Model_TacheMaintenance::findOne($this->id);

        /** TODO: Protection XSS défaillante regex à écrire
         * 
         */
        if ($maintenance instanceof ServMaintenance_Model_TacheMaintenance) {
            $rapport = new Zend_Form_Element_Textarea('rapport');
            $rapport->setLabel('Rapport:');
            $rapport->setValue(htmlspecialchars_decode((base64_decode($maintenance->get_rapport()))));

            parent::addElement($rapport);

            $retard = new Zend_Form_Element_Text('retard');
            $retard->addValidator(new Zend_Validate_Int());
            $retard->setRequired(TRUE);
            $retard->setValue(0);
            $retard->setLabel('Retard à rajouter:(non implémenté doit être égale à 0)');

            parent::addElement($retard);

            $submit = new Zend_Form_Element_Submit('Valider');
            $submit->setName('Transmettre');

            parent::addElement($submit);
        }
    }

}

?>
