<?php

class ServPlaning_Model_VolMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServPlaning_Model_Vol();
        $item->set_noVol($row->noVol)
                ->set_labelvol($row->labelvol)
                ->set_noAeroportAtte($row->noAeroportAtte)
                ->set_noAeroportDeco($row->noAeroportDeco)
                ->set_noAvion($row->noAvion)
                ->set_noLigne($row->noLigne)
                ->set_heureDecollage($row->heureDecollage)
                ->set_heureAtterissage($row->heureAtterissage);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'noVol' => $item->get_noVol(),
            'labelvol' => $item->get_labelvol(),
            'noAeroportAtte' => $item->get_noAeroportAtte(),
            'noAeroportDeco' => $item->get_noAeroportDeco(),
            'noAvion' => $item->get_noAvion(),
            'noLigne' => $item->get_noLigne(),
            'heureDecollage' => $item->get_heureDecollage(),
            'heureAtterissage' => $item->get_heureAtterissage(),
        );
    }

    public function getVolsByAvion($noAvion) {
        try {
            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServPlanning : Echec Methode getVolsByAvion ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function getVolsByAvionOnCurrentTime($noAvion) {
        $currentTime = date(DATE_ATOM);
        try {
            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion)
                    ->where('heureDecollage <= ?', $currentTime)
                    ->where('heureAtterissage >= ?', $currentTime);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {

            throw new Spesx_Mapper_Exception(
                    'ServPlanning : Echec Methode getVolsByAvionOnCurrentTime ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findAllEnService() {
        try {
            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion)
                    ->where('enService = ?',1);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServPlanning : Echec Methode getVolsByAvion ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findAllHorsService() {
        try {
            $select = $this->getDbTable()->select()
                    ->where('noAvion = ?', $noAvion)
                    ->where('enService = ?',0);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'ServPlanning : Echec Methode getVolsByAvion ',
                    $e->getCode(),
                    $e);
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    /**
     * Permet de récupérer une liste de vols programmé dans l'intervale entre les
     * date $start -> $stop
     *
     * @access public
     * @author pewho
     * @param DateTime $start
     * @param DateTime $stop
     * @return Array(ServPlaning_Model_Vol) $return
     */
    public function findAllVolsInInterval(DateTime $start, DateTime $stop){
        //formatage de la date pour compatiblité
        $start = $start->format(DATE_ATOM);
        $stop = $stop->format(DATE_ATOM);

        //Selection
        try{
        $select = $this->getDbTable()->select()
            ->where("
                (heureDecollage >= $dateStart AND heureDecollage <= $dateStop) OR
                (heureAtterissage >= $dateStart AND heureAtterissage <= $dateStop) OR
                (heureDecollage <= $dateStart AND heureAtterissage >= $dateStop)");
        $returnRowset = self::$_mapper->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e){
            Spesx_Log::Log('findAllVolsInInterval : Echec de récupération de la liste<br /> '
                . $e->getMessage());
            return false;
        }
        $return = $this->_createItemsFromRowset($returnRowset);
        return $return;
    }

}

?>
