<?php

class Application_Model_ConstructeurMapper extends Application_Model_Mapper 
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Constructeur();
        $item->set_label($row->label)
             ->set_noAdresse($row->noAdresse);
                     
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'label' => $item->get_label(),
            'noAdresse'  => $item->get_noAdresse(),
            );
    }
}
?>
