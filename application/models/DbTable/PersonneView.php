<?php

class Application_Model_DbTable_PersonneView extends Zend_Db_Table_Abstract
{

    protected $_name = 'PersonneView';
    protected $_primary = 'noPersonne';
    protected $_foreignKey = array(
        'fkTelephone' => array(
            'Columns' => 'noTelephone',
            'refTableClass' => 'noTelephone',
            'refColumns' => 'noTelephone'
            )
    );

}