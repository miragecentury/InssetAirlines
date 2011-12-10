<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class AgenceVoyage_Form_Reservation extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //Validator
        $num = new Zend_Validate_Int;
        
        
        //Creation du champ permettant de selectionner un nombre de place
        $reserv = new Zend_Form_Element_Text('nbReservation');
        $reserv->setLabel('Nombre de place :');
        $reserv->setValidators(array($num));
       
        
        //Creation du champ permettant d'entrer un num vol
        $noVol = new Zend_Form_Element_Text('noVol');
        $noVol->setLabel('No Vol :');
        $noVol->setRequired();
        
        
        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($noVol);
        $this->addElement($reserv);
        $this->addElement($submit);
    }

}

?>
