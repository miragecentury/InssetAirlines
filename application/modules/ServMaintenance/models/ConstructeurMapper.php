<?php

class ServMaintenance_Model_ConstructeurMapper extends Spesx_Mapper_Mapper {

    protected function _createItemFromRow(Zend_Db_Table_Row $row) {
        $item = new ServMaintenance_Model_Constructeur();
        $item->set_noConstructeur($row->noConstructeur)
                ->set_label($row->label)
                ->set_noAdresse($row->noAdresse);

        return $item;
    }

    protected function _getDataArrayFromItem($item) {
        return array(
            'noConstructeur' => $item->get_noConstructeur(),
            'label' => $item->get_label(),
            'noAdresse' => $item->get_noAdresse(),
        );
    }

    public function find($id) {
        return parent::find($id);
    }

    public function findAll() {
        if (Spesx_Cache::test('Constructeur_findall')) {
            $res = Spesx_Cache::load('Constructeur_findall');
            $res = unserialize($res);
        } else {
            $res = parent::findAll();
            Spesx_Cache::save(serialize($res), 'Constructeur_findall');
        }
        return $res;
    }

    public function delete($item, $id) {
        $res = parent::delete($item, $id);
        Spesx_Cache::save(serialize(parent::findAll()), 'Constructeur_findall');
        return $res;
    }

    public function save($item, $id) {
        $res = parent::save($item, $id);
        Spesx_Cache::save(serialize(parent::findAll()), 'Constructeur_findall');
        return $res;
    }

}

?>
