<?php

class ServMaintenance_Model_ModeleMapper extends Spesx_Mapper_Mapper
{
    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServMaintenance_Model_Modele;
        $item->set_label($row->label);
        $item->set_rayonAction($row->rayonAction);
        $item->set_distMinAtt($row->distMinAtt);
        $item->set_distMinDec($row->distMinDec);
        $item->set_dateLancement($row->dateLancement);
        $item->set_labelConstructeur($row->labelConstructeur);
                                          
        return $item;
    }
    
    protected function _getDataArrayFromItem($item)
    {
        return array(
            'label' => $item->get_label(),
            'rayonAction '  => $item->get_rayonAction(),
            'distMinAtt '  => $item->get_distMinAtt(),
            'disMindec' => $item->get_distMinDec(),
            'dateLancement' => $item->get_dateLancement(),
            'labelConstructeur' => $item->get_labelConstructeur(),
            );
    }
}

?>
