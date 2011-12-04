<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServCommercial_Form_Place extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');

        //Validator
        $alnum = new Zend_Validate_Alnum(array("allowWhiteSpace" => true));
        
        //Creation du champ de selection d'une agence
        $noAgence = ServCommercial_Model_Agence::getSelectAgence('noAgence', 'Agence :');

        //Creation du champ permettant de selectionner une personne
        $noPers = new Zend_Form_Element_Text('noPersonne');
        $noPers->setLabel('Personne :');
        $noPers->setValidators(array($alnum));
        $noPers->setRequired();

        //Creation du champ permettant de selectionner un vol
        $noVol = ServPlaning_Model_Vol::getSelectVol('noVol', 'No Vol :');

        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($noAgence);
        $this->addElement($noPers);
        $this->addElement($noVol);
        $this->addElement($submit);
    }

}

?>
