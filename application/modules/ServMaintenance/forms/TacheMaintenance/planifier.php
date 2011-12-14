<?php

class ServMaintenance_Form_TacheMaintenance_planifier extends Zend_Form {

    public function init() {

        $tmpModeles = ServMaintenance_Model_Modele::getAll();
        foreach ($tmpModeles as $Modele) {
            if ($Modele instanceof ServMaintenance_Model_Modele)
                $Modeles[$Modele->get_noModele()] = $Modele;
        }
        $tmpConstructeurs = ServMaintenance_Model_Constructeur::GetAll();
        foreach ($tmpConstructeurs as $Constructeur) {
            if ($Constructeur instanceof ServMaintenance_Model_Constructeur) {
                $Constructeurs[$Constructeur->get_noConstructeur()] = $Constructeur;
            }
        }

        $Avions = ServMaintenance_Model_Avion::findAllEnServiceAtCurrentTime();

        $TypesMaintenance = ServMaintenance_Model_TypeMaintenance::findAll();
        foreach ($TypesMaintenance as $TypeMaintenance) {
            if ($TypeMaintenance instanceof ServMaintenance_Model_TypeMaintenance) {
                $TypeMaintenanceByModele[$TypeMaintenance->get_noModele()][$TypeMaintenance->get_noTypeMaintenance()] = $TypeMaintenance;
            }
        }

        foreach ($Avions as $Avion) {
            if ($Avion instanceof ServMaintenance_Model_Avion) {
                if (isset($TypeMaintenanceByModele[$Avion->get_noModele()])) {
                    foreach ($TypeMaintenanceByModele[$Avion->get_noModele()] as $TypeMaintenance) {
                        $lstSelect['noAvion=' . $Avion->get_noAvion() . '&noTypeMaintenance=' . $TypeMaintenance->get_noTypeMaintenance()] =
                                $Avion->get_noAvion() . '-' . $Avion->get_label() . '-'
                                . $Modeles[$Avion->get_noModele()]->get_label() . '-'
                                . $Constructeurs[$Modele->get_noConstructeur()]->get_label() . ' -> '
                                . $TypeMaintenance->get_label() . ' d=' . $TypeMaintenance->get_dureeMaintenance() . 'J';
                    }
                }
            }
        }

        $select = new Zend_Form_Element_Select('AvionTypeMaintenance');
        $select->setLabel('Sélection de l\'appareil et du type de Maintenance');
        $select->setMultiOptions($lstSelect);
        $select->setRequired(TRUE);
        parent::addElement($select);

        //**********************************************************************

        $dateDebut = new Zend_Form_Element_Text('dateDebut');
        $dates5 = ServPlaning_Model_Vol::getSemaineAheadFromCurrent(5);
        $dateDebut->setLabel('Date début: (Si la date est inférieur à [S+5]:'.$dates5.' alors il y a des risques d\'intéruption de service)');
        $dateDebut->addValidator(new Zend_Validate_Date(array('format' => 'yyyy-mm-dd')));
        $dateDebut->setValue('yyyy-mm-dd');
        $dateDebut->setRequired(TRUE);

        parent::addElement($dateDebut);
        //**********************************************************************
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setName('Confirmer');
        
        parent::addElement($submit);
    }

    public function setForUrg($noAvion, $noTypeMaintenance) {
        
    }

}

