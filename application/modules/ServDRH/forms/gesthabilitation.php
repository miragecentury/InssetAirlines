<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestpilote
 *
 * @author camille
 */

class ServDRH_Form_gesthabilitation extends Zend_Form
{
    public function init(){       
        $metier = new ServDRH_Model_Metier;
        $listeMetiers = $metier->getMetiers();
        
        $modeleAvion = new ServMaintenance_Model_Modele;
        $listeAvion = $modeleAvion->getModeles();
                                   
        $intitule = new Zend_Form_Element_Text('labelHabilitation');
        $intitule->setLabel('Intitulé* ');
        $intitule->addFilter('StripTags');
        $intitule->addFilter('StringTrim');
        $intitule->addValidator('StringLength', false, array(1, 45));
        $intitule->setRequired(true);
        
        $labelMetier = new Zend_Form_Element_Select('labelMetier');
        $labelMetier->setLabel('Métier*');
        $labelMetier->addMultiOption('', '');
        foreach ($listeMetiers as $metier) {
            $labelMetier->addMultiOption($metier->get_labelMetier(), $metier->get_labelMetier());
        }
        $labelMetier->setRequired(true);
                     
        $labelModele = new Zend_Form_Element_Select('labelModele');
        $labelModele->setLabel('Modèle*');
        $labelModele->addMultiOption('', '');
        foreach ($listeAvion as $modele) {
            $labelModele->addMultiOption($modele->get_label(), $modele->get_label());
        }
        $labelModele->setRequired(true);              
                
        $ajouter = new Zend_Form_Element_Submit('enregistrer');
        $ajouter->setLabel('Enregistrer');
        $ajouter->setIgnore(true);
        
        $annuler = new Zend_Form_Element_Submit('annuler');
        $annuler->setLabel('Annuler');
        $annuler->setIgnore(true);
        
        $this->addElement($intitule);
        $this->addElement($labelMetier);
        $this->addElement($labelModele);
        $this->addElement($ajouter);
        $this->addElement($annuler);
        
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '/gesthabilitation/fmAjoutHabilitation.phtml'))));
    }
}
?>
