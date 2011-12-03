<?php

class ServStrategique_Model_EtudeMarcheMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServStrategique_Model_EtudeMarche();
        $item->set_noEtudeMarche($row->noEtudeMarche)
            ->set_labelTypeEtudeMarche($row->labelTypeEtudeMarche)
            ->set_Ligne_noLigne($row->Ligne_noLigne)
            ->set_noDemandeLigne($row->noDemandeLigne);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noEtudeMarche' => $item->get_noEtudeMarche(),
            'labelTypeEtudeMarche' => $item->get_labelTypeEtudeMarche(),
            'noLigne' => $item->get_Ligne_noLigne(),
            'noDemandeLigne' => $item->get_noDemandeLigne(),
        );
    }

}

?>
