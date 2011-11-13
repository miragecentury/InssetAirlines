<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServLogCom_Form_CommandeNourriture extends Zend_Form
{

    public function init()
    {
        //Creation du champ permettant de selectionner une date
        $dateLiv = new Zend_Form_Element_Text('dateLivraison');
        $dateLiv->setLabel('Date de livraison :');
        $dateLiv->setRequired();
        
        //Creation du champ permettant de selectionner une date
        $dateCom = new Zend_Form_Element_Text('dateCommande');
        $dateCom->setLabel('Date de Commande :');
        $dateCom->setRequired();
        
        $labelAeroport = Application_Model_Aeroport::getSelectAeroport('labelAeroportLivraison', 'Aeroport de livraison :');

        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($dateLiv);
        $this->addElement($dateCom);
        $this->addElement($labelAeroport);
        $this->addElement($submit);
    }

}

?>
