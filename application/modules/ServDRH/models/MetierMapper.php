<?php

class ServDRH_Model_MetierMapper extends Spesx_Mapper_Mapper 
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Metier();
        $item->set_labelMetier($row->labelMetier);
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'labelMetier' => $item->get_labelMetier()
                );
    }
    
}

?>
