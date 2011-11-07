<?php

class Application_Model_PersonneMapper extends Spesx_Mapper_Mapper
{

    protected function _createItemFromRow(Zend_Db_Table_Row $row)
    {

        $item = new Application_Model_Personne();
        $item->set_noPersonne($row->noPersonne)
             ->set_nom($row->nom)
             ->set_prenom($row->prenom)
             ->set_prenom2($row->prenom2)
             ->set_prenom3($row->prenom3)
             ->set_dateNaissance($row->dateNaissance)
             ->set_responsableLegal($row->responsableLegal)
             ->set_noINSEE($row->noINSEE)
             ->set_noAdresse($row->noAdresse)
             ->set_labelPays($row->labelPays)
             ->set_email($row->email)
             ->set_role($row->role)
             ->set_password($row->password)
             ->set_password_salt($row->password_salt);

        return $item;
    }

    protected function _getDataArrayFromItem($item)
    {

        return array(
            'nom' => $item->get_nom(),
            'prenom' => $item->get_prenom(),
            'prenom2' => $item->get_prenom2(),
            'prenom3' => $item->get_prenom3(),
            'dateNaissance' => $item->get_dateNaissance(),
            'responsableLegal' => $item->get_responsableLegal(),
            'noINSEE' => $item->get_noINSEE(),
            'noAdresse' => $item->get_noAdresse(),
            'labelPays' => $item->get_labelPays(),
            'email' => $item->get_email(),
            'role' => $item->get_role(),
            'password' => $item->get_password(),
            'password_salt' => $item->get_password_salt(),

        );
    }

    public function selectByMail($mail)
    {
        try {
            $select = $this->getDbTable()->select()
                ->where('email = ?', $mail);
            $result = $this->getDbTable()->fetchAll($select);
        } catch (Zend_Db_Exception $e) {
            throw new Spesx_Mapper_Exception(
                'Personne : Echec Methode selectByMail',
                $e->getCode(),
                $e);
        }
        $return = $this->_createItemFromRow($result[0]);
        return $return;
    }

}
