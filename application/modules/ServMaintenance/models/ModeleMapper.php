<?php

class Application_Model_ModeleMapper extends Application_Model_Mapper
{
       protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Modele();
        $item->set_label($row->label)
             ->set_rayonAction($row->rayonAction)
             ->set_distMinAtt($row->disMinAtt)
             ->set_distMinDec($row->distMinDec)
             ->set_dateLancement($row->dateLancement)
             ->set_labelConstructeur($row->labelConstructeur);
                                          
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
