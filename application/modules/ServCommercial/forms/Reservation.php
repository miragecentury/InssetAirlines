<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServCommercial_Form_Reservation extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //Validator
        $num = new Zend_Validate_Int;
        
        //Creation du champ permettant de selectionner le vol
        $vol = ServPlaning_Model_Vol::getSelectVol('noVol', 'No Vol :');

        //Creation du champ permettant de selectionner une agence
        $agence = ServCommercial_Model_Agence::getSelectAgence('noAgence', 'Agence :');
        
        //Creation du champ permettant de selectionner un nombre de place
        $reserv = new Zend_Form_Element_Text('nbReservation');
        $reserv->setLabel('Nombre de place :');
        $reserv->setValidators(array($num));
        
        //Acces extranet case a coché
        $trait = new Zend_Form_Element_Checkbox('enAttentedeTraitement');
        $trait->setLabel('Etat du traitement de la demande :');
        $trait->setRequired();
        
        //Adresse
        $val = new Zend_Form_Element_Checkbox('valider');
        $val->setLabel('Etat de la validation :');
        $val->setRequired();
        
        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($vol);
        $this->addElement($agence);
        $this->addElement($reserv);
        $this->addElement($trait);
        $this->addElement($val);
        $this->addElement($submit);
    }

}

?>
