<?php
class ServDRH_Model_TypeCongeMapper extends Spesx_Mapper_Mapper
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_TypeConge();
        $item->set_labelTypeConge($row->labelTypeConge);
                                 
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'labelTypeConge' => $item->get_labelTypeConge(),            
            );
    }
}

?>
