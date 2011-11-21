<?php

/**
 * Description of modifAdresse
 *
 * @author pewho
 */
class Application_Form_Utilisateur_modifAdresse extends Zend_Form
{

    public function init()
    {
        //Methode du form
        $this->setMethod('POST');

        //1er element
        $numero = new Zend_Form_Element_Text('numero');
        $numero->isRequired(true)
            ->setLabel('*Numero :')
            ->setValidators(array(new Zend_Validate_Alnum()));
        $this->addElement($numero);

        //2e ..
        $porte = new Zend_Form_Element_Text('porte');
        $porte->isRequired(false)
            ->setLabel('Numéro de porte :')
            ->setValidators(array(new Zend_Validate_Alnum()));
        $this->addElement($porte);


        //4e ..
        $etage = new Zend_Form_Element_Text('etage');
        $etage->isRequired(false)
            ->setLabel('Etage : ')
            ->setValidators(array(new Zend_Validate_Int()));
        $this->addElement($etage);

        //5 ..
        $immeuble = new Zend_Form_Element_Text('immeuble');
        $immeuble->isRequired(false)
            ->setLabel('Immeuble : ')
            ->setValidators(array(new Zend_Validate_Int()));
        $this->addElement($immeuble);

        //6 ..
        $adresse = new Zend_Form_Element_Text('adresse');
        $adresse->isRequired(true)
            ->setLabel('*Adresse : ')
            ->setValidators(array(new Zend_Validate_Alnum()));
        $this->addElement($adresse);

        //7 ..
        $codePostal = new Zend_Form_Element_Text('codePostal');
        $codePostal->isRequired(true)
            ->setLabel('*Code Postal : ')
            ->setValidators(array(new Zend_Validate_Int()));
        $this->addElement($codePostal);

        //8 ..
        $labelVille = new Zend_Form_Element_Text('ville');
        $labelVille->isRequired(true)
            ->setLabel('*Ville : ')
            ->setValidators(array(new Zend_Validate_Alpha));
        $this->addElement($labelVille);

        //9..
        $etatProvince = new Zend_Form_Element_Text('etatProvince');
        $etatProvince->isRequired(false)
            ->setLabel('Etat / Province : ')
            ->setValidators(array(new Zend_Validate_Alpha()));
        $this->addElement($etatProvince);

        //10 ..
        $labelPays = new Zend_Form_Element_Text('pays');
        $labelPays->isRequired(true)
            ->setLAbel('*Pays : ')
            ->setValidators(array(new Zend_Validate_Alpha));
        $this->addElement($labelPays);

        //11e ..
        $commentaire = Zend_Form_Element_Textarea('commentaire');
        $commentaire->isRequired(false)
            ->setLabel('Commentaires : ')
            ->setValidators(array(Zend_Validate_Alnum()));
        $this->addElement($commentaire);

        //Submit ..
        $this->addElement('submit','valider',array('label' => 'Valider'));
    }

}