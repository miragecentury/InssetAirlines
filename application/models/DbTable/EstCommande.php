<?php
class Application_Model_DbTable_EstCommande extends Zend_Db_Table_Abstract {
    protected $_name = 'EstCommande';
    protected $_primaryKey = 'id';
    protected $_foreignKey = array(
        'fkMenu' => array (
            'Columns' => 'idMenu',
            'refTableClass' => 'Menu',
            'refColumns' => 'idMenu',
        ),
        'fkRegimeAlimentaire' => array(
            'Columns' => 'noCommandeNourriture',
            'refTableClass' => 'CommandeNourriture',
            'refCulumns' => 'noCommandeNourriture',
        )
    );
}

?>
