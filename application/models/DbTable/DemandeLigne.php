<?php
class Application_Model_DbTable_DemandeLigne extends Zend_Db_Table_Abstract{
    protected $_name ='DemandeLigne';
    protected $_primaryKey = 'noDemandeLigne';
    protected $_foreignKey = array(
        'fkAeroportDeco' => array (
            'Columns' => 'labelAeroportDeco',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'labelAeroport',
        ),
        'fkAeroportAtte' => array (
            'Columns' => 'labelAeroportAtte',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'labelAeroport',
        )
    );
    }
?>
