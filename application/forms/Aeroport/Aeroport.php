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
        //Creation du champ permettant de selectionner une date
        $label = new Zend_Form_Element_Text('label');
        $label->setLabel('Label :');
        $label->setRequired();

        //Creation du champ permettant de selectionner une date
        $ville = new Zend_Form_Element_Text('ville');
        $ville->setLabel('Ville :');
        $ville->setRequired();
        
        //Creation du champ permettant de selectionner une date
        $pays = new Zend_Form_Element_Text('pays');
        $pays->setLabel('Pays :');
        $pays->setRequired();
        
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
