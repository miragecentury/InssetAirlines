<?php

class ServStrategique_Model_LigneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {
        $item = new ServStrategique_Model_Ligne();
        $item->set_noLigne($row->noLigne)
            ->set_jours($row->jours)
            ->set_semaines($row->semaines)
            ->set_mois($row->mois)
            ->set_annees($row->annees)
            ->set_etat($row->etat)
            ->set_noAeroportDeco($row->noAeroportDeco)
            ->set_noAeroportAtte($row->noAeroportAtte)
                ->set_duree($row->duree);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {
        return array(
            'noLigne' => $item->get_noLigne(),
            'jours' => $item->get_jours(),
            'semaines' => $item->get_semaines(),
            'mois' => $item->get_mois(),
            'annees' => $item->get_annees(),
            /* 'date' => $item->get_jours()
              ->get_semaines()
              ->get_mois()
              ->get_annees(),
             */
            'noAeroportDeco' => $item->get_noAeroportDeco(),
            'noAeroportAtte' => $item->get_noAeroportAtte(),
            'etat' => $item->get_etat(),
            'duree' => $item->get_duree()
        );
    }

    public function getLignesJournalieres()
    {
        //select de la liste
        try {
            $select = $this->getDbTable()->select()
                ->where('jours <> 0');
            $rowset = $this->getDbTable()->fetchAll($select);
            $return = $this->_createItemsFromRowset($rowset);
        } catch (Zend_Db_Exception $e) {
            Spesx_Log::Log('Recuperation des lignes journalières : ' . $e->getMessage(), Zend_Log::ERR);
            return false;
        }

        //création de la liste
        $liste = array();
        foreach ($return as $item) {
            $liste[$item->get_noLigne()] = $item->get_jours();
        }

        //insertion dans la bdd (var Glob)
        $return = Application_Model_ApplicationVar::set('LstVolAPlan_J', $liste);
        if ($return) {
            return true;
        } else {
            return false;
        }
    }

    public function getLignesHebdomadaires()
    {
        //select de la liste
        try {
            $select = $this->getDbTable()->select()
                ->where('semaines <> 0');
            $rowset = $this->getDbTable()->fetchAll($select);
            $return = $this->_createItemsFromRowset($rowset);
        } catch (Zend_Db_Exception $e) {
            Spesx_Log::Log('Recuperation des lignes hebdomadaires : ' . $e->getMessage(), Zend_Log::ERR);
            return false;
        }

        //création de la liste
        $liste = array();
        foreach ($return as $item) {
            $liste[$item->get_noLigne()] = $item->get_semaines();
        }

        //insertion dans la bdd (var Glob)
        $return = Application_Model_ApplicationVar::set('LstVolAPlan_S', $liste);
        if ($return) {
            return true;
        } else {
            return false;
        }
    }

    public function getLignesMensuelles()
    {
        //select de la liste
        try {
            $select = $this->getDbTable()->select()
                ->where('mois <> 0');
            $rowset = $this->getDbTable()->fetchAll($select);
            $return = $this->_createItemsFromRowset($rowset);
        } catch (Zend_Db_Exception $e) {
            Spesx_Log::Log('Recuperation des lignes mensuelles : ' . $e->getMessage(), Zend_Log::ERR);
            return false;
        }

        //création de la liste
        $liste = array();
        foreach ($return as $item) {
            $liste[$item->get_noLigne()] = $item->get_mois();
        }

        //insertion dans la bdd (var Glob)
        $return = Application_Model_ApplicationVar::set('LstVolAPlan_M', $liste);
        if ($return) {
            return true;
        } else {
            return false;
        }
    }

    public function getLignesAnnuelles()
    {
        //select de la liste
        try {
            $select = $this->getDbTable()->select()
                ->where('annees <> 0');
            $rowset = $this->getDbTable()->fetchAll($select);
            $return = $this->_createItemsFromRowset($rowset);
        } catch (Zend_Db_Exception $e) {
            Spesx_Log::Log('Récuperation des lignes journalières : ' . $e->getMessage(), Zend_Log::ERR);
            return false;
        }

        //création de la liste
        $liste = array();
        foreach ($return as $item) {
            $liste[$item->get_noLigne()] = $item->get_annees();
        }

        //insertion dans la bdd (var Glob)

        $return = Application_Model_ApplicationVar::set('LstVolAPlan_A', $liste);
        if ($return) {
            return true;
        } else {
            return false;
        }
    }

}

?>
