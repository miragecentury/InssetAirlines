<?php
class Application_Model_TypeMaintenanceMapper extends Application_Model_Mapper
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new TypeMaintenance();
        $item->set_label($row->label)
             ->set_dureeMaintenance($row->dureeMaintenance);
                                 
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'label' => $item->get_label(),
            'dureeMaintenance' => $item->get_dureeMaintenance(),
            );
    }
    
}

?>
