<?php

class Application_Model_AeroportMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Application_Model_Aeroport();
        $item->set_noAeroport($row->noAeroport)
            ->set_labelAeroport($row->labelAeroport)
            ->set_labelVille($row->labelVille)
            ->set_labelPays($row->labelPays);
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noAeroport' => $item->get_noAeroport(),
            'labelAeroport' => $item->get_labelAeroport(),
            'labelVille' => $item->get_labelVille(),
            'labelPays' => $item->get_labelPays(),
        );
    }

}

?>
