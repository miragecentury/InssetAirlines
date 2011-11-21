<?php

class ServLogCom_Model_RegimeAlimentaireMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServLogCom_Model_RegimeAlimentaire();
        $item->set_idRegimeAlimentaire($row->idRegimeAlimentaire)
             ->set_labelRegimeAlimentaire($row->labelRegimeAlimentaire);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'idRegimeAlimentaire' => $item->get_idRegimeAlimentaire(),
            'labelRegimeAlimentaire' => $item->get_labelRegimeAlimentaire(),
        );
    }

}

?>
