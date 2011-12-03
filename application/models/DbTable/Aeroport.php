<?php
class Application_Model_DbTable_Aeroport extends Zend_Db_Table_Abstract {
    protected $_name = 'Aeroport';
    protected $_primaryKey = 'labelAeroport';
    protected $_foreignKey = array(
        'fkPays' => array (
            'Columns' => 'labelPays',
            'refTableClass' => 'Pays',
            'refColumns' => 'labelPays',
        ),
        'fkVille' => array(
            'Columns' => 'labelVille',
            'refTableClass' => 'Ville',
            'refCulumns' => 'labelVille',
        )
    );
}

?>
