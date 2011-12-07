<?php

class ServMaintenance_Model_AvionMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServMaintenance_Model_Avion();

        $item->set_noAvion($row->noAvion)
                ->set_nbPlaceMax($row->nbPlaceMax)
                ->set_nbHeureVol($row->nbHeureVol)
                ->set_nbIncident($row->nbIncident)
                ->set_label($row->label)
                ->set_dateMiseService($row->dateMiseService)
                ->set_dateMiseHorsService($row->dateHorsService)
                ->set_enService($row->enService)
                ->set_noModele($row->noModele)
                ->set_calcDate($row->calcDate);
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
            'dateHorsService' => $item->get_dateMiseHorsService(),
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

    public function findAllService($HorsOrIn) {
        if ($HorsOrIn === TRUE) {
            $HorsOrIn = '1';
        } else {
            $HorsOrIn = '0';
        }
        try {
            $select = $this->getDbTable()->select()
                    ->where('enService = ?', $HorsOrIn);
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

    public function findAllDispoAtInterDate($start, $end) {
        try {
            $select = $this->getDbTable()->select()
                    ->where('enService = ?', TRUE)
                    ->where("
                                (heureDecollage >= $start AND heureDecollage <= $start) OR
                                (heureDecollage <= $start AND heureAtterissage >= $end) OR
                                (heureAtterissage >= $start AND heureAterrisage <= $end)
                            ");
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