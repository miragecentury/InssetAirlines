<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class Application_Form_Aeroport_Aeroport extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //Validator
        $alnum = new Zend_Validate_Alnum(array("allowWhiteSpace"=>true));
        
        //Creation du champ permettant de selectionner une date
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Label :');
        $label->setValidators(array($alnum));
        $label->setRequired(true);

        //Creation du champ permettant de selectionner une date
        $ville = new Zend_Form_Element_Text('ville');
        $ville->setLabel('Ville :');
        $ville->setValidators(array($alnum));
        $ville->setRequired(true);
        
        //Creation du champ permettant de selectionner une date
        $pays = new Zend_Form_Element_Text('pays');
        $pays->setLabel('Pays :');
        $pays->setValidators(array($alnum));
        $pays->setRequired(true);
        
        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($label);
        $this->addElement($ville);
        $this->addElement($pays);
        $this->addElement($submit);
    }

}

?>
