<?php

class Application_Model_DbTable_TacheMaintenance extends Zend_Db_Table_Abstract {
    protected $_name = 'TacheMaintenance';
    protected $_primaryKey = 'noMaintenance';
    protected $_foreignKey = array(
        'fkTypeMaintenance' => array (
            'Columns' => 'labelTypeMaintenance',
            'refTableClass' => 'TypeMaintenance',
            'refColumns' => 'label',
        ),
        'fkAvion' => array (
            'Columns' => 'noAvion',
            'refTableClass' => 'Avion',
            'refColumns' => 'noAvion',
        )
    );
}

?>
