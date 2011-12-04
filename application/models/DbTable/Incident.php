<?php

class Application_Model_DbTable_Incident extends Zend_Db_Table_Abstract {
    protected $_name ='Incident';
    protected $_primaryKey = 'noIncident';
    protected $_foreignKey = array(
        'fkAeroport' => array (
            'Columns' => 'noAeroportArriNextIncident',
            'refTableClass' => 'Aeroport',
            'refColumns' => 'noAeroport',
        ),
        'fkVol' => array (
            'Columns' => 'noVol',
            'refTableClass' => 'Vol',
            'refColumns' => 'noVol',
        ),
        'fkTypeIncident' => array (
            'Columns' => 'idTypeIncident',
            'refTableClass' => 'TypeIncident',
            'refColumns' => 'idTypeIncident'
        )
    );
 }

?>
