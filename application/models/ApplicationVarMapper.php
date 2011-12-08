<?php

class Application_Model_ApplicationVarMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new Application_Model_ApplicationVar();
        $item->set_id($row->id)
             ->set_var($row->var);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'id' => $item->get_id(),
            'var' => $item->get_var(),
        );
    }
    
    

}

?>
