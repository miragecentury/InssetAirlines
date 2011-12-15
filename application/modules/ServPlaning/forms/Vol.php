<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServPlaning_Form_Vol extends Zend_Form {

    private $Start;
    private $End;
    private $lstAvOnM;
    private $Maintenances;

    public function __construct(DateTime $Start, DateTime $End) {
        $this->Start = $Start;
        $this->End = $End;
        parent::__construct();
    }

    public function init() {

        $label = new Zend_Form_Element_Text('label');
        $label->setRequired();
        $label->setLabel('Label du Vol:');
        
        parent::addElement($label);
        
        //**********************************************************************
        
        $datedecollage = new Zend_Form_Element_Text('datedecollage');
        $datedecollage->setRequired(TRUE);
        $datedecollage->setLabel('Date de Décollage:');
        $datedecollage->setValue('yyyy-mm-dd hh:00');
        parent::addElement($datedecollage);

        //**********************************************************************

        $dateAtterissage = new Zend_Form_Element_Text('dateAtterissage');
        $dateAtterissage->setRequired(TRUE);
        $dateAtterissage->setLabel('Date d\'Atterissage:');
        $dateAtterissage->setValue('yyyy-mm-dd hh:00');
        parent::addElement($dateAtterissage);

        //**********************************************************************
        $Maintenances = ServMaintenance_Model_TacheMaintenance::findAllAtDateTimeInterval($this->Start, $this->End);
        $this->Maintenances = $Maintenances;
        if (count($Maintenances) == 0) {
            $this->lstAvOnM = array();
        } else {
            foreach ($Maintenances as $Maintenance) {
                if ($Maintenance instanceof ServMaintenance_Model_TacheMaintenance) {
                    $Avion = ServMaintenance_Model_Avion::findOne($Maintenance->get_noAvion());
                    if ($Avion instanceof ServMaintenance_Model_Avion) {
                        $this->lstAvOnM[$Avion->get_noAvion()] = null;
                    }
                }
            }
        }
        $Avions = ServMaintenance_Model_Avion::findAllEnServiceAtDateTime($this->Start, $this->End);
        if (count($Avions) == 0) {
            $lstAv = array('Aucun Avion Dispo');
        } else {
           
            foreach ($Avions as $Avion) {
                if ($Avion instanceof ServMaintenance_Model_Avion) {
                    if (!array_key_exists($Avion->get_noAvion(), $this->lstAvOnM)) {
                        $lstAv[$Avion->get_noAvion()] = $Avion->get_noAvion() . ":" . $Avion->get_label() . ':Places:' . $Avion->get_nbPlaceMax();
                    }
                }
            }
        }
        //**********************************************************************

        $noAvion = new Zend_Form_Element_Select('noAvion');
        $noAvion->setRequired(TRUE);
        $noAvion->setMultiOptions($lstAv);
        $noAvion->setLabel('Avion:');
        parent::addElement($noAvion);

        //**********************************************************************

        $DRH = new ServDRH_Model_EmployeMapper();
        $Employes = $DRH->findAll();
        if (count($Employes) == 0) {
            $lstE = array('Aucun Employé');
        }
        foreach ($Employes as $Employe) {
            if ($Employe instanceof ServDRH_Model_Employe) {
                $P = Application_Model_Personne::getPersonneById($Employe->get_Personne_noPersonne());
                if ($P instanceof Application_Model_Personne) {
                    $lstE[$Employe->get_Personne_noPersonne()] = $Employe->get_Personne_noPersonne() . ':' . $P->get_nom() . ' ' . $P->get_prenom();
                }
            }
        }
        //**********************************************************************
        $noPersonne1 = new Zend_Form_Element_Select('noPersonne1');
        $noPersonne1->setRequired(TRUE);
        $noPersonne1->setLabel('Pilote:');
        $noPersonne1->setMultiOptions($lstE);
        parent::addElement($noPersonne1);

        //**********************************************************************

        $noPersonne2 = new Zend_Form_Element_Select('noPersonne2');
        $noPersonne2->setLabel('Co-Pilote:');
        $noPersonne2->setMultiOptions($lstE);
        $noPersonne2->setRequired(TRUE);
        parent::addElement($noPersonne2);

        //**********************************************************************

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setName('Test Planification');
        parent::addElement($submit);
    }

    public function setFormModAvion($noAvion = null) {
        parent::removeElement('noPersonne1');
        parent::removeElement('noPersonne2');
        parent::removeElement('datedecollage');
        parent::removeElement('dateAtterissage');
    }

    public function setFormModPersonne($Personne1 = null, $Personne2 = null) {
        parent::removeElement('datedecollage');
        parent::removeElement('dateAtterissage');
        parent::removeElement('noAvion');
    }

    public function returnLstOnM(){
        if(isset($this->lstAvOnM)){
            return $this->lstAvOnM;
        }
    }
    
    public function returnMaintenances(){
        if(isset($this->Maintenances)){
            return $this->Maintenances;
        }
    }
}

?>
