<?php

class ServStrategique_Model_TypeEtudeMarcheMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServStrategique_Model_TypeEtudeMarche();
        $item->set_labelTypeEtudeMarche($row->labelTypeEtudeMarche);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'labelTypeEtudeMarche' => $item->get_labelTypeEtudeMarche(),
        );
    }

}

?>
