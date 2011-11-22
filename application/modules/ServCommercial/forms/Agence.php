<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServCommercial_Form_Agence extends Zend_Form
{

    public function init()
    {
        //Creation du champ permettant de selectionner le label
        $label = new Zend_Form_Element_Text('labelAgence');
        $label->setLabel('Label :');
        $label->setRequired();

        //Creation du champ permettant de selectionner une date
        $dateL = new Zend_Form_Element_Text('dateLancement');
        $dateL->setLabel('Date de lancement :');
        $dateL->setRequired();
        
        //Creation du champ permettant de selectionner une date
        $dateC = new Zend_Form_Element_Text('dateCloture');
        $dateC->setLabel('Date de cloture :');
        
        //Acces extranet case a coché
        $extra = new Zend_Form_Element_Checkbox('accesExtranet');
        $extra->setLabel('Acces Extranet :');
        $extra->setRequired();
        
        //Adresse
        $adr = new Zend_Form_Element_Text('noAdresse');
        $adr->setLabel('Adresse :');
        $adr->setRequired();
        
        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($label);
        $this->addElement($dateL);
        $this->addElement($dateC);
        $this->addElement($extra);
        $this->addElement($adr);
        $this->addElement($submit);
    }

}

?>
