<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QualificationMapper
 *
 * @author camille
 */
class ServDRH_Model_QualificationMapper extends Spesx_Mapper_Mapper
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Qualification();
        $item->set_Employe_Personne_noPersonne($row->Employe_Personne_noPersonne);
        $item->set_Habilitation_noHabilitation($row->Habilitation_noHabilitation);
        
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'Employe_Personne_noPersonne' => $item->get_Employe_Personne_noPersonne(),
            'Habilitation_noHabilitation'  => $item->get_Habilitation_noHabilitation(),
            );
    }
    
     public function findByNoPersonne($noPersonne)
    {
        try {
            $select = $this->getDbTable()->select()
                ->where('Employe_Personne_noPersonne = ?', $noPersonne);
            $result = $this->getDbTable()->fetchAll($select);           
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'Qualification : Echec Methode findByNoPersonne',
                $e->getCode(),
                $e);
        }        
        if ($result != null) {
            $return = $this->_createItemsFromRowSet($result);       
        } else {
            $return = new ServDRH_Model_Qualification();
        }
        return $return;
    }
    
    public function saveQualification($item, $id1, $id2) {
        try {
             $select = $this->getDbTable()->select()
                       ->where('Employe_Personne_noPersonne = ?', $id1)
                       ->where('Habilitation_noHabilitation = ?', $id2);                       
             $result = $this->getDbTable()->fetchRow($select);           
        } catch (Zend_Db_Exception $e) {     
            echo $e->__toString();
            /*throw new Spesx_Mapper_Exception(
                'Qualification: Echec methode save',
                 $e->getCode(), $e);*/
        }        
        if ($result != null) {
            $data = $this->_getDataArrayFromItem($item);
            try {
                $where['Employe_Personne_noPersonne = ?'] = $item->get_Employe_Personne_noPersonne();                
                $where['Habilitation_noHabilitation = ?'] = $item->get_Habilitation_noHabilitation();
                $this->getDbTable()->update($data, $where);
            } catch (Zend_Db_Exception $e) {                
                throw new Spesx_Mapper_Exception(
                        'Qualification: Echec methode update',
                        $e->getCode(),
                        $e);
            }
        } else {
            $data = $this->_getDataArrayFromItem($item);
            try {
                $this->getDbTable()->insert($data);
            } catch (Zend_Db_Exception $e) {                
                throw new Spesx_Mapper_Exception(
                        'Qualification: Echec methode insert',
                        $e->getCode(),
                        $e);
            }
        }
    }
    
    public function deleteQualification($noPersonne, $noHabilitation) {
       try {
            $where = array(
                "Employe_Personne_noPersonne = ?" => $noPersonne,
                "Habilitation_noHabilitation = ?" => $noHabilitation);
            $this->getDbTable()->delete($where);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                    'Qualification: Echec methode delete' . $e->getMessage(),
                    $e->getCode(),
                    $e);
        } 
    }
}

?>
