<?php

class ServCommercial_Model_VolHasAgenceMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServCommercial_Model_VolHasAgence;
        $item->set_idVolHasAgence($row->idVolHasAgence)
                ->set_Vol_noVol($row->Vol_noVol)
                ->set_Agence_noAgence($row->Agence_noAgence)
                ->set_nbReservation($row->nbReservation)
                ->set_enAttentedeTraitement($row->enAttentedeTraitement)
                ->set_valider($row->valider);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'idVolHasAgence' => $item->get_idVolHasAgence(),
            'Vol_noVol' => $item->get_Vol_noVol(),
            'Agence_noAgence' => $item->get_Agence_noAgence(),
            'nbReservation' => $item->get_nbReservation(),
            'enAttentedeTraitement' => $item->get_enAttentedeTraitement(),
            'valider' => $item->get_valider(),
        );
    }

    public function findbyAgence($idAgence)
    {
        try {
            $select = $this->getDbTable()->select()->where('Agence_noAgence = ?', $idAgence);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' VolHasAgenceMapper : echec Find ',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

}

?>
