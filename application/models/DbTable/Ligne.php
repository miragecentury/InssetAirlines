<?php

class Application_Model_DbTable_Ligne extends Zend_Db_Table_Abstract {
    protected $_name = 'Ligne';
    protected $_primaryKey = 'noLigne';
    protected $_foreignKey = array(
        'fkAeroportDeco' => array (
            'Columns' => 'labelAeroportDeco',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'noAeroport',
        ),
        'fkAeroportAtte' => array (
            'Columns' => 'labelAeroportAtte',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'noAeroport',
        )
    );
}

?>
