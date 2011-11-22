<?php

/**
 * Description of PersonneView
 * Objet herité d'une Vue : lecture seule
 * permet de récupérer les numéro de téléphone d'une personne
 *
 * @author pewho
 */
class PersonneView
{

    //--------
    //ATRIBUTS
    /**
     * Clé reference vers personne
     * @var int
     * @author pewho
     */
    protected $_noPersonne;

    /**
     * Clé reference vers téléphone
     * @var int
     * @author pewho
     */
    protected $_noTelephone;

    /**
     * Numéro de téléphone
     * @var string
     * @author pewho
     */
    protected $_numTelephone;

    /**
     * label associé au numéro  de téléphone
     * @var string
     * @author pewho
     */
    protected $_labelTelephone;

    /**
     * Mapper associé au modele
     * @var Application_Model_PersonneViewMapper
     */
    protected $_mapper;

    //------------
    //Constructeur
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_PersonneView' );
    }

    //-------
    //Methode
    public static function getTelephonesByPersonne( $id )
    {
        //recupération du mapper
        $mapper = Spesx_Mapper_MapperFactory::getMapper( 'Application_Model_PersonneView' );
        $return = $mapper->getByPersonne( $id );
        if ( is_array( $return ) || ($return instanceof Application_Model_PersonneView) ) {
            return $return;
        } else {
            return false;
        }
    }

    //------------------
    //GETTERS / SETTERS
    public function get_noPersonne()
    {
        return $this->_noPersonne;
    }

    public function set_noPersonne( $_noPersonne )
    {
        $this->_noPersonne = $_noPersonne;
    }

    public function get_noTelephone()
    {
        return $this->_noTelephone;
    }

    public function set_noTelephone( $_noTelephone )
    {
        $this->_noTelephone = $_noTelephone;
    }

    public function get_numTelephone()
    {
        return $this->_numTelephone;
    }

    public function set_numTelephone( $_numTelephone )
    {
        $this->_numTelephone = $_numTelephone;
    }

    public function get_labelTelephone()
    {
        return $this->_labelTelephone;
    }

    public function set_labelTelephone( $_labelTelephone )
    {
        $this->_labelTelephone = $_labelTelephone;
    }

    public function get_mapper()
    {
        return $this->_mapper;
    }

    public function set_mapper( $_mapper )
    {
        $this->_mapper = $_mapper;
    }

}

?>
