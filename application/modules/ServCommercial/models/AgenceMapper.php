<?php

class ServCommercial_Model_AgenceMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServCommercial_Model_Agence;
        $item->set_noAgence($row->noAgence)
                ->set_labelAgence($row->labelAgence)
                ->set_dateLancement($row->dateLancement)
                ->set_dateCloture($row->dateCloture)
                ->set_accesExtranet($row->accesExtranet)
                ->set_noAdresse($row->noAdresse);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noAgence' => $item->get_noAgence(),
            'labelAgence' => $item->get_labelAgence(),
            'dateLancement' => $item->get_dateLancement(),
            'dateCloture' => $item->get_dateCloture(),
            'accesExtranet' => $item->get_accesExtranet(),
            'noAdresse' => $item->get_noAdresse(),
        );
    }

    public function findbylabel($labelagence)
    {
        try {
            $select = $this->getDbTable()->select()->where('labelagence = ?', $labelagence);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    ' AgenceMapper : echec Find ',
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
