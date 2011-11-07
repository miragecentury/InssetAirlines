<?php
class Application_Model_DbTable_Personne extends Zend_Db_Table_Abstract {
    protected $_name = 'Personne';
    protected $_primary = 'noPersonne';
    protected $_foreignKey = array(
        'fkAdresse' => array (
            'Columns' => 'noAdresse',
            'refTableClass' => 'Adresse',
            'refColumns' => 'noAdresse',
        ),
        'fkPays' => array (
            'Columns' => 'labelPays',
            'refTableClass' => 'Pays',
            'refColumns' => 'labelPays',
        )
    );
}

?>
