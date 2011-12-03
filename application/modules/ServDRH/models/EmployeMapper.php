<?php


class ServDRH_Model_EmployeMapper extends Spesx_Mapper_Mapper
{
   protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Employe();
        $item->set_Personne_noPersonne($row->Personne_noPersonne)
             ->set_labelMetier($row->labelMetier);
             
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'Personne_noPersonne' => $item->get_Personne_noPersonne(),
            'labelMetier'  => $item->get_labelMetier(),            
            );
    }
    
    public function findByNoPersonne($noPersonne) {
         try {
            $select = $this->getDbTable()->select()
                ->where('Personne_noPersonne = ?', $noPersonne);
            $result = $this->getDbTable()->fetchRow($select);           
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'Employe : Echec Methode findByNoPersonne',
                $e->getCode(),
                $e);
        }        
        if ($result != null) {
            $return = $this->_createItemFromRow($result);       
        } else {
            $return = new ServDRH_Model_Employe;
        }
        return $return;
    }
}

?>
