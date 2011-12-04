<?php

class ServMaintenance_Model_ModeleMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServMaintenance_Model_Modele();
        $item->set_noModele($row->noModele)
                ->set_label($row->label)
                ->set_rayonAction($row->rayonAction)
                ->set_distMinAtt($row->distMinAtt)
                ->set_distMinDec($row->distMinDec)
                ->set_dateLancement($row->dateLancement)
                ->set_noConstructeur($row->noConstructeur);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'noModele' => $item->get_noModele(),
            'label' => $item->get_label(),
            'rayonAction' => $item->get_rayonAction(),
            'distMinAtt' => $item->get_distMinAtt(),
            'distMinDec' => $item->get_distMinDec(),
            'dateLancement' => $item->get_dateLancement(),
            'noConstructeur' => $item->get_noConstructeur(),
        );
    }

    public function findAll() {
        if (Spesx_Cache::test('Modele_findall')) {
            $res = unserialize(Spesx_Cache::load('Modele_findall'));
        } else {
            $res = parent::findAll();
            Spesx_Cache::save(serialize($res), 'Modele_findall');
        }
        return $res;
    }

    public function save($item, $id) {
        $res = parent::save($item, $id);
        Spesx_Cache::save(serialize(parent::findAll()), 'Modele_findall');
        return $res;
    }
    
    public function delete($col, $val) {
        $res = parent::delete($col, $val);
        Spesx_Cache::save(serialize(parent::findAll()), 'Modele_findall');
        return $res;
    }

}

?>
