<?php

class Application_Model_DbTable_Constructeur extends Zend_Db_Table_Abstract {
    protected $_name = 'Constructeur';
    protected $_primaryKey = 'label';
    protected $_foreignKey = array(
        'fkAdresse' => array (
            'Columns' => 'noAdresse',
            'refTableClass' => 'Adresse',
            'refColumns' => 'noAdresse',
        )
    );
}

?>
