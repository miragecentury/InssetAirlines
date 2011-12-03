<?php

class ServStrategique_Model_LigneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServStrategique_Model_Ligne();
        $item->set_noLigne($row->noLigne)
            ->set_jours($row->jours)
            ->set_semaines($row->semaines)
            ->set_mois($row->mois)
            ->set_annees($row->annees)
            ->set_noAeroportDeco($row->noAeroportDeco)
            ->set_noAeroportAtte($row->noAeroportAtte);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noLigne' => $item->get_noLigne(),
            'jours' => $item->get_jours(),
            'semaines' => $item->get_semaines(),
            'mois' => $item->get_mois(),
            'annees' => $item->get_annees(),
            /* 'date' => $item->get_jours()
              ->get_semaines()
              ->get_mois()
              ->get_annees(),
             */
            'noAeroportDeco' => $item->get_noAeroportDeco(),
            'noAeroportAtte' => $item->get_noAeroportAtte()
        );
    }

}

?>
