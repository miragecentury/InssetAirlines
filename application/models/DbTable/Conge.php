<?php
class Application_Model_DbTable_Conge extends Zend_Db_Table_Abstract {
    protected $_name = 'Conge';
    protected $_primaryKey = 'noConge';
    protected $_foreignKey = array(
        'fkTypeConge' => array (
            'Columns' => 'labelTypeConge',
            'refTableClass' => 'TypeConge',
            'refColumns' => 'labelTypeConge',
        ),
        'fkPersonne' => array(
            'Columns' => 'noPersonne',
            'refTableClass' => 'Personne',
            'refColumns' => 'noPersonne',
        ),
        'fkDateDebut' => array (
            'Columns' => 'dateDebut_Annee',
            'refTableClass' => 'Annee_Exploitation',
            'refColumns' => 'dateDebut',
        )
    );
  }
?>