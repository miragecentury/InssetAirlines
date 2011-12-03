<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServLogCom_Form_RegimeAlimentaire extends Zend_Form
{

    public function init()
    {
        //Creation du champ permettant d'entrer un labeltypeincident
        $labelRegimeAlimentaire = new Zend_Form_Element_Text('labelRegimeAlimentaire');
        $labelRegimeAlimentaire->setLabel('Label Regime Alimentaire :');
        $labelRegimeAlimentaire->setRequired();

        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($labelRegimeAlimentaire);
        $this->addElement($submit);
    }

}

?>
