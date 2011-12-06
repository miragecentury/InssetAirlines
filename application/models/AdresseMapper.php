<?php

class Application_Model_AdresseMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new Application_Model_Adresse();
        $item->set_noAdresse($row->noAdresse)
                ->set_numero($row->numero)
                ->set_porte($row->porte)
                ->set_adresse($row->adresse)
                ->set_etage($row->etage)
                ->set_immeuble($row->immeuble)
                ->set_commentaire($row->commentaire)
                ->set_codePostal($row->codepostal)
                ->set_etatProvince($row->etatProvince)
                ->set_labelVille($row->labelVille)
                ->set_labelPays($row->labelPays)
                //->set_noPersonne($row->noPersonne)
        ;
        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noAdresse' => $item->get_noAdresse(),
            'numero' => $item->get_numero(),
            'porte' => $item->get_porte(),
            'adresse' => $item->get_adresse(),
            'etage' => $item->get_etage(),
            'immeuble' => $item->get_immeuble(),
            'commentaire' => $item->get_commentaire(),
            'codepostal' => $item->get_codepostal(),
            'etatProvince' => $item->get_etatProvince(),
            'labelVille' => $item->get_labelVille(),
            'labelPays' => $item->get_labelPays(),
            //'noPersonne' => $item->get_noPersonne(),
        );
    }
    
    public function findByNoPersonne($noPersonne) {
        try {
            $select = $this->getDbTable()->select()
                ->where('noPersonne = ?', $noPersonne);
            $result = $this->getDbTable()->fetchRow($select);           
        } catch (Zend_Db_Exception $e) {
            echo $e->__toString();
            /*throw new Spesx_Mapper_Exception(
                'Adresse : Echec Methode findByNoPersonne',
                $e->getCode(),
                $e);*/
        }        
        if ($result != null) {
            $return = $this->_createItemFromRow($result);       
        } else {
            $return = new Application_Model_Personne;
        }
        return $return;
    }
}

?>
