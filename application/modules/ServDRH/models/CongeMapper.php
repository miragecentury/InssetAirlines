<?php
class ServDRH_Model_CongeMapper extends Spesx_Mapper_Mapper {
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Conge();
        $item->set_noConge($row->noConge)
             ->set_dateDebut($row->dateDebut)
             ->set_dateFin($row->dateFin)
             ->set_valider($row->valider)
             ->set_enAttentedeTraitement($row->enAttentedeTraitement)
             ->set_motif($row->motif)
             ->set_labelTypeConge($row->labelTypeConge)
             ->set_noPersonne($row->noPersonne)
             ->set_dateDebut_Annee($row->dateDebut_Annee);                                          
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noConge' => $item->get_noConge(),
            'dateDebut'  => $item->get_dateDebut(),
            'dateFin' => $item->get_dateFin(),
            'valider'  => $item->get_valider(),
            'enAttentedeTaitement' => $item->get_enAttentedeTraitement(), 
            'motif' => $item->get_motif(),
            'labelTypeConge' => $item->get_labelTypeConge(),
            'noPersonne' => $item->get_noPersonne(),
            'dateDebut_Annee' => $item->get_dateDebut_Annee(),
        );
    }
    
    //Permet de récupérer les congés d'une personne 
    public function _getConges($noPersonne)
    {
        //Retourne les enregistrements sur les congés de la personne demandée
        $rows = $this->_getDbTableName()->fetchAll($this->_getDbTableName()->select() //tout les champs
                                           ->where('noPersonne', $noPersonne));
        //Génère la liste des congés à partir des résultats précédents
        $conges = $this->_createItemsFromRowset($rows);
        
        return $conges;
    }
}

?>
