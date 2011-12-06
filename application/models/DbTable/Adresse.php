<?php


class Application_Model_DbTable_Adresse extends Zend_Db_Table_Abstract {
    protected $_name = 'Adresse';
    protected $_primaryKey = 'noAdresse';
    protected $_foreignKey = array(
        'fkPays' => array (
            'Columns' => 'labelPays',
            'refTableClass' => 'Pays',
            'refColumns' => 'labelPays',
        ),
        'fkVille' => array(
            'Columns' => 'labelVille',
            'refTableClass' => 'Ville',
            'refColumns' => 'labelVille',
        )/*,
        'fkPersonne' => array(
            'Columns' => 'noPersonne',
            'refTableClass' => 'Personne',
            'refColumns' => 'noPersonne',
        )*/
    );
}
?>
