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

    public function findAllServiceAtCurrentTime($etats) {
        $query = self::whereEtats($etats);
        if ($query !== null) {
            try {
                $select = $this->getDbTable()->select()
                        ->where($query);
                $result = $this->getDbTable()->fetchAll($select);
            } catch (Zend_Db_Exception $e) {
                throw new Spesx_Mapper_Exception(
                        'ServMaintenance : Echec Methode findAllByModele ',
                        $e->getCode(),
                        $e);
            }
            $return = $this->_createItemsFromRowset($result);
            return $return;
        } else {
            return null;
        }
    }

    public function findAllForMiseHorsServiceAtCurrentTime() {
        $CurrentTime = new DateTime(date(DATE_ATOM));
        $CurrentTime->setTime(0, 0, 0);
        try {
            $select = $this->getDbTable()->select()
                    ->where('enService = ?', ServMaintenance_Model_Avion::ETAT_ATT_HORSERVICE)
                    ->where('dateHorsService = ?', $CurrentTime->format(DATE_ATOM));
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

    public function findAllEnServiceAtDateTimeInterval($start, $end) {
        if (is_string($start)) {
            $DateTimeStart = new DateTime($start);
        } elseif ($start instanceof DateTime) {
            $DateTimeStart = $start;
        } else {
            return FALSE;
        }
        if (is_string($end)) {
            $DateTimeEnd = new DateTime($end);
        } elseif ($end instanceof DateTime) {
            $DateTimeEnd = $end;
        } else {
            return FALSE;
        }
        $Start = $DateTimeStart->format(DATE_ATOM);
        $End = $DateTimeEnd->format(DATE_ATOM);
        try {
            $select = $this->getDbTable()->select()
                    ->where("(`dateHorsService` <= '$End') OR (`dateHorsService` IS NULL )");
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

    private static function whereEtats($etats) {
        if (is_array($etats)) {
            $query = '';
            $count = count($etats) - 1;
            foreach ($etats as $key => $etat) {
                $query.= " ( enService = $etat )";
                if ($key != $count) {
                    $query.=' OR';
                }
            }
            return $query;
        } else {
            return null;
        }
    }

}

?>