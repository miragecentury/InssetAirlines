<?php

class ServDRH_Model_Conge
{
    protected $_noConge;
    protected $_dateDebut; 
    protected $_dateFin;
    protected $_valider;
    protected $_enAttentedeTraitement;
    protected $_motif;
    protected $_labelTypeConge;
    protected $_noPersonne;
    protected $_dateDebut_Annee;
    
    public function getCongesByNoPersonne($noPersonne){
        $mapper = new ServDRH_Model_CongeMapper();
        return $mapper->_getConges($noPersonne);
    }
    
    public function getCongeByNoConge($noConge) {
        $mapper = new ServDRH_Model_CongeMapper();
        return $mapper->find($noConge);
    }
    
    public function saveConge() {
        $mapper = new ServDRH_Model_CongeMapper();
        $mapper->saveByLabel($this, 'noConge');
    }
    
    public function delete($noConge) {
        $mapper = new ServDRH_Model_CongeMapper();
        $mapper->delete('noConge', $noConge);
    }
    
    public function get_noConge() 
    {
        return $this->_noConge;
    }

    public function set_noConge($_noConge)
    {
        $this->_noConge = $_noConge;
    }

    public function get_dateDebut() 
    {
        return $this->_dateDebut;
    }

    public function set_dateDebut($_dateDebut) 
    {
        $this->_dateDebut = $_dateDebut;
    }

    public function get_dateFin() 
    {
        return $this->_dateFin;
    }

    public function set_dateFin($_dateFin) 
    {
        $this->_dateFin = $_dateFin;
    }

    public function get_valider() 
    {
        return $this->_valider;
    }

    public function set_valider($_valider)
    {
        $this->_valider = $_valider;
    }

    public function get_enAttentedeTraitement() 
    {
        return $this->_enAttentedeTraitement;
    }

    public function set_enAttentedeTraitement($_enAttentedeTraitement) 
    {
        $this->_enAttentedeTraitement = $_enAttentedeTraitement;
    }

    public function get_motif() 
    {
        return $this->_motif;
    }

    public function set_motif($_motif)
    {
        $this->_motif = $_motif;
    }

    public function get_labelTypeConge()
    {
        return $this->_labelTypeConge;
    }

    public function set_labelTypeConge($_labelTypeConge)
    {
        $this->_labelTypeConge = $_labelTypeConge;
    }

    public function get_noPersonne()
    {
        return $this->_noPersonne;
    }

    public function set_noPersonne($_noPersonne) 
    {
        $this->_noPersonne = $_noPersonne;
    }

    public function get_dateDebut_Annee()
    {
        return $this->_dateDebut_Annee;
    }

    public function set_dateDebut_Annee($_dateDebut_Annee)
    {
        $this->_dateDebut_Annee = $_dateDebut_Annee;
    }


}

?>
