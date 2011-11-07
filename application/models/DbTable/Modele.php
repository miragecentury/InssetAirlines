<?php

class Application_Model_DbTable_Modele extends Zend_Db_Table_Abstract {
    protected $_name ='Modele';
    protected $_primaryKey = 'label';
    protected $_foreignKey = array (
        'fkConstructeur' => array (
            'Columns' => 'labelConstructeur',
            'refTableClass' => 'Constructeur',
            'refColumns' => 'label',
        )
    );
}

?>
