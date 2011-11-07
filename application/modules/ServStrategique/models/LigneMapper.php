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
            ->set_labelAeroportDeco($row->labelAeroportDeco)
            ->set_labelAeroportAtte($row->labelAeroportAtte);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noLigne' => $item->get_noLigne(),
            'jours' => $item->get_jours(),
            'semaines' => $item->get_semaines(),
            'mois' => $item->get_mois(),
            'annee' => $item->get_annee(),
            /* 'date' => $item->get_jours()
              ->get_semaines()
              ->get_mois()
              ->get_annees(),
             */
            'labelAeroportDeco' => $item->get_labelAeroportDeco(),
            'labelAeroportAtte' => $item->get_labelAeroportAtte()
        );
    }

}

?>
