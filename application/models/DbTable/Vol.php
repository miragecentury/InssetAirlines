<?php

class Application_Model_DbTable_Vol extends Zend_Db_Table_Abstract {
    protected $_name = 'Vol';
    protected $_primaryKey = 'noLigne';
    protected $_foreignKey = array(
        'fkAeroportAtte' => array (
            'Columns' => 'labelAeroportAtte',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'labelAeroport',
        ),
        'fkAeroportDeco' => array (
            'Columns' => 'labelAeroportDeco',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'labelAeroport',
        ),
        'fkAvion' => array (
            'Columns' => 'noAvion',
            'refTableClass' => 'Avion',
            'refColumns' => 'noAvion',
        ),
        'fkLigne' => array (
            'Columns' => 'noLigne',
            'refTableClass' => 'Ligne',
            'refColumns' => 'noLigne',
        )
    );
}

?>
