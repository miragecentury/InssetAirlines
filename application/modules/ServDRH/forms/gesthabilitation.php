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
        //Récupère la liste des avions et modèles
        $metier = new ServDRH_Model_Metier;
        $modeleAvion = new ServMaintenance_Model_Modele;
        $listeMetiers = $metier->getMetiers();        
        $listeAvion = $modeleAvion->getAll();
        
        //Crée et ajoute les éléments du formulaire
        $this->setMethod('POST')
             ->setName('fm_ajoutHabilitation');
                                   
        $intitule = new Zend_Form_Element_Text('labelHabilitation');
        $intitule->setLabel('Intitulé* ')
                 ->setAttrib('size', 12)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('StringLength', false, array(1, 45))
                 ->setRequired(true);
        
        $labelMetier = new Zend_Form_Element_Select('labelMetier');
        $labelMetier->setLabel('Métier*')
                    ->addMultiOption('Pilote', 'Pilote');
                     
        $labelModele = new Zend_Form_Element_Select('labelModele');
        $labelModele->setLabel('Modèle*');
        $labelModele->addMultiOption('', '');
        foreach ($listeAvion as $modele) {
            $labelModele->addMultiOption($modele->get_label(), $modele->get_label());
        }
        $labelModele->setRequired(true);              
                
        $ajouter = new Zend_Form_Element_Submit('enregistrer');
        $ajouter->setLabel('Enregistrer');
        
        $annuler = new Zend_Form_Element_Submit('annuler');
        $annuler->setLabel('Annuler');
        
        $this->addElements(array($intitule, $labelMetier, $labelModele, $ajouter,
            $annuler));        
    }
}
?>
