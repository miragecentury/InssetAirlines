<?php
class Application_Model_DbTable_Avion extends Zend_Db_Table_Abstract {
    protected $_name = 'Avion';
    protected $_primaryKey = 'noAvion';
    protected $_foreignKey = array(
        'fkModel' => array (
            'Columns' => 'labelModele',
            'refTableClass' => 'Modele',
            'refColumns' => 'label',
        )
    );
}
?>
