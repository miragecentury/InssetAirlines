<?php

class Application_Model_PaysMapper extends Application_Model_Mapper
{
       protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Pays();
        $item->set_labelPays($row->labelPays)
             ->set_localize($row->localize);
                                          
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'labelPays' => $item->get_labelPays(),
            'localize'  => $item->get_localize(),
            );
    }
    
    
}

?>
