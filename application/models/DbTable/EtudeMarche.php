<?php

class Application_Model_DbTable_EtudeMarche extends Zend_Db_Table_Abstract {
    protected $_name = 'EtudeMarche';
    protected $_primaryKey = 'noEtudeMarche';
    protected $_foreignKey = array(
        'fkTypeEtudeMarche' => array (
            'Columns' => 'labelTypeEtudeMarche',
            'refTableClass' => 'TypeEtudeMarche',
            'refColumns' => 'labelTypeEtudeMarche',
        ),
        'fkLigne' => array (
            'Columns' => 'Ligne_noLigne',
            'refTableClass' => 'Ligne',
            'refColumns' => 'noLigne',
        ),
        'fkDemandeLigne' => array (
            'Columns' => 'noDemandeLigne',
            'refTableClass' => 'DemandeLigne',
            'refColumns' => 'noDemandeLigne',
        )
    );
}

?>
