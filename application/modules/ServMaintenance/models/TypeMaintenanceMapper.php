<?php

class ServMaintenance_Model_TypeMaintenanceMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServMaintenance_Model_TypeMaintenance();
        $item->set_label($row->label)
                ->set_dureeMaintenance($row->dureeMaintenance)
                ->set_noTypeMaintenance($row->noTypeMaintenance)
                ->set_label($row->label)
                ->set_periode($row->periode)
                ->set_noModele($row->noModele);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'label' => $item->get_label(),
            'dureeMaintenance' => $item->get_dureeMaintenance(),
            'noTypeMaintenance' => $item->get_noTypeMaintenance(),
            'label' => $item->get_label(),
            'periode' => $item->get_periode(),
            'noModele' => $item->get_noModele()
        );
    }

    public function findAllByModele($noModele) {
        try {
            $select = $this->getDbTable()->select()
                    ->where('noModele = ?', $noModele);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllByModele ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

}

?>
