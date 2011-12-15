<?php

class ServMaintenance_Model_TacheMaintenanceMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServMaintenance_Model_TacheMaintenance();
        $item->set_noMaintenance($row->noMaintenance)
                ->set_dateDebut($row->dateDebut)
                ->set_dateFin($row->dateFin)
                ->set_retard($row->retard)
                ->set_noTypeMaintenance($row->noTypeMaintenance)
                ->set_noAvion($row->noAvion)
                ->set_etat($row->etat)
                ->set_rapport($row->Rapport);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'noMaintenance' => $item->get_noMaintenance(),
            'dateDebut' => $item->get_dateDebut(),
            'dateFin' => $item->get_dateFin(),
            'retard' => $item->get_retard(),
            'noTypeMaintenance' => $item->get_noTypeMaintenance(),
            'noAvion' => $item->get_noAvion(),
            'etat' => $item->get_etat(),
            'Rapport' => $item->get_rapport(),
        );
    }

    public function findAllForCloture() {
        $CurrentTime = new DateTime(date(DATE_ATOM));
        $CurrentTime->setTime(0, 0, 0);
        try {
            $select = $this->getDbTable()->select()
                    ->where('? >= dateFin', $CurrentTime->format(DATE_ATOM))
                    ->where('etat <> ?', ServMaintenance_Model_TacheMaintenance::TACHE_FINIE);
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

    public function findOneByAvionAtCurrentTime($noAvion) {
        $CurrentTime = date(DATE_ATOM);
        try {

            $select = $this->getDbTable()->select()
                    ->where('dateDebut <= ? ', $CurrentTime)
                    ->where('dateFin >= ?', $CurrentTime)
                    ->where('noAvion = ?', $noAvion);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllByModele ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        if ($return != null) {
            return $return[0];
        } else {
            return $return;
        }
    }

    public function findAllAtCurrentTime($Etat = null) {
        $CurrentTime = date(DATE_ATOM);
        try {

            if ($Etat !== null) {
                $select = $this->getDbTable()->select()
                        ->where('dateDebut <= ? ', $CurrentTime)
                        ->where('dateFin >= ?', $CurrentTime)
                        ->where('etat = ?', $Etat);
            } else {
                $select = $this->getDbTable()->select()
                        ->where('dateDebut <= ? ', $CurrentTime)
                        ->where('dateFin >= ?', $CurrentTime);
            }
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

    public function findAllByAvionAtDateTimeInterval(DateTime $start, DateTime $end, $noAvion) {
        $start->setTime(0, 0, 0);
        $end->setTime(0, 0, 0);
        $start = $start->format(DATE_ATOM);
        $end = $end->format(DATE_ATOM);
        $where = "
            (dateDebut >= '$start' AND dateDebut < '$end') OR
            (dateFin > '$start' AND dateFin <= '$end') OR
            (dateDebut <= '$start' AND dateFin >= '$end')
        ";

        try {
            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion)
                    ->where($where);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllPlanifierAtCurrentTime' . $e->getMessage(),
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findAllAtDateTimeInterval(DateTime $start, DateTime $end) {
        $start->setTime(0, 0, 0);
        $end->setTime(0, 0, 0);
        $start = $start->format(DATE_ATOM);
        $end = $end->format(DATE_ATOM);
        $where = "
            (dateDebut >= '$start' AND dateDebut < '$end') OR
            (dateFin > '$start' AND dateFin <= '$end') OR
            (dateDebut <= '$start' AND dateFin >= '$end')
        ";

        try {
            $select = $this->getDbTable()->select()
                    ->where($where);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllPlanifierAtCurrentTime' . $e->getMessage(),
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function FindLastMaintenanceByAvionByTypeMaintenance($noAvion, $noTypeMaintenance) {
        try {

            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion)
                    ->where('noTypeMaintenance = ?', $noTypeMaintenance)
                    ->where('etat = ?', ServMaintenance_Model_TacheMaintenance::TACHE_FINIE)
                    ->order(array('dateFin DESC'));
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllPlanifierAtCurrentTime',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        if ($return == null) {
            return $return;
        } else {
            return $return[0];
        }
    }

    public function findAllPlanifierAtCurrentTime() {
        $CurrentTime = new DateTime(date(DATE_ATOM));
        $CurrentTime->setTime(0, 0, 0);
        try {
            $select = $this->getDbTable()->select()
                    ->where('? <= dateDebut', $CurrentTime->format(DATE_ATOM));
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllPlanifierAtCurrentTime',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function getTachePlanifierByTypeMaintenanceByAvionAtCurrentTime($TypeMaintenance, $noAvion) {
        $CurrentTime = new DateTime(date(DATE_ATOM));
        $CurrentTime->setTime(0, 0, 0);
        try {
            $select = $this->getDbTable()->select()
                    ->where('? <= dateDebut', $CurrentTime->format((DATE_ATOM)))
                    ->where('? = noAvion', $noAvion)
                    ->where('? = noTypeMaintenance', $TypeMaintenance);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServMaintenance : Echec Methode findAllPlanifierAtCurrentTime',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

}

?>
