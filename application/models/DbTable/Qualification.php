<?php

class Application_Model_DbTable_Qualification extends Zend_Db_Table_Abstract {
    protected $_name = 'Qualification';
    protected $_primaryKey = array('Employe_Personne_noPersonne', 'Habilitation_noHabilitation');
    protected $_foreignKey = array(
        'fkEmploye' => array (
            'Columns' => 'Personne_noPersonne',
            'refTableClass' => 'Employe',
            'refColumns' => 'Employe_Personne_noPersonne',
        ),
        'fkHabilitation' => array (
            'Columns' => 'noHabilitation',
            'refTableClass' => 'Habilitation',
            'refColumns' => 'noHabilitation',
        )
    );
}

?>
