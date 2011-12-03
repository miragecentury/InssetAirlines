<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServLogCom_Form_Menu extends Zend_Form
{

    public function init()
    {
        //Creation du champ permettant d'entrer un labeltypeincident
        $labelMenu = new Zend_Form_Element_Text('labelMenu');
        $labelMenu->setLabel('Label Menu :');
        $labelMenu->setRequired();

        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($labelMenu);
        $this->addElement($submit);
    }

}

?>
