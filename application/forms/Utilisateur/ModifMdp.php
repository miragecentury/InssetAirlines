<?php

/**
 * Description of ModifMdp
 *
 * Formulaire permetant le changement de mdp d'un utilisateur
 *
 * @author pewho
 */
class Application_Form_Utilisateur_ModifMdp extends Zend_Form
{

    public function init()
    {
        //Methode du form
        $this->setMethod('POST');

        //declaration des validateurs
        $chaineMin = new Zend_Validate_StringLength(array('min' => 6));
        $chaineValid = new Zend_Validate_Alnum();

         //declaration du premier element (ancien Mdp)
        $ancien = new Zend_Form_Element_Password('ancienMdp');
        $ancien->setRequired(true)
            ->setLabel('Ancien Mot de passe : ');
        $this->addElement($ancien);

        //declaration du second (nouveau Mdp)
        $nouveau = new Zend_Form_Element_Password('nouveauMdp');
        $nouveau->setLabel('Nouveau Mot de passe : ')
            ->setRequired(true)
            ->setValidators(array($chaineMin,$chaineValid));
        $this->addElement($nouveau);

        //Declaration du troisieme (verification du Mdp)
        $verif = new Zend_Form_Element_Password('verifMdp');
        $verif->setLabel('Retapez le nouveau mot de passe : ')
            ->setRequired(true)
            ->setValidators(
                array(
                    $chaineMin,
                    $chaineValid
                    ));
        $this->addElement($verif);

        //declaration du submit
        $this->addElement('submit','valider',array('label' => 'Valider'));
    }

}

?>
