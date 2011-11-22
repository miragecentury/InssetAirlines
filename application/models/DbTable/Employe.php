<?php

class Application_Model_DbTable_Employe extends Zend_Db_Table_Abstract {
    protected $_name = 'Employe';
    protected $_primaryKey = 'Personne_noPersonne';
    protected $_foreignKey = array(
        'fkPersonne' => array (
            'Columns' => 'Personne_noPersonne',
            'refTableClass' => 'Personne',
            'refColumns' => 'noPersonne',
        ),
        'fkMetier' => array (
            'Columns' => 'labelMetier',
            'refTableClass' => 'Metier',
            'refColumns' => 'labelMetier',
        )
    );
}

?>
