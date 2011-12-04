<?php

class ServDRH_Model_Employe
{
    protected $_Personne_noPersonne;
    protected $_labelMetier;
    
    public function saveEmploye() {
        $mapper = new ServDRH_Model_EmployeMapper();
        $mapper->saveByLabel($this, 'Personne_noPersonne');
    }
    
    public function delEmploye($noPersonne){
        $mapper = new ServDRH_Model_EmployeMapper();
        try {
           $mapper->delete("Personne_noPersonne", $noPersonne);
           
            }
        catch (Zend_Exception $e) 
            {
            echo 'ServDRH_Model_EmployeMapper_delEmploye() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
            
            }         
    }

    public function getEmployes(){
        $mapper = new ServDRH_Model_EmployeMapper();
        return $mapper->findAll();
    }
    
    public function getEmployeByPersonneNoPersonne($noPersonne) {
        $mapper = new ServDRH_Model_EmployeMapper();
        return $mapper->findByNoPersonne($noPersonne);
    }

    //Permet de récupérer la liste des congés de l'employé
    public function get_listeConges()
    {
         $conge = new Application_Module_ServDRH_CongeMapper();
         $listeConges = $conge->_getConges($this->_Personne_noPersonne);
         
         return $listeConges;
    }

    //Permet de récupérer la liste des habilitations d'une personne
    public function get_listeHabilitations()
    {
        $habilitations = new Application_Module_ServDRH_HabilitationMapper();
        $listeHabilitations = $habilitations->_getHabilitations($this->_labelMetier);
        
        return $listeHabilitations;
    }

    public function get_Personne_noPersonne() 
    {
        return $this->_Personne_noPersonne;
    }

    public function set_Personne_noPersonne($_Personne_noPersonne) 
    {
        $this->_Personne_noPersonne = $_Personne_noPersonne;
        return $this;
    }

    public function get_labelMetier() 
    {
        return $this->_labelMetier;
    }

    public function set_labelMetier($_labelMetier) 
    {
        $this->_labelMetier = $_labelMetier;
        return $this;
    }
}

?>
