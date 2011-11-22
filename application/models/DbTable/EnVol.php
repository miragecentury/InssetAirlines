<?php

class Application_Model_DbTable_EnVol extends Zend_Db_Table_Abstract {
    protected $_name = 'EnVol';
    protected $_primaryKey = array('Vol_noVol','noEmploye');
    protected $_foreignKey = array(
        'fkVol' => array (
            'Columns' => 'Vol_noVol',
            'refTableClass' => 'Vol',
            'refColumns' => 'noVol',
        ),
        'fkEmploye' => array (
            'Columns' => 'noEmploye',
            'refTableClass' => 'Employe',
            'refColumns' => 'Personne_noPersonne',
        )
    );
}

?>
