<?php

class ServPlaning_Model_EnVolMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServPlaning_Model_EnVol();
        $item->set_noVol($row->noVol)
            ->set_noEmploye($row->noEmploye)
            ->set_equipageSecours($row->equipageSecours)
            ->set_heureStart($row->heureStart)
            ->set_heureEnd($row->heureEnd);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noVol' => $item->get_noVol(),
            'noEmploye' => $item->get_noEmploye(),
            'equipageSecours' => $item->get_equipageSecours(),
            'heureStart' => $item->get_heureStart(),
            'heureEnd' => $item->get_heureEnd(),
        );
    }

    //Permet de récupérer un résultat
    public function find($id)
    {
        try {
            $result = $this->getDbTable()->find($id[0], $id[1]);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'EnVolMapper : echec Find',
                $e->getCode(),
                $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemFromRow($result->current());
        return $return;
    }

   public function getEmployeLibreInInterval(DateTime $start,  DateTime $stop){
       //formatage des dates
       $start = $start->format(DATE_ATOM);
       $stop = $stop->format(DATE_ATOM);

       //selection
       try{
       $select = $this->getDbTable()->getAdapter()->query("
            SELECT *
            FROM Employe
            WHERE Personne_noPersonne
            NOT IN (
                SELECT noEmploye
                FROM EnVol
                WHERE (heureStart >= $start AND heureStart <= $stop) OR
                    (heureStop >= $start AND heureStop <= $stop) OR
                    (heureStart <= $start AND heureStop >= $stop)
            )");
       $rowset = $this->getDbTable()->fetchAll($select);
       } catch (Zend_Db_Exception $e){
            Spesx_Log::Log('getEmployeLibreInInterval : Echec de récupération de la liste<br /> '
                . $e->getMessage(),Zend_Log::ERR);
            return false;
       }
       $return = $this->_createItemsFromRowset($rowset);
       return $return;
   }

}

?>
