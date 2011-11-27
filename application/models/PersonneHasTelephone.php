<?php

/**
 * Description of PersonneHasTelephone
 *
 * @author pewho
 */
class Application_Model_PersonneHasTelephone
{

    //---------
    //ATTRIBUTS
    /**
     * Id personne lié
     * @var int
     * @author pewho
     * @access protected
     */
    protected $_noPersonne;

    /**
     * Id telephone lié
     * @var int
     * @author pewho
     * @access protected
     */
    protected $_noTelephone;

    /**
     * label du numéro
     * @var string
     * @author pewho
     * @access protected
     */
    protected $_labelTelephone;

    /**
     * Mapper associé
     * @var Application_Models_PersonneHasTelephoneMapper
     * @access protected
     * @author pewho
     */
    protected $_mapper;

    //------------
    //CONSTRUCTEUR
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_PersonneHasTelephone' );
    }

    //--------
    //METHODES
    public static function getAssoc( $idTelephone, $idPersonne )
    {
        $id = array( $idTelephone, $idPersonne );
        $mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_PersonneHasTelephone' );
        $return = $mapper->find( $id );
        return $return;
    }

    public function addAssoc()
    {
        try {
            //var_dump($this);
            $this->_mapper->saveAssoc( $this );
        } catch ( Spesx_Mapper_Exception $e ) {
            Spesx_Log::log( "Erreur de modification de l'association Persone <> Telephone : " .
                $e->getMessage() .
                ':' .
                $e->getPrevious()->getMessage(), Zend_Log::ERR );
        }
    }

    //-----------------
    //GETTERS / SETTERS
    public function get_noPersonne()
    {
        return $this->_noPersonne;
    }

    public function set_noPersonne( $_noPersonne )
    {
        $this->_noPersonne = $_noPersonne;
        return $this;
    }

    public function get_noTelephone()
    {
        return $this->_noTelephone;
    }

    public function set_noTelephone( $_noTelephone )
    {
        $this->_noTelephone = $_noTelephone;
        return $this;
    }

    public function get_labelTelephone()
    {
        return $this->_labelTelephone;
    }

    public function set_labelTelephone( $_labelTelephone )
    {
        $this->_labelTelephone = $_labelTelephone;
        return $this;
    }

    public function get_mapper()
    {
        return $this->_mapper;
    }

    public function set_mapper( $_mapper )
    {
        $this->_mapper = $_mapper;
        return $this;
    }

}

?>
