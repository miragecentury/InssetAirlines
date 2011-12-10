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
        
        $nom = new Zend_Form_Element_Text("nom");
        $nom->setLabel("Nom*")
            //Indique que le champ est obligatoire
            ->setRequired(true)
            //Efface/Empeche les balises de code sur la variable
            ->addFilter("StripTags")
            //Efface les espaces en trop en début et/ou en fin de variable
            ->addFilter("StringTrim")
            //Vérifie que le champ n'est pas vide 
            ->setAttrib('size', 12)
            //Limite le nombre de caractères max 
            ->addValidator("StringLength", false, array(1, 45));
            //->removeDecorator("DtDdWrapper");
        //$nom->getDecorator('label')->setOption('tag', null);
        
        $prenom = new Zend_Form_Element_Text('prenom');
        $prenom->setLabel('Prénom*')
               ->setAttrib('size', 12)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('StringLength', false, array(1, 45))
               ->addValidator('notEmpty')
               ->setRequired(true);
        
        $prenom2 = new Zend_Form_Element_Text('prenom2');
        $prenom2->setLabel('Deuxième prénom')
                ->setAttrib('size', 12)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('StringLength', false, array(0, 45))
                ->setRequired(false);
        
        $prenom3 = new Zend_Form_Element_Text('prenom3');
        $prenom3->setLabel('Troisième prénom')
                ->setAttrib('size', 12)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('StringLength', false, array(0, 45))
                ->setRequired(false);
        
        /*$dateNaissance = new Zend_Form_Element_Text('dateNaissance');
        $dateNaissance->setLabel('Date de naissance (aaaa-mm-jj)*');
        $dateNaissance->addFilter('StripTags');
        $dateNaissance->addFilter('StringTrim');
        $dateNaissance->setRequired(true);
        $dateNaissance->getDecorator('label')->setOption('tag', null);*/
        
        $jourNaissance = new Zend_Form_Element_Select('jourNaissance');
        $jourNaissance->setLabel('Jour de naissance');
        $jourNaissance->addMultiOption('','');
        for ($i=1; $i<=31; $i++) {
            $jourNaissance->addMultiOption($i, $i);
        }            
        $jourNaissance->addValidator('notEmpty');
        $jourNaissance->addFilter('StripTags');
        $jourNaissance->addFilter('StringTrim');
        $jourNaissance->setRequired(true);
        
        $moisNaissance = new Zend_Form_Element_Select('moisNaissance');
        $moisNaissance->setLabel('Mois de naissance');
        $moisNaissance->addMultiOption('','');
        for ($i=1; $i<=12; $i++) {
            $moisNaissance->addMultiOption($i, $i);
        }
        $moisNaissance->addValidator('notEmpty');
        $moisNaissance->addFilter('StripTags');
        $moisNaissance->addFilter('StringTrim');
        $moisNaissance->setRequired(true);
        
        $anneeNaissance = new Zend_Form_Element_Select('anneeNaissance');
        $anneeNaissance->setLabel('Année de naissance');
        $anneeNaissance->addMultiOption('','');
        for ($i=date('Y'); $i>=1900; $i--) {
            $anneeNaissance->addMultiOption($i, $i);
        }
        $anneeNaissance->addValidator('notEmpty');
        $anneeNaissance->addFilter('StripTags');
        $anneeNaissance->addFilter('StringTrim');
        $anneeNaissance->setRequired(true);
        
        $noAdresse = new Zend_Form_Element_Text('numero');
        $noAdresse->setLabel('Numéro*')
                  ->setAttrib('size', 3)
                  ->addValidator('notEmpty')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('StringLength', false, array(1,3))
                  ->setRequired(true);        
        
        $labelAdresse = new Zend_Form_Element_Text('labelAdresse');
        $labelAdresse->setLabel('Adresse*')
                     ->setAttrib('size', 20)
                     ->addValidator('notEmpty')
                     ->addFilter('StripTags')
                     ->addFilter('StringTrim')
                     ->addValidator('StringLength', false, array(1,200))
                     ->setRequired(true);
        
        $immeuble = new Zend_Form_Element_Text('immeuble');
        $immeuble->setLabel('Immeuble')
                 ->setAttrib('size', 12)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('StringLength', false, array(0,45))
                 ->setRequired(false);
        
        $etage = new Zend_Form_Element_Text('etage');
        $etage->setLabel('Etage')
              ->setAttrib('size', 3)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(0,45))
              ->setRequired(false);
        
        $porte = new Zend_Form_Element_Text('porte');
        $porte->setLabel('Porte ') 
              ->setAttrib('size', 12)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(0,45))
              ->setRequired(false);
        
        $cp = new Zend_Form_Element_Text('cp');
        $cp->setLabel('Code postal*') 
           ->setAttrib('size', 5)
           ->addValidator('notEmpty')
           ->addFilter('StripTags')
           ->addFilter('StringTrim')
           ->addValidator('StringLength', false, array(1, 45))
           ->setRequired(true);
        
        $etatProvince = new Zend_Form_Element_Text('etatProvince');
        $etatProvince->setLabel('Etat/Province*')
                     ->addValidator('notEmpty')
                     ->addFilter('StripTags')
                     ->addFilter('StringTrim')
                     ->addValidator('StringLength', false, array(1, 50))
                     ->setRequired(true);
        
        $ville = new Zend_Form_Element_Text('ville');
        $ville->setLabel('Ville*') 
              ->setAttrib('size', 12)
              ->addValidator('notEmpty')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(1, 50))
              ->setRequired(true);
        
        $pays = new Zend_Form_Element_Text('pays');
        $pays->setLabel('Pays*')
             ->setAttrib('size', 12)
             ->addValidator('notEmpty')
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('StringLength', false, array(1, 45))
             ->setRequired(true);
        
        $noINSEE = new Zend_Form_Element_Text('noINSEE');
        $noINSEE->setLabel('No INSEE*')
                ->setAttrib('size', 12)
                ->addValidator('notEmpty')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('StringLength', false, array(11))
                ->setRequired(true);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail*')
              ->setAttrib('size', 12)
              ->addValidator('notEmpty')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('StringLength', false, array(1,200))
              ->setRequired(true);
        
        $role = new Zend_Form_Element_Select('role');
        $role->setLabel('Role')
             ->addMultiOption('', '')
             ->addMultiOptions(array('Serv_Ag' => 'Serv_Ag',
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
                                     'Serv_Stra_Adm' => 'Serv_Stra_Adm'))
             ->setRequired(false);
                    
        $labelMetier = new Zend_Form_Element_Select('labelMetier');
        $labelMetier->setLabel('Métier');
        $labelMetier->addMultiOption('', '');
        $labelMetier->setRequired(false);
        foreach ($listeMetiers as $metier) {
            $labelMetier->addMultiOption($metier->get_labelMetier(), $metier->get_labelMetier());
        }                    
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Mot de passe (6 carac. min.)')
                 ->setAttrib('size', 12)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('StringLength', false, array(6, 32))
                 ->setRequired(false);
        
        $passwordConfirm = new Zend_Form_Element_Password('passwordConfirm');
        $passwordConfirm->setLabel('Confirmation du mot de passe')
                        ->setAttrib('size', 12)
                        ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('StringLength', false, array(6, 32))
                        ->setRequired(false);
        
        $labelhabilitation = new Zend_Form_Element_MultiCheckbox('habilitation');
        $labelhabilitation->setLabel('Choisissez une habilitation');
        foreach ($listehabilitations as $habilitation) {
            $labelhabilitation->addMultiOption($habilitation->get_noHabilitation(), $habilitation->get_labelHabilitation());
        }
        $labelhabilitation->setRequired(false);        
        
        $submit = new Zend_Form_Element_Submit('enregistrer');
        $submit->setLabel('Enregistrer');
        //$submit->setIgnore(true);
        
        $cancel = new Zend_Form_Element_Submit('annuler');
        $cancel->setLabel('Annuler');
        //$cancel->setIgnore(true);
        
        $this->addElements(array($nom, $prenom, $prenom2, $prenom3, 
            $jourNaissance, $moisNaissance, $anneeNaissance, $noAdresse,
            $immeuble, $etage, $porte, $labelAdresse, $cp, $etatProvince, 
            $ville, $pays, $noINSEE, $email, $role, $labelMetier, $password, 
            $passwordConfirm, $labelhabilitation, $submit, $cancel));
        
        //$this->setDecorators(array(array('ViewScript', array('viewScript' => '/gestpilote/fmAjoutPersonne.phtml'))));
    }
}

?>
