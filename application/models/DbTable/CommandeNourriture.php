<?php

class Application_Model_DbTable_CommandeNourriture extends Zend_Db_Table_Abstract {
    protected $_name = 'CommandeNourriture';
    protected $_primaryKey = 'noCommandeNourriture';
    protected $_foreignKey = array(
        'fkAeroport' => array (
            'Columns' => 'labelAeroportLivraison',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'labelAeroport',
        )
    );
}

?>
