<?php

class Application_Model_Telephone
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id du no de telephone
     * @var int
     */
    protected $_noTelephone;

    /**
     * numero de telephone
     * @var string
     */
    protected $_numTelephone;

    /**
     * Mapper associé
     * @var Application_Model_TelephoneMapper
     */
    private $_mapper;

    //Constructeur : instancie le mapper
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_Telephone' );
    }

    //--------------------------------------------------------------------------
    //Methodes
    //--------------------------------------------------------------------------
    /**
     * recupère un objet Telephone a partir de son id
     * @param int $id
     * @return Application_Model_Telephone
     * @access public
     */
    public static function getTelephone( $id )
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_Telephone' );
        return $mapper->find( $id );
    }

    /**
     * sauve une modification ou un ajout a la BDD (suivant l'id de l'objet)
     * @return void
     * @access public
     */
    public function addTelephone()
    {
        try {
            $return = $this->_mapper->save( $this, 'noTelephone' );
        } catch ( Spesx_Mapper_Exception $e ) {
            Spesx_Log::log( "Erreur de modification du telephone : " .
                $e->getMessage() .
                ':' .
                $e->getPrevious()->getMessage() ,  Zend_Log::ERR);
        }
        return $return;
    }

    //--------------------------------------------------------------------------
    //GETTER / SETTER
    //--------------------------------------------------------------------------
    public function get_noTelephone()
    {
        return $this->_noTelephone;
    }

    public function set_noTelephone( $_noTelephone )
    {
        $this->_noTelephone = $_noTelephone;
        return $this;
    }

    public function get_numTelephone()
    {
        return $this->_numTelephone;
    }

    public function set_numTelephone( $_numTelephone )
    {
        $this->_numTelephone = $_numTelephone;
        return $this;
    }

}

?>
