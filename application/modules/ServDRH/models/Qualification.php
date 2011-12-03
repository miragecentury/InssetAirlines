<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Qualification
 *
 * @author camille
 */
class ServDRH_Model_Qualification
{
    protected $_Employe_Personne_noPersonne;
    protected $_Habilitation_noHabilitation;
    protected $_mapper;
    
    public function __construct() {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServDRH_Model_Qualification");
    }
    
    public function getQualificationsByNoPersonne($noPersonne) {
        try {            
            $qualifications = $this->_mapper->findByNoPersonne($noPersonne);            
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
        return $qualifications;
    }
    
    public function save() {
        $this->_mapper->saveQualification(
            $this, 
            $this->get_Employe_Personne_noPersonne(), 
            $this->get_Habilitation_noHabilitation());
        
    }
    
    public function delete($noPersonne, $noHabilitation) {
        $this->_mapper->deleteQualification($noPersonne, $noHabilitation);
    }
    
    public function get_Employe_Personne_noPersonne() {
        return $this->_Employe_Personne_noPersonne;
    }

    public function set_Employe_Personne_noPersonne($_Employe_Personne_noPersonne) {
        $this->_Employe_Personne_noPersonne = $_Employe_Personne_noPersonne;
    }

    public function get_Habilitation_noHabilitation() {
        return $this->_Habilitation_noHabilitation;
    }

    public function set_Habilitation_noHabilitation($_Habilitation_noHabilitation) {
        $this->_Habilitation_noHabilitation = $_Habilitation_noHabilitation;
    }


}

?>
