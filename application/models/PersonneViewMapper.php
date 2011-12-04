<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonneViewMapper
 *
 * @author pewho
 */
class Application_Model_PersonneViewMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow( Zend_Db_Table_Row $row )
    {

        $item = new Application_Model_PersonneView;
        $item->set_noPersonne( $row->noPersonne )
            ->set_noTelephone( $row->noTelephone )
            ->set_numTelephone( $row->numTelephone )
            ->set_labelTelephone( $row->labelTelephone );

        return $item;
    }

    protected function _getDataArrayFromItem( $item )
    {

        return array(
            'noPersonne' => $item->get_noPersonne,
            'noTelephone' => $item->get_noTelephone,
            'numTelephone' => $item->get_numTelephone,
            'labelTelephone' => $item->get_labelTelephone
        );
    }

    public function getByPersonne( $id )
    {
        try {
            $select = $this->getDbTable()->fetchAll(
                $this->getDbTable()->select()->where('noPersonne = ?',$id)
                );
            $return = $this->_createItemsFromRowset($select);

        } catch ( Spesx_Mapper_Exception $e ) {
            Spesx_Log::Log(
                'PersonneViewMapper :' .
                $e->getMessage() .
                $e->getPrevious()->getMessage(),
                Zend_Log::ERR);
        }
        return $return;
    }

}