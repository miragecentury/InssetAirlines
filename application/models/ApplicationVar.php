<?php

class Application_Model_ApplicationVar {

    protected $_id;
    protected $var;
    private static $mapper = null;

    private static function init() {
        if (self::$mapper === null) {
            self::$mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_ApplicationVar');
        }
    }

    public static function getAll() {
        self::init();
        return self::$mapper->findAll();
    }

    public static function get($id) {
        self::init();
        return self::$mapper->find($id);
    }

    public static function set($id, $var) {
        self::init();
        $item = new Application_Model_ApplicationVar();
        $item->set_id($id)->set_var($var)->save();
    }

    public function save() {
        self::init();
        return self::$mapper->save($this,'id');
    }

    //**************************************************************************
    // Setter / Getter
    //**************************************************************************

    public function set_id($id) {
        $this->_id = $id;
        return $this;
    }

    public function get_id() {
        return $this->_id;
    }

    public function set_var($var) {
        $this->_var = $var;
        return $this;
    }

    public function get_var($var) {
        return $this->_var;
    }

}

?>
