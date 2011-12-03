<?php
class ServDRH_Model_CongeMapper extends Spesx_Mapper_Mapper {
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Conge();
        $item->set_noConge($row->noConge);
        $item->set_dateDebut($row->dateDebut);
        $item->set_dateFin($row->dateFin);
        $item->set_valider($row->valider);
        $item->set_enAttentedeTraitement($row->enAttentedeTraitement);
        $item->set_motif($row->motif);
        $item->set_labelTypeConge($row->labelTypeConge);
        $item->set_noPersonne($row->noPersonne);
        $item->set_dateDebut_Annee($row->dateDebut_Annee);                                          
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noConge' => $item->get_noConge(),
            'dateDebut'  => $item->get_dateDebut(),
            'dateFin' => $item->get_dateFin(),
            'valider'  => $item->get_valider(),
            'enAttentedeTraitement' => $item->get_enAttentedeTraitement(), 
            'motif' => $item->get_motif(),
            'labelTypeConge' => $item->get_labelTypeConge(),
            'noPersonne' => $item->get_noPersonne(),
            'dateDebut_Annee' => $item->get_dateDebut_Annee(),
        );
    }
    
    //Permet de récupérer les congés d'une personne 
    public function _getConges($noPersonne) {
         try {
            $select = $this->getDbTable()->select()
                ->where('noPersonne = ?', $noPersonne);
            $result = $this->getDbTable()->fetchAll($select);           
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'Employe : Echec Methode _getConges',
                $e->getCode(),
                $e);
        }        
        //Génère la liste des congés à partir des résultats précédents
        $conges = $this->_createItemsFromRowset($result);
        
        return $conges;
    }    
}

?>
