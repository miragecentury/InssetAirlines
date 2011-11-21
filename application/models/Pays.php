<?php

class Application_Model_Pays
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * Nom du pays
     * @var string
     */
    protected $_labelPays;

    /**
     * Tag du pays
     * @var string
     */
    protected $_localize;

    /**
     * Mapper de pays
     * @var Application_Model_PaysMapper
     */
    private $_mapper;

    //--------------------------------------------------------------------------
    //Constructeur
    //--------------------------------------------------------------------------
    public function __construct()
    {
        $this->_mapper = new Application_Model_PaysMapper();
    }

    //--------------------------------------------------------------------------
    //Methodes
    //--------------------------------------------------------------------------
    /**
     * Retourne l'objet pays correspondant à l'id parametré
     *
     * @access public
     * @param string $label
     * @return Application_Model_Pays
     */
    public function getPays($label)
    {
        return $this->_mapper->find($label);
    }

    public function addPays()
    {
        $this->_mapper->save($this, 'labelPays');
    }

    //--------------------------------------------------------------------------
    //Getters / setters
    //--------------------------------------------------------------------------
    public function get_labelPays()
    {
        return $this->_labelPays;
    }

    public function set_labelPays($_labelPays)
    {
        $this->_labelPays = $_labelPays;
    }

    public function get_localize()
    {
        return $this->_localize;
    }

    public function set_localize($_localize)
    {
        $this->_localize = $_localize;
    }

}

?>
