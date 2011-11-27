<?php

class Application_Model_PersonneHasTelephoneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Application_Model_PersonneHasTelephone();
            $item->set_noPersonne( $row->noPersonne)
            ->set_noTelephone( $row->noTelephone)
            ->set_labelTelephone($row->labelTelephone);
        return $item;
    }


    protected function _getDataArrayFromItem($item)
    {
        $data = array(
            'noPersonne' => $item->get_noPersonne(),
            'noTelephone' => $item->get_noTelephone(),
            'labelTelephone' => $item->get_labelTelephone()
        );
        return $data;
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
            return false;
        }
        return $this->_createItemFromRow($result->current());
    }

    public function saveAssoc($item)
    {
    //Vérification de l'existence dans la BDD de l'enregistrement
        try {
            $selectVerif = $this->getDbTable()
                    ->select()
                    ->where('noPersonne = ?', $item->get_noPersonne())
                    ->where('noTelephone = ?', $item->get_noTelephone());
            $result = $this->_dbTable->fetchAll($selectVerif);
            //var_dump($result);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'PersonneHasTelephone : Echec Verification methode save',
                    $e->getCode(),
                    $e);
        }
        if (0 == count($result)) {
//enregistrement en temps qu'insert
            try {
                $this->getDbTable()->insert($this->_getDataArrayFromItem($item));
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
                        'noPersonne = ?', $item->get_noPersonne());
                $whereUpdate[] = $this->_dbTable
                        ->getAdapter()
                        ->quoteInto(
                        'noTelephone = ?', $item->get_noTelephone());
                   // var_dump($this->_getDataArrayFromItem($item));
                   // var_dump($item);
                $this->_dbTable->update($this->_getDataArrayFromItem($item), $whereUpdate);
            } catch (Zend_Db_Exception $e) {
                throw new Spesx_Mapper_Exception(
                        'PersonneHasTelephone : Echec Update methode save',
                        $e->getCode(),
                        $e);
            }
        }
    }

}