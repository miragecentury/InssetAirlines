<?php

class ServStrategique_Model_DemandeLigneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServStrategique_Model_DemandeLigne();
        $item->set_noDemandeLigne($row->noDemandeLigne)
            ->set_labelAeroportDeco($row->labelAeroportDeco)
            ->set_labelAeroportAtte($row->labelAeroportAtte)
            ->set_motif($row->motif);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noDemandeLigne' => $item->get_noDemandeLigne(),
            'labelAeroportDeco' => $item->get_labelAeroportDeco(),
            'labelAeroportAtte' => $item->get_labelAeroportAtte(),
            'motif' => $item->get_motif(),
        );
    }

}

?>
