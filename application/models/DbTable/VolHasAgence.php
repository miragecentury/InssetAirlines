<?php

class Application_Model_DbTable_VolHasAgence extends Zend_Db_Table_Abstract {
    protected $_name = 'Vol_has_Agence';
    protected $_primaryKey = 'idVolHasAgence';
    protected $_foreignKey = array(
        'fkVol' => array (
            'Columns' => 'Vol_noVol',
            'refTableClass' => 'Vol',
            'refColumns' => 'noVol',
        ),
        'fkAgence' => array (
            'Columns' => 'Agence_noAgence',
            'refTableClass' => 'Agence',
            'refColumns' => 'noAgence',
        )
     );
}

?>
