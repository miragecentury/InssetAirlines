<?php

class ServDRH_Model_HabilitationMapper extends Spesx_Mapper_Mapper
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServDRH_Model_Habilitation();
        $item->set_noHabilitation($row->noHabilitation);
        $item->set_labelHabilitation($row->labelHabilitation);
        $item->set_labelMetier($row->labelMetier);
        $item->set_Modele_label($row->Modele_label);
                                          
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noHabilitation' => $item->get_noHabilitation(),
            'labelHabilitation'  => $item->get_labelHabilitation(),
            'labelMetier' => $item->get_labelMetier(),
            'Modele_label' => $item->get_Modele_label(),
            );
    }
    
    //Récupère les habilitations pour un label donné
    public function findByLabel($label)
    {        
        try {
            $select = $this->getDbTable()->select()
                ->where('labelHabilitation = ?', $label);
            $result = $this->getDbTable()->fetchRow($select);           
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'Habilitation : Echec Methode findByLabel',
                $e->getCode(),
                $e);
        }        
        if ($result != null) {
            $return = $this->_createItemFromRow($result);       
        } else {
            $return = new ServDRH_Model_Habilitation;
        }
        
        return $return;
    }            
}

?>
