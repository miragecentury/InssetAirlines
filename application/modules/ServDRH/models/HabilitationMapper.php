<?php

class ServDRH_Model_HabilitationMapper extends Spesx_Mapper_Mapper
{
       protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Habilitation();
        $item->set_noHabilitation($row->noHabilitation)
             ->set_labelHabilitation($row->labelHabilitation)
             ->set_labelMetier($row->labelMetier)
             ->set_Modele_label($row->Modele_label);
                                          
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noHabilitation' => $item->get_noHabilitation(),
            'labelHabilitation'  => $item->get_labelHabilitation(),
            'labelMetier' => $item->get_labelMetier(),
            'labelModele' => $item->get_Modele_label(),
            );
    }
    
    //Récupère les habilitations pour un métier donné
    public function _getHabilitations($labelMetier)
    {
        //On récupère tous les enregistrements de la table en fonction du métier
        $rows = $this->_getDbTableName()->fetchAll(
                $this->_getDbTableName()->select()
                                        ->where('labelMetier', $labelMetier));
        //On créer la liste des habilitations (un tableau d'objet d'habilitations)
        $habilitations = $this->_createItemsFromRowset($rows);
        
        return $habilitations;
    }
    
}

?>
