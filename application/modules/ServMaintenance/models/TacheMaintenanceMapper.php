<?php

class ServMaintenance_Model_TacheMaintenanceMapper extends Spesx_Mapper_Mapper 
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new TacheMaintenance();
        $item->set_noMaintenance($row->noMaintenance)
             ->set_dateDebut($row->dateDebut)
             ->set_dateFin($row->dateFin)
             ->set_retard($row->retard)
             ->set_noTypeMaintenance($row->noTypeMaintenance)
             ->set_noAvion($row->noAvion);
                     
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noMaintenance' => $item->get_noMaintenance(),
            'dateDebut'  => $item->get_dateDebut(),
            'dateFin' => $item->get_dateFin(),            
            'retard' => $item->get_retard(),
            'noTypeMaintenance' => $item->get_noTypeMaintenance(),
            'noAvion' => $item->get_noAvion(),
            );
    }
    
}

?>
