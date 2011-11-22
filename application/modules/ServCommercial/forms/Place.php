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
        //Creation du champ de selection d'une agence
        $noAgence = ServCommercial_Model_Agence::getSelectAgence('noAgence', 'Agence :');

        //Creation du champ permettant de selectionner une personne
        $noPers = new Zend_Form_Element_Text('noPersonne');
        $noPers->setLabel('Personne :');
        $noPers->setRequired();
        
        //Creation du champ permettant de selectionner un vol
        $noVol = new Zend_Form_Element_Text('noVol');
        $noVol->setLabel('Vol :');
        $noVol->setRequired();
        
        
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
