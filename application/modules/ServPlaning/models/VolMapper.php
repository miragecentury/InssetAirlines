<?php

class ServPlaning_Model_VolMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServPlaning_Model_Vol();
        $item->set_noVol($row->noVol)
            ->set_labelvol($row->labelvol)
            ->set_labelAeroportAtte($row->labelAeroportAtte)
            ->set_labelAeroportDeco($row->labelAeroportDeco)
            ->set_noAvion($row->noAvion)
            ->set_noLigne($row->noLigne)
            ->set_heureDecollage($row->heureDecollage)
            ->set_heureAtterissage($row->heureAtterissage);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noVol' => $item->get_noVol(),
            'labelvol' => $item->get_labelvol(),
            'labelAeroportAtte' => $item->get_labelAeroportAtte(),
            'labelAeroportDeco' => $item->get_labelAeroportDeco(),
            'noAvion' => $item->get_noAvion(),
            'noLigne' => $item->get_noLigne(),
            'heureDecollage' => $item->get_heureDecollage(),
            'heureAtterissage' => $item->get_heureAtterissage(),
        );
    }

}

?>
