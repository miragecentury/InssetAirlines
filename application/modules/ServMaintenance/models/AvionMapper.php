<?php

class ServMaintenance_Model_AvionMapper extends Application_Model_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new Avion();
        $item->set_noAvion($row->noAvion)
                ->set_nbPlaceMax($row->nbPlaceMax)
                ->set_nbHeureVol($row->nbHeureVol)
                ->set_nbIncident($row->nbIncident)
                ->set_label($row->label)
                ->set_dateMiseService($row->dateMiseService)
                ->set_dateHorsService($row->dateHorsService)
                ->set_enService($row->enService)
                ->set_noModele($row->noModele);
        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'noAvion' => $item->get_noAvion(),
            'nbPlaceMax' => $item->get_nbPlaceMax(),
            'nbHeureVol' => $item->get_nbHeureVol(),
            'nbIncident' => $item->get_nbIncident(),
            'label' => $item->get_label(),
            'dateMiseService' => $item->get_dateMiseService(),
            'dateHorsService' => $item->get_dateHorsService(),
            'enService' => $item->get_enService(),
            'noModele' => $item->get_noModele(),
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
        $return = $this->_createItemFromRow($result);
        return $return;
    }

}

?>