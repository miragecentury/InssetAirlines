<?php

/**
 * Description of modifAdresse
 *
 * @author pewho
 */
class Application_Form_Utilisateur_modifAdresse extends Zend_Form
{

    private $_capsule;
    private $_capsuleReboot;
    private $_formDeco = array("ViewHelper",
        array("HtmlTag", array('tag' => 'div', 'class' => 'grid_14 preffix_1 suffix_1')));
    );

    public function init()
    {

//Methode du form
        $this->setMethod('POST');
        $this->addDecorator($this->_formDeco);

//init
        $this->_capsule = array(
            "ViewHelper",
            array("Label", array('requiredPrefix' => '*', 'tag' => 'span')),
            array("Errors", array('tag' => 'span', 'class' => 'red')),
            array("HtmlTag", array('tag' => 'div', 'class' => 'sep grid_7')));
        $this->_capsuleReboot = array(
            "ViewHelper",
            array("Label", array('requiredPrefix' => '*', 'tag' => 'span')),
            array("Errors", array('tag' => 'span', 'class' => 'red')),
            array("HtmlTag", array('tag' => 'div', 'class' => 'sep grid_7')));

//1er element
        $numero = new Zend_Form_Element_Text('numero');
        $numero->isRequired(true)
            ->setLabel('*Numero : ')
            ->setValidators(array(new Zend_Validate_Alnum()))
            ->addDecorator($this->_capsule);

        $this->addElement($numero);

//2e ..
        $porte = new Zend_Form_Element_Text('porte');
        $porte->isRequired(false)
            ->setLabel('Numéro de porte :')
            ->setValidators(array(new Zend_Validate_Alnum()))
            ->addDecorator($this->_capsule);
        $this->addElement($porte);


//4e ..
        $etage = new Zend_Form_Element_Text('etage');
        $etage->isRequired(false)
            ->setLabel('Etage : ')
            ->setValidators(array(new Zend_Validate_Int()))
            ->addDecorator($this->_capsule);
        $this->addElement($etage);

//5 ..
        $immeuble = new Zend_Form_Element_Text('immeuble');
        $immeuble->isRequired(false)
            ->setLabel('Immeuble : ')
            ->setValidators(array(new Zend_Validate_Int()))
            ->addDecorator($this->_capsule);
        $this->addElement($immeuble);

//6 ..
        $adresse = new Zend_Form_Element_Text('adresse');
        $adresse->isRequired(true)
            ->setLabel('*Adresse : ')
            ->setValidators(array(new Zend_Validate_Alnum()))
            ->addDecorator($this->_capsule);
        $this->addElement($adresse);

//7 ..
        $codePostal = new Zend_Form_Element_Text('codePostal');
        $codePostal->isRequired(true)
            ->setLabel('*Code Postal : ')
            ->setValidators(array(new Zend_Validate_Int()))
            ->addDecorator($this->_capsule);
        $this->addElement($codePostal);

//8 ..
        $labelVille = new Zend_Form_Element_Text('ville');
        $labelVille->isRequired(true)
            ->setLabel('*Ville : ')
            ->setValidators(array(new Zend_Validate_Alpha()))
            ->addDecorator($this->_capsule);
        $this->addElement($labelVille);

//9..
        $etatProvince = new Zend_Form_Element_Text('etatProvince');
        $etatProvince->isRequired(false)
            ->setLabel('Etat / Province : ')
            ->setValidators(array(new Zend_Validate_Alpha()))
            ->addDecorator($this->_capsule);
        $this->addElement($etatProvince);

//10 ..
        $labelPays = new Zend_Form_Element_Text('pays');
        $labelPays->isRequired(true)
            ->setLAbel('*Pays : ')
            ->setValidators(array(new Zend_Validate_Alpha()))
            ->addDecorator($this->_capsule);
        $this->addElement($labelPays);

//11e ..
        $commentaire = Zend_Form_Element_Textarea('commentaire');
        $commentaire->isRequired(false)
            ->setLabel('Commentaires : ')
            ->setValidators(array(Zend_Validate_Alnum()))
            ->addDecorator($this->_capsule);
        $this->addElement($commentaire);

//Submit ..
        $this->addElement('submit', 'valider', array('label' => 'Valider'));
    }
}