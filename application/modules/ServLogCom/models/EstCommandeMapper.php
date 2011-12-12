<?php

class ServLogCom_Model_EstCommandeMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServLogCom_Model_EstCommande();
        $item->set_id($row->id)
                ->set_idMenu($row->idMenu)
                ->set_noCommandeNourriture($row->noCommandeNourriture)
        ;
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'id' => $item->get_id(),
            'noCommandeNourriture' => $item->get_noCommandeNourriture(),
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
                    ' EstCommandeMapper : echec Find ',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findbyCommande($idCommande)
    {
        try {
            $select = $this->getDbTable()->select()->where('noCommandeNourriture = ?', $idCommande);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' EstCommandeMapper : echec Find ',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        $return = $this->_createItemsFromRowset($result);
        return $return;
    }

    public function findbyMenuAndCommande($idMenu, $idCommande)
    {
        try {
            $select = $this->getDbTable()->select()->where("idMenu = $idMenu AND noCommandeNourriture = $idCommande");
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' EstCommandeMapper : echec Find ',
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
