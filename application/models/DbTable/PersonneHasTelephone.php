<?php


class Application_Model_DbTable_PersonneHasTelephone extends Zend_Db_Table_Abstract {
    protected $_name = 'Personne_has_Telephone';
    protected $_primaryKey = array ('noPersonne','noTelephone');
    protected $_foreignKey = array(
        'fkPersonne' => array (
            'Columns' => 'noPersonne',
            'refTableClass' => 'Personne',
            'refColumns' => 'noPersonne',
        ),
        'fkTelephone' => array(
            'Columns' => 'noTelephone',
            'refTableClass' => 'Telephone',
            'refCulumns' => 'noTelephone',
        )
    );
}
?>