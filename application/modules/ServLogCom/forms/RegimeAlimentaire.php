<?php

/**
 * Description of ServExploitation_Form_Incident
 * 
 * Formulaire d'ajout ou modificication d'incident
 *
 * @author charles
 */
class ServLogCom_Form_RegimeAlimentaire extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        
        //Validator
        $alnum = new Zend_Validate_Alnum(array("allowWhiteSpace"=>true));
        
        //Creation du champ permettant d'entrer un labeltypeincident
        $labelRegimeAlimentaire = new Zend_Form_Element_Text('labelRegimeAlimentaire');
        $labelRegimeAlimentaire->setLabel('Label :');
        $labelRegimeAlimentaire->setValidators(array($alnum));
        $labelRegimeAlimentaire->setRequired();

        $menu = new Zend_Form_Element_Multiselect('LstMenu');
        $menu->setLabel('Menu');
        $allmenu = ServLogCom_Model_Menu::getListeMenu();
        foreach ($allmenu as $val) {
            $menu->addMultiOption($val->get_idMenu(),$val->get_labelMenu());
        }
        
        //Creation du submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Valider');
        $submit->setIgnore(true);

        //Creation du formulaire
        $this->addElement($labelRegimeAlimentaire);
        $this->addElement($menu);
        $this->addElement($submit);
    }

}

?>
