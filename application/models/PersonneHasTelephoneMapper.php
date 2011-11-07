<?php

class Application_Model_PersonneHasTelephoneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = array(
            'noPersonne' => $row->noPersonne,
            'noTelephone' => $row->noTelephone,
            'labelTelephone' => $row->labelTelephone
        );
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return $item;
    }

    public static function getTelephonesByIdPersonne($id)
    {
        $mapper =  Spesx_Mapper_MapperFactory::getMapper('Application_Model_PersonneHasTelephone');
        $filter = new Spesx_Filter_SQL();
        try {
            $return = $mapper->getDbTable()->fetchAll(
                    $mapper->getDbTable()->select()->where(
                            'noPersonne = ?', $filter->filter($id)
                    )
            );
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'PersonneHasTelephone : Echec Methode getTelephonesByIdPersonne',
                    $e->getCode(),
                    $e);
        }
        $tbl = $mapper->_createItemsFromRowset($return);
        return $tbl;
    }

    public function find($id)
    {
        try {
            $result = $this->getDbTable()->find($id[0], $id[1]);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'PersonneHasTelephone : Echec methode find',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
            return;
        }
        return $this->_createItemFromRow($result->current());
    }

    public function save($item, $id)
    {
        $filter = new Spesx_Filter_SQL;
//Vérification de l'existence dans la BDD de l'enregistrement
        try {
            $selectVerif = $this->getDbTable()
                    ->select()
                    ->where('noPersonne = ?', $filter->filter($item['noPersonne']))
                    ->where('noTelephone = ?', $filter->filter($item['noTelephone']));
            $result = $this->_dbTable->fetchAll($selectVerif);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'PersonneHasTelephone : Echec Verification methode save',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
//enregistrement en temps qu'insert
            try {
                $this->getDbTable()->insert($item);
            } catch (Zend_Db_Exception $e) {
                throw new Spesx_Mapper_Exception(
                        'PersonneHasTelephone : Echec Insertion methode save',
                        $e->getCode(),
                        $e);
            }
        } else {
//enregistrement en temps qu'update
            try {
                $whereUpdate[] = $this->_dbTable
                        ->getAdapter()
                        ->quoteInto(
                        'noPersonne = ?', $filter->filter($item['noPersonne']));
                $whereUpdate[] = $this->_dbTable
                        ->getAdapter()
                        ->quoteInto(
                        'noTelephone = ?', $filter->filter($item['noTelephone']));
                $this->_dbTable->update($item, $whereUpdate);
            } catch (Zend_Db_Exception $e) {
                throw new Spesx_Mapper_Exception(
                        'PersonneHasTelephone : Echec Update methode save',
                        $e->getCode(),
                        $e);
            }
        }
    }

}