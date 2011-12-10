<?php
class Application_Model_DbTable_Incompatible extends Zend_Db_Table_Abstract {
    protected $_name = 'Incompatible';
    protected $_primaryKey = 'id';
    protected $_foreignKey = array(
        'fkMenu' => array (
            'Columns' => 'idMenu',
            'refTableClass' => 'Menu',
            'refColumns' => 'idMenu',
        ),
        'fkRegimeAlimentaire' => array(
            'Columns' => 'idRegimeAlimentaire',
            'refTableClass' => 'RegimeAlimentaire',
            'refCulumns' => 'noRegimeAlimentaire',
        )
    );
}

?>
