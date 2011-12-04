<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestpilote
 *
 * @author camille
 */
class ServDRH_Form_gestpilote extends Zend_Form
{
    public function init(){       
        $listeMetiers = ServDRH_Model_Metier::getMetiers();
        $listehabilitations = ServDRH_Model_Habilitation::getHabilitations();
        
        $this->setMethod('POST')
            ->setName('nouvel_employe');
        
        $nom = new Zend_Form_Element_Text('nom');
        $nom->setLabel('Nom*');
        //Efface/Empeche les balises de code sur la variable
        $nom->addFilter('StripTags');
        //Efface les espaces en trop en début et/ou en fin de variable
        $nom->addFilter('StringTrim');
        //Limite le nombre de caractères max 
        $nom->addValidator('StringLength', false, array(1, 45));
        //Indique que le champ est obligatoire
        $nom->setRequired(true);
        $nom->getDecorator('label')->setOption('tag', null);
        
        $prenom = new Zend_Form_Element_Text('prenom');
        $prenom->setLabel('Prénom*');
        $prenom->addFilter('StripTags');
        $prenom->addFilter('StringTrim');
        $prenom->addValidator('StringLength', false, array(1, 45));
        $prenom->setRequired(true);
        $prenom->getDecorator('label')->setOption('tag', null);
        
        $prenom2 = new Zend_Form_Element_Text('prenom2');
        $prenom2->setLabel('Deuxième prénom');
        $prenom2->addFilter('StripTags');
        $prenom2->addFilter('StringTrim');
        $prenom2->addValidator('StringLength', false, array(0, 45));
        $prenom2->setRequired(false);
        $prenom2->getDecorator('label')->setOption('tag', null);
        
        $prenom3 = new Zend_Form_Element_Text('prenom3');
        $prenom3->setLabel('Troisième prénom');
        $prenom3->addFilter('StripTags');
        $prenom3->addFilter('StringTrim');
        $prenom3->addValidator('StringLength', false, array(0, 45));
        $prenom3->setRequired(false);
        $prenom3->getDecorator('label')->setOption('tag', null);
        
        $dateNaissance = new Zend_Form_Element_Text('dateNaissance');
        $dateNaissance->setLabel('Date de naissance (aaaa-mm-jj)*');
        $dateNaissance->addFilter('StripTags');
        $dateNaissance->addFilter('StringTrim');
        $dateNaissance->setRequired(true);
        $dateNaissance->getDecorator('label')->setOption('tag', null);
        
        $noAdresse = new Zend_Form_Element_Text('numero');
        $noAdresse->setLabel('Numéro*'); 
        $noAdresse->addFilter('StripTags');
        $noAdresse->addFilter('StringTrim');
        $noAdresse->addValidator('StringLength', false, array(1,3));
        $noAdresse->setRequired(true);
        $noAdresse->getDecorator('label')->setOption('tag', null);
        
        $labelAdresse = new Zend_Form_Element_Text('labelAdresse');
        $labelAdresse->setLabel('Adresse*'); 
        $labelAdresse->addFilter('StripTags');
        $labelAdresse->addFilter('StringTrim');
        $labelAdresse->addValidator('StringLength', false, array(1,200));
        $labelAdresse->setRequired(true);
        $labelAdresse->getDecorator('label')->setOption('tag', null);
        
        $immeuble = new Zend_Form_Element_Text('immeuble');
        $immeuble->setLabel('Immeuble'); 
        $immeuble->addFilter('StripTags');
        $immeuble->addFilter('StringTrim');
        $immeuble->addValidator('StringLength', false, array(0,45));
        $immeuble->setRequired(false);
        $immeuble->getDecorator('label')->setOption('tag', null);
        
        $etage = new Zend_Form_Element_Text('etage');
        $etage->setLabel('Etage'); 
        $etage->addFilter('StripTags');
        $etage->addFilter('StringTrim');
        $etage->addValidator('StringLength', false, array(0,45));
        $etage->setRequired(false);
        $etage->getDecorator('label')->setOption('tag', null);
        
        $porte = new Zend_Form_Element_Text('porte');
        $porte->setLabel('Porte '); 
        $porte->addFilter('StripTags');
        $porte->addFilter('StringTrim');
        $porte->addValidator('StringLength', false, array(0,45));
        $porte->setRequired(false);
        $porte->getDecorator('label')->setOption('tag', null);
        
        $cp = new Zend_Form_Element_Text('cp');
        $cp->setLabel('Code postal*'); 
        $cp->addFilter('StripTags');
        $cp->addFilter('StringTrim');
        $cp->addValidator('StringLength', false, array(1, 45));
        $cp->setRequired(true);
        $cp->getDecorator('label')->setOption('tag', null);
        
        $etatProvince = new Zend_Form_Element_Text('etatProvince');
        $etatProvince->setLabel('Etat/Province*'); 
        $etatProvince->addFilter('StripTags');
        $etatProvince->addFilter('StringTrim');
        $etatProvince->addValidator('StringLength', false, array(1, 50));
        $etatProvince->setRequired(true);
        $etatProvince->getDecorator('label')->setOption('tag', null);
        
        $ville = new Zend_Form_Element_Text('ville');
        $ville->setLabel('Ville*'); 
        $ville->addFilter('StripTags');
        $ville->addFilter('StringTrim');
        $ville->addValidator('StringLength', false, array(1, 50));
        $ville->setRequired(true);
        $ville->getDecorator('label')->setOption('tag', null);
        
        $pays = new Zend_Form_Element_Text('pays');
        $pays->setLabel('Pays*'); 
        $pays->addFilter('StripTags');
        $pays->addFilter('StringTrim');
        $pays->addValidator('StringLength', false, array(1, 45));
        $pays->setRequired(true);
        $pays->getDecorator('label')->setOption('tag', null);
        
        $noINSEE = new Zend_Form_Element_Text('noINSEE');
        $noINSEE->setLabel('No INSEE*');
        $noINSEE->addFilter('StripTags');
        $noINSEE->addFilter('StringTrim');
        $noINSEE->addValidator('StringLength', false, array(11));
        $noINSEE->setRequired(true);
        $noINSEE->getDecorator('label')->setOption('tag', null);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail*');
        $email->addFilter('StripTags');
        $email->addFilter('StringTrim');
        $email->addValidator('StringLength', false, array(1,200));
        $email->setRequired(true);
        $email->getDecorator('label')->setOption('tag', null);
        
        $role = new Zend_Form_Element_Select('role');
        $role->setLabel('Role');
        $role->addMultiOption('', '');
        $role->addMultiOptions(array('Serv_Ag' => 'Serv_Ag', 
                                     'Serv_Ag_Adm' => 'Serv_Ag_Adm', 
                                     'Serv_Com' => 'Serv_Com', 
                                     'Serv_Com_Adm' => 'Serv_Com_Adm',
                                     'Serv_DRH' => 'Serv_DRH',
                                     'Serv_DRH_Adm' => 'Serv_DRH_Adm', 
                                     'Serv_Exp' => 'Serv_Exp', 
                                     'Serv_Exp_Adm' => 'Serv_Exp_Adm',
                                     'Serv_Log' => 'Serv_Log', 
                                     'Serv_Log_Adm' => 'Serv_Log_Adm',
                                     'Serv_Maint' => 'Serv_Maint',
                                     'Serv_Maint_Adm' => 'Serv_Maint_Adm',
                                     'Serv_Plan' => 'Serv_Plan', 
                                     'Serv_Plan_Adm' => 'Serv_Plan_Adm',
                                     'Serv_Stra' => 'Serv_Stra', 
                                     'Serv_Stra_Adm' => 'Serv_Stra_Adm'));
        $role->setRequired(false);
                    
        $labelMetier = new Zend_Form_Element_Select('labelMetier');
        $labelMetier->setLabel('Métier');
        $labelMetier->addMultiOption('', '');
        foreach ($listeMetiers as $metier) {
            $labelMetier->addMultiOption($metier->get_labelMetier(), $metier->get_labelMetier());
        }
        $labelMetier->setRequired(false);
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Mot de passe (6 carac. min.)');
        $password->addFilter('StripTags');
        $password->addFilter('StringTrim');
        $password->addValidator('StringLength', false, array(6, 32));
        $password->setRequired(false);
        $password->getDecorator('label')->setOption('tag', null);
        
        $passwordConfirm = new Zend_Form_Element_Password('passwordConfirm');
        $passwordConfirm->setLabel('Confirmation du mot de passe');
        $passwordConfirm->addFilter('StripTags');
        $passwordConfirm->addFilter('StringTrim');
        $passwordConfirm->addValidator('StringLength', false, array(6, 32));
        $passwordConfirm->setRequired(false);
        $passwordConfirm->getDecorator('label')->setOption('tag', null);
        
        $labelhabilitation = new Zend_Form_Element_MultiCheckbox('habilitation');
        $labelhabilitation->setLabel('Choisissez une habilitation');
        foreach ($listehabilitations as $habilitation) {
            $labelhabilitation->addMultiOption($habilitation->get_noHabilitation(), $habilitation->get_labelHabilitation());
        }
        $labelhabilitation->setRequired(false);        
        
        $submit = new Zend_Form_Element_Submit('enregistrer');
        $submit->setLabel('Enregistrer');
        $submit->setIgnore(true);
        
        $cancel = new Zend_Form_Element_Submit('annuler');
        $cancel->setLabel('Annuler');
        $cancel->setIgnore(true);
        
        $this->addElement($nom);
        $this->addElement($prenom);
        $this->addElement($prenom2);
        $this->addElement($prenom3);
        $this->addElement($dateNaissance);
        $this->addElement($noAdresse);
        $this->addElement($labelAdresse);
        $this->addElement($immeuble);
        $this->addElement($etage);
        $this->addElement($porte);
        $this->addElement($cp);
        $this->addElement($etatProvince);
        $this->addElement($ville);
        $this->addElement($pays);
        $this->addElement($noINSEE);
        $this->addElement($email);
        $this->addElement($role);
        $this->addElement($labelMetier);
        $this->addElement($password);
        $this->addElement($passwordConfirm);
        $this->addElements(array($labelhabilitation));
        $this->addElement($submit);
        $this->addElement($cancel);
        
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '/gestpilote/fmAjoutPersonne.phtml'))));
    }
}

?>
