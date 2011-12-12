<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestcongepilote
 *
 * @author camille
 */
class ServDRH_Form_gestcongepilote extends Zend_Form
{
    public function init() {
        //Récupère la liste des types de congés
        $typeConge = new ServDRH_Model_TypeConge;
        $listeLabelTypeConge = $typeConge->getTypeConges();
        
        $this->setMethod('POST')
             ->setName('modification_conge');
        
        $jourDateDebut = new Zend_Form_Element_Select('jourDateDebut');
        $jourDateDebut->setLabel('Jour date de debut');
        $jourDateDebut->addMultiOption(0,'');
        for ($i=1; $i<=31; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $jourDateDebut->addMultiOption($i, $j);
        }            
        $jourDateDebut->addValidator('notEmpty');
        $jourDateDebut->addFilter('StripTags');
        $jourDateDebut->addFilter('StringTrim');
        $jourDateDebut->setRequired(true);
        
        $moisDateDebut = new Zend_Form_Element_Select('moisDateDebut');
        $moisDateDebut->setLabel('Mois date de debut');
        $moisDateDebut->addMultiOption(0,'');
        for ($i=1; $i<=12; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $moisDateDebut->addMultiOption($i, $j);
        }
        $moisDateDebut->addValidator('notEmpty');
        $moisDateDebut->addFilter('StripTags');
        $moisDateDebut->addFilter('StringTrim');
        $moisDateDebut->setRequired(true);
        
        $anneeDateDebut = new Zend_Form_Element_Select('$anneeDateDebut');
        $anneeDateDebut->setLabel('Année date de debut');
        $anneeDateDebut->addMultiOption(0,'');
        for ($i=date('Y'); $i <= date('Y')+2; $i++) {
            $anneeDateDebut->addMultiOption($i, $i);
        }
        $anneeDateDebut->addValidator('notEmpty');
        $anneeDateDebut->addFilter('StripTags');
        $anneeDateDebut->addFilter('StringTrim');
        $anneeDateDebut->setRequired(true);
        
        $jourDateFin = new Zend_Form_Element_Select('jourDateFin');
        $jourDateFin->setLabel('Jour date de fin');
        $jourDateFin->addMultiOption('','');
        for ($i=1; $i<=31; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $jourDateFin->addMultiOption($i, $j);
        }            
        $jourDateFin->addValidator('notEmpty');
        $jourDateFin->addFilter('StripTags');
        $jourDateFin->addFilter('StringTrim');
        $jourDateFin->setRequired(true);
        
        $moisDateFin = new Zend_Form_Element_Select('moisDateFin');
        $moisDateFin->setLabel('Mois date de fin');
        $moisDateFin->addMultiOption(0,'');
        for ($i=1; $i<=12; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $moisDateFin->addMultiOption($i, $j);
        }
        $moisDateFin->addValidator('notEmpty');
        $moisDateFin->addFilter('StripTags');
        $moisDateFin->addFilter('StringTrim');
        $moisDateFin->setRequired(true);
        
        $anneeDateFin = new Zend_Form_Element_Select('anneeDateFin');
        $anneeDateFin->setLabel('Année date de fin');
        $anneeDateFin->addMultiOption(0,'');
        for ($i=date('Y'); $i <= date('Y')+2; $i++) {
            $anneeDateFin->addMultiOption($i, $i);
        }
        $anneeDateFin->addValidator('notEmpty');
        $anneeDateFin->addFilter('StripTags');
        $anneeDateFin->addFilter('StringTrim');
        $anneeDateFin->setRequired(true);
        
        $valider = new Zend_Form_Element_Select('valider');
        $valider->setLabel('Validation*');
        $valider->addMultiOptions(array(-1 => 'Refusée', 0 => 'Non traitée',
            1 => 'Validée'));        
        $valider->addValidator('notEmpty');
        $valider->addFilter('StripTags');
        $valider->addFilter('StringTrim');
        $valider->setRequired(true);
        
        $enAttente = new Zend_Form_Element_Select('enAttente');
        $enAttente->setLabel('Etat du traitement*');     
        $enAttente->addMultiOptions(array(0 => "Traitement fini", 
            1 => "En attente"));
        $enAttente->addValidator('notEmpty');
        $enAttente->addFilter('StripTags');
        $enAttente->addFilter('StringTrim');
        $enAttente->setRequired(true);
        
        $motif = new Zend_Form_Element_Text('motif');
        $motif->setLabel('Motif*')
               ->setAttrib('size', 12)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('StringLength', false, array(1, 200))
               ->addValidator('notEmpty')
               ->setRequired(true);
        
        $labelTypeConge = new Zend_Form_Element_Select('labelTypeConge');
        $labelTypeConge->setLabel('Type de conge*');
        foreach($listeLabelTypeConge as $typeConge) {
            $labelTypeConge->addMultiOption($typeConge->get_labelTypeConge(), $typeConge->get_labelTypeConge());
        }
        $labelTypeConge->addValidator('notEmpty');
        $labelTypeConge->addFilter('StripTags');
        $labelTypeConge->addFilter('StringTrim');
        $labelTypeConge->setRequired(true);
        
        $jourDateDebutAnnee = new Zend_Form_Element_Select('jourDateDebutAnnee');
        $jourDateDebutAnnee->setLabel('Jour date de debut annee');
        $jourDateDebutAnnee->addMultiOption(0,'');
        for ($i=1; $i<=31; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $jourDateDebutAnnee->addMultiOption($i, $j);
        }            
        $jourDateDebutAnnee->addValidator('notEmpty');
        $jourDateDebutAnnee->addFilter('StripTags');
        $jourDateDebutAnnee->addFilter('StringTrim');
        $jourDateDebutAnnee->setRequired(true);
        
        $moisDateDebutAnnee = new Zend_Form_Element_Select('moisDateDebutAnnee');
        $moisDateDebutAnnee->setLabel('Mois date de debut annee');
        $moisDateDebutAnnee->addMultiOption(0,'');
        for ($i=1; $i<=12; $i++) {
            $j = $i;
            if ($j < 10) {
                $j = '0'.$j;
            }
            $moisDateDebutAnnee->addMultiOption($i, $j);
        }
        $moisDateDebutAnnee->addValidator('notEmpty');
        $moisDateDebutAnnee->addFilter('StripTags');
        $moisDateDebutAnnee->addFilter('StringTrim');
        $moisDateDebutAnnee->setRequired(true);
        
        $anneeDateDebutAnnee = new Zend_Form_Element_Select('anneeDateDebutAnnee');
        $anneeDateDebutAnnee->setLabel('Année date de debut annee');
        $anneeDateDebutAnnee->addMultiOption(0,'');
        for ($i=date('Y'); $i>=1900; $i--) {
            $anneeDateDebutAnnee->addMultiOption($i, $i);
        }
        $anneeDateDebutAnnee->addValidator('notEmpty');
        $anneeDateDebutAnnee->addFilter('StripTags');
        $anneeDateDebutAnnee->addFilter('StringTrim');
        $anneeDateDebutAnnee->setRequired(true);        
        
        $submit = new Zend_Form_Element_Submit('enregistrer');
        $submit->setLabel('Enregistrer');
        
        $cancel = new Zend_Form_Element_Submit('annuler');
        $cancel->setLabel('Annuler');
        
        $this->addElements(array($jourDateDebut, $moisDateDebut, $anneeDateDebut,
            $jourDateFin, $moisDateFin, $anneeDateFin, $valider, $enAttente,
            $motif, $labelTypeConge, $jourDateDebutAnnee, $moisDateDebutAnnee,
            $anneeDateDebutAnnee, $submit, $cancel));
    }
}

?>
