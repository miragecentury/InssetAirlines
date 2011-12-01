<?php

/**
 * Description of modifAdresse
 *
 * @author pewho
 */
class Application_Form_Utilisateur_modifAdresse extends Zend_Form
{

    protected $_capsule;
    protected $_petiteCapsule;
    protected $_capsuleReboot;
protected $_submitCapsule;

    public function init()
    {
//init
        $this->_petiteCapsule = array(
            "ViewHelper",
            array("Label", array('requiredPrefix' => '*', 'tag' => 'span', 'class' => 'grid_2')),
            array("Errors", array('tag' => 'span', 'class' => 'red')),
            array("HtmlTag", array('tag' => 'div', 'class' => 'sep grid_4')));
        $this->_capsule = array(
            "ViewHelper",
            array("Label", array('requiredPrefix' => '*', 'tag' => 'span', 'class' => 'grid_2')),
            array("Errors", array('tag' => 'span', 'class' => 'red')),
            array("HtmlTag", array('tag' => 'div', 'class' => 'sep grid_7')));
        $this->_capsuleReboot = array(
            "ViewHelper",
            array("Label", array( 'tag' => 'hr')),
            array("Errors", array('tag' => 'span', 'class' => 'red')),
            array("HtmlTag", array('tag' => 'div', 'class' => 'clear sep')));
        $this->_submitCapsule = array(
            "ViewHelper",
            array("HtmlTag", array('tag' => 'div', 'class' => 'prefix_6')));

//Methode du form
        $this->setMethod('POST');
//1er element
        $numero = new Zend_Form_Element_Text('numero');
        $numero->setRequired(true);
        $numero->setAttrib('size', '4');
        $numero->setLabel('Numero : ');
        $numero->setValidators(array(new Zend_Validate_Int()));
        $numero->setDecorators($this->_petiteCapsule);

        $this->addElement($numero);

//2e ..
        $porte = new Zend_Form_Element_Text('porte');
        $porte->setRequired(false)
            ->setLabel('Porte :')
            ->setAttrib('size', '4')
            ->setValidators(array(new Zend_Validate_Alnum(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_petiteCapsule);
        $this->addElement($porte);


//4e ..
        $etage = new Zend_Form_Element_Text('etage');
        $etage->setRequired(false)
            ->setLabel('Etage : ')
            ->setAttrib('size', '4')
            ->setValidators(array(new Zend_Validate_Int()))
            ->setDecorators($this->_petiteCapsule);
        $this->addElement($etage);

//5 ..
        $immeuble = new Zend_Form_Element_Text('immeuble');
        $immeuble->setRequired(false)
            ->setLabel('Immeuble : ')
            ->setAttrib('size', '10')
            ->setValidators(array(new Zend_Validate_Alnum(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_capsule);
        $this->addElement($immeuble);

        //clear
        $hidden = new Zend_Form_Element_Hidden('clear');
        $hidden->setDecorators($this->_capsuleReboot);

       $this->addElement($hidden);
//6 ..
        $adresse = new Zend_Form_Element_Text('adresse');
        $adresse->setRequired(true)
            ->setLabel('Adresse : ')
            ->setAttrib('size', '14')
            ->setValidators(array(new Zend_Validate_Alnum(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_capsule);
        $this->addElement($adresse);

//7 ..
        $codePostal = new Zend_Form_Element_Text('codePostal');
        $codePostal->setRequired(true)
            ->setLabel('Code Postal : ')
            ->setAttrib('size', '5')
            ->setValidators(array(new Zend_Validate_PostCode('fr_FR')))
            ->setDecorators($this->_capsule);
        $this->addElement($codePostal);

//8 ..
        $labelVille = new Zend_Form_Element_Text('ville');
        $labelVille->setRequired(true)
            ->setLabel('Ville : ')
            ->setAttrib('size', '14')
            ->setValidators(array(new Zend_Validate_Alpha(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_capsule);
        $this->addElement($labelVille);

//9..
        $etatProvince = new Zend_Form_Element_Text('etatProvince');
        $etatProvince->setRequired(false)
            ->setLabel('Etat / Province : ')
            ->setAttrib('size', '14')
            ->setValidators(array(new Zend_Validate_Alpha(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_capsule);
        $this->addElement($etatProvince);

//10 ..
        $labelPays = new Zend_Form_Element_Text('pays');
        $labelPays->setRequired(true)
            ->setLAbel('Pays : ')
            ->setAttrib('size', '14')
            ->setValidators(array(new Zend_Validate_Alpha(array('allowWhiteSpace' => true))))
            ->setDecorators($this->_capsule);
        $this->addElement($labelPays);

//11e ..
        $commentaire = new Zend_Form_Element_Textarea('commentaire');
        $commentaire->setRequired(false)
            ->setLabel('Commentaires : ')
            ->setAttrib('cols', '35')
            ->setAttrib('rows', '4')
            ->setDecorators($this->_capsule)
            ->setValidators(array(new Zend_Validate_Alnum(array('allowWhiteSpace' => true))));
        $this->addElement($commentaire);

        //clear
        $hidden2 = new Zend_Form_Element_Hidden('clear2');
        $hidden2->setDecorators($this->_capsuleReboot);

       $this->addElement($hidden2);

//Submit ..
        $submit = new Zend_Form_Element_Submit('valider');
        $submit->setLabel('Valider')
        ->setDecorators($this->_submitCapsule);

       $this->addElement($submit);
    }

}