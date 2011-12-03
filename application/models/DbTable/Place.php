<?php

class Application_Model_DbTable_Place extends Zend_Db_Table_Abstract {
    protected $_name ='Place';
    protected $_primaryKey = 'noPlace';
    protected $_foreignKey = array(
        'fkAgence' => array (
            'Columns' => 'noAgence',
            'refTableClass' => 'Agence',
            'refColumns' => 'noAgence',
        ),
        'fkPersonne' => array (
            'Columns' => 'Personne_noPersonne',
            'refTableClass' => 'Personne',
            'refColumns' => 'noPersonne',
        ),
        'fkVol' => array(
            'Columns' => 'noVol',
            'refTableClass' => 'Vol',
            'refColumns' => 'noVol',
        )
    );
}

?>
