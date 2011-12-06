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
        $this->setMethod('POST');
        
        //Validator
        $alnum = new Zend_Validate_Alnum(array("allowWhiteSpace"=>true));
        $date = new Zend_Validate_Date($_format= 'Y-m-d' );
        
        //Creation du champ permettant de selectionner une date
        $dateLiv = new Zend_Form_Element_Text('dateLivraison');
        $dateLiv->setLabel('Date de livraison :');
        $dateLiv->setValidators(array($date));
        $dateLiv->setRequired();
        
        //Creation du champ permettant de selectionner une date
        $dateCom = new Zend_Form_Element_Text('dateCommande');
        $dateCom->setLabel('Date de Commande :');
        $dateCom->setRequired();
        $dateCom->setValidators(array($date));
        
        $labelAeroport = Application_Model_Aeroport::getSelectAeroport('idAeroportLivraison', 'Aeroport de livraison :');

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
