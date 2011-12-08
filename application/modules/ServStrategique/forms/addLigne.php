<?php

class ServStrategique_Form_addLigne extends Zend_Form
{

    public function init()
    {
        // initialisation
        $this->setMethod('POST');
        $aeroports = Application_Model_Aeroport::getListeAeroport();
        $listeAero = array();
        foreach ($aeroports as $aeroport) {
            $listeAero[$aeroport->get_noAeroport()] = $aeroport->get_labelAeroport() .
                ', ' .
                $aeroport->get_labelVille();
        }


        //1er Element
        $aeroportDep = new Zend_Form_Element_Select('aeroDep');
        $aeroportDep->addMultiOptions($listeAero)
            ->setLabel('Aéroport de départ : ')
            ->setRequired(true);
        $this->addElement($aeroportDep);

        //2e Element
        $aeroAtt = new Zend_Form_Element_Select('aeroAtt');
        $aeroAtt->setLabel("Aéroport d'Atterrissage : ")
            ->setRequired(true)
            ->addMultiOptions($listeAero);
        $this->addElement($aeroAtt);

        //2.34 Element..
        $arrayEtat = array(ServStrategique_Model_Ligne::ETAT_ETUDE => 'En étude',
            ServStrategique_Model_Ligne::ETAT_EN_VALIDATION => 'En attente de validation',
            ServStrategique_Model_Ligne::ETAT_ACTIVE => 'Active',
            ServStrategique_Model_Ligne::ETAT_INACTIVE => 'Inactive');

        $etat = new Zend_Form_Element_Select('etat');
        $etat->setLabel('Etat de la ligne')
            ->setRequired(true)
            ->addMultiOptions($arrayEtat);
        $this->addElement($etat);

        //3e ..
        $listeType = array(1 => 'Journalière',
            2 => 'Hebdomadaire',
            3 => 'Mensuelle',
            4 => 'Annuelle');
        $type = new Zend_Form_Element_Select('type');
        $type->setLabel('Type de récurence : ')
            ->setRequired(true)
            ->addMultiOptions($listeType);

        $this->addElement($type);

        //4e ..
        $recurence = new Zend_Form_Element_Text('recurence');
        $recurence->setLabel('Récurence :')
            ->setRequired(true)
            ->setValue(0)
            ->setValidators(array(new Zend_Validate_Int()));

        $this->addElement($recurence);

        //7e ..
        $duree = new Zend_Form_Element_Text('duree');
        $duree->setRequired(true)
            ->setLabel('Durée minimale de vol : ')
            ->setValidators(array(new Zend_Validate_Int(),
                new Zend_Validate_StringLength(
                    array('min' => 1, 'max' => 5)
                )
            ))
            ->setValue(0);

        $this->addElement($duree);

        //Submit..
        $this->addElement('submit', 'valider', array('label' => 'Valider'));
    }

}