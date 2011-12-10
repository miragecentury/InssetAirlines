<?php

class ServLogCom_Model_IncompatibleMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServLogCom_Model_Incompatible();
        $item->set_id($row->id)
                ->set_idRegimeAlimentaire($row->idRegimeAlimentaire)
                ->set_idMenu($row->idMenu)
        ;
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'id' => $item->get_id(),
            'idRegimeAlimentaire' => $item->get_idRegimeAlimentaire(),
            'idMenu' => $item->get_idMenu(),
        );
    }

    public function findbyMenu($idMenu)
    {
        try {
            $select = $this->getDbTable()->select()->where('idMenu = ?', $idMenu);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' IncompatibleMapper : echec Find ',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findbyRegime($idRegime)
    {
        try {
            $select = $this->getDbTable()->select()->where('idRegimeAlimentaire = ?', $idRegime);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' IncompatibleMapper : echec Find ',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findbyMenuAndRegime($idMenu, $idRegime)
    {
        try {
            $select = $this->getDbTable()->select()->where("idMenu = $idMenu AND idRegimeAlimentaire = $idRegime");
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' IncompatibleMapper : echec Find ',
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
