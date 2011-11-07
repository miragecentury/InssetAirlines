<?php

class ServCommercial_Model_PlaceMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServCommercial_Model_Place;
        $item->set_noPlace($row->noPlace)
            ->set_noAgence($row->noAgence)
            ->set_Personne_noPersonne($row->Personne_noPersonne)
            ->set_noVol($row->noVol);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noPlace' => $item->get_noPlace(),
            'noAgence' => $item->get_noAgence(),
            'Personne_noPersonne' => $item->get_Personne_noPersonne(),
            'noVol' => $item->get_noVol(),
        );
    }

}

?>
