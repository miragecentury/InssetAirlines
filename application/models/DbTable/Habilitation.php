<?php
class Application_Model_DbTable_Habilitation extends Zend_Db_Table_Abstract {
    protected $_name ='Habilitation';
    protected $_primaryKey = 'noHabilitation';
    protected $_foreignKey = array(
        'fkMetier' => array (
            'Columns' => 'labelMetier',
            'refTableClass' => 'Metier',
            'refColumns' => 'labelMetier',
        ),
        'fkModele' => array (
            'Columns' => 'Modele_label',
            'refTableClass' => 'Modele',
            'refColumns' => 'label',
        )
    );
}

?>
