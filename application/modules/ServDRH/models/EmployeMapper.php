<?php


class ServDRH_Model_EmployeMapper extends Spesx_Mapper_Mapper
{
   protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Employe();
        $item->set_Personne_noPersonne($row->Personne_noPersonne)
             ->set_labelMetier($row->labelMetier);
             
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'Personne_noPersonne' => $item->get_Personne_noPersonne(),
            'labelMetier'  => $item->get_labelMetier(),            
            );
    }
}

?>
