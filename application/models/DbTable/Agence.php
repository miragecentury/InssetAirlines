<?php

class Application_Model_DbTable_Agence extends Zend_Db_Table_Abstract {
    protected $_name = 'Agence';
    protected $_primaryKey = 'noAgence';
    protected $_foreignKey = array(
        'fkAdresse' => array (
            'Columns' => 'noAdresse',
            'refTableClass' => 'Adresse',
            'refColumns' => 'noAdresse',
        )        
    );
}


?>
