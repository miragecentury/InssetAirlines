<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServPlaning_Form_Vol extends Zend_Form
{

    public function init()
    {
        $labelVol = new Zend_Form_Element_Text('labelvol');
        $labelVol->setLabel('Label :');
        $labelVol->setRequired();

        $labelAeroportDec = Application_Model_Aeroport::getSelectAeroport('labelAeroportDeco', 'Aeroport de décollage :');
        
        $labelAeroportAtt = Application_Model_Aeroport::getSelectAeroport('labelAeroportAtte', 'Aeroport d\'atterissage :');
        
        $noAvion = new Zend_Form_Element_Text('noAvion');
        $noAvion->setLabel('Avion :');
        $noAvion->setRequired();
        
        $noLigne = new Zend_Form_Element_Text('noLigne');
        $noLigne->setLabel('Ligne :');
        $noLigne->setRequired();
        
        $hDec = new Zend_Form_Element_Text('heuredecollage');
        $hDec->setLabel('Heure de décollage :');
        $hDec->setRequired();
        
        $hAtt = new Zend_Form_Element_Text('heureAtterissage');
        $hAtt->setLabel('Heure Atterissage :');
        $hAtt->setRequired();
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($labelVol);
        $this->addElement($labelAeroportDec);
        $this->addElement($labelAeroportAtt);
        $this->addElement($noAvion);
        $this->addElement($noLigne);
        $this->addElement($hDec);
        $this->addElement($hAtt);
        $this->addElement($submit);
    }

}

?>
