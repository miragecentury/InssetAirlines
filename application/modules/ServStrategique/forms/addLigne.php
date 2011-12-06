<?php
class ServStrategique_Form_addLigne extends Zend_Form
{
    public function init(){
    // initialisation
    $this->setMethod('POST');
    $aeroports = Application_Model_Aeroport::getListeAeroport();
    $listeAero = array();
    foreach ($aeroports as $aeroport){
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
    $jour = new Zend_Form_Element_Text('jour');
    $jour->setLabel('Nbr de Vol par jour : ')
        ->setRequired(true)
        ->setValue(0)
        ->setValidators(array(new Zend_Validate_Int()));

    $this->addElement($jour);

    //4e ..
    $semaine = new Zend_Form_Element_Text('semaine');
    $semaine->setLabel('Nbr de Vol par semaine :')
        ->setRequired(true)
        ->setValue(0)
        ->setValidators(array(new Zend_Validate_Int()));

    $this->addElement($semaine);

    //5e ..
    $mois = new Zend_Form_Element_Text('mois');
    $mois->setLabel('Nbr de Vol par Mois :')
        ->setRequired(true)
        ->setValue(0)
        ->setValidators(array(new Zend_Validate_Int()));

    $this->addElement($mois);

    //6e ..
    $annee = new Zend_Form_Element_Text('annee');
    $annee->setLabel('Nbr de Vol par Annee :')
        ->setRequired(true)
        ->setValue(0)
        ->setValidators(array(new Zend_Validate_Int()));

    $this->addElement($annee);

    //Submit..
    $this->addElement('submit', 'valider', array('label' => 'Valider'));
    }
}