<?php

class ServLogCom_Model_MenuMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServLogCom_Model_Menu();
        $item->set_idMenu($row->idMenu)
             ->set_labelMenu($row->labelMenu);
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'idMenu' => $item->get_idMenu(),
            'labelMenu' => $item->get_labelMenu()
        );
    }

}

?>
