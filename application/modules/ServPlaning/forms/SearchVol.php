<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServPlaning_Form_SearchVol extends Zend_Form
{

    public function init()
    {
        $this->setMethod('GET');

        
        $noAeroportD = Application_Model_Aeroport::getSelectAeroport('noAeroD', 'Aeroport de depart :');
        $noAeroportA = Application_Model_Aeroport::getSelectAeroport('noAeroA', 'Aeroport de destination :');

        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($noAeroportD);
        $this->addElement($noAeroportA);
        $this->addElement($submit);
    }

}

?>
