<?php

class ServDRH_Model_Conge
{
    protected $_noConge;
    protected $_dateDebut = "02-03-2011"; 
    protected $_dateFin = "16-03-2011";
    protected $_valider;
    protected $_enAttentedeTraitement = 1; //pour phpunit
    protected $_motif;
    protected $_labelTypeConge;
    protected $_noPersonne;
    protected $_dateDebut_Annee = "01-01-2011";
    
     public function getConges(){
        $mapper = new ServDRH_Model_CongeMapper();
        return $mapper->findAll();
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
