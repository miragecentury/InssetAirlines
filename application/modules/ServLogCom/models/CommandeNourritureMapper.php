<?php

class ServLogCom_Model_CommandeNourritureMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServLogCom_Model_CommandeNourriture();
        $item->set_noCommandeNourriture($row->noCommandeNourriture)
            ->set_dateLivraison($row->dateLivraison)
            ->set_dateCommande($row->dateCommande)
            ->set_idAeroportLivraison($row->idAeroportLivraison)
        ;
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noCommandeNourriture' => $item->get_noCommandeNourriture(),
            'dateLivraison' => $item->get_dateLivraison(),
            'dateCommande' => $item->get_dateCommande(),
            'idAeroportLivraison' => $item->get_idAeroportLivraison(),
        );
    }

}

?>
