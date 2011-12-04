<?php

class Application_Model_TelephoneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow( Zend_Db_Table_Row $row )
    {
        $item = new Application_Model_Telephone();
        $item->set_noTelephone( $row->noTelephone )
            ->set_numTelephone( $row->numTelephone );
        return $item;
    }

    protected function _getDataArrayFromItem( $item )
    {

        return array(
            'noTelephone' => $item->get_noTelephone(),
            'numTelephone' => $item->get_numTelephone(),
        );
    }

    public function fetch( $num )
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto( 'numTelephone = ?', $num );
        $select = $this->getDbTable()->select()
            ->where( $where );
        $row = $this->getDbTable()->fetchRow( $select );
        if ($row == null){
            return false;
        }
        $return = $this->_createItemFromRow( $row );
        return $return;
    }
}

?>
