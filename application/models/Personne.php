<?php

class Application_Model_Personne
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id de Personne
     *
     * @var int
     */
    protected $_noPersonne;

    /**
     * Nom de Personne
     * @var string
     */
    protected $_nom;

    /**
     * Prenom de Personne
     * @var string
     */
    protected $_prenom;

    /**
     * 2nd Prenom de Personne
     * @var string
     */
    protected $_prenom2;

    /**
     * 3rd prenom de Personne
     * @var string
     */
    protected $_prenom3;

    /**
     * Date de naissance
     * format : YYYY-MM-JJ
     * @var date
     */
    protected $_dateNaissance;

    /**
     * lien vers ue autre personne (noPersonne)
     * @var int
     */
    protected $_responsableLegal;

    /**
     * Numero de sécurité sociale
     * 15 chiffres
     * @var int
     */
    protected $_noINSEE;

    /**
     * Clé etrangère vers la table adresse
     * @var int
     */
    protected $_noAdresse;

    /**
     * Clé etrangere vers la table pays
     * @var string
     */
    protected $_labelPays;

    /**
     *  Mail de la personne (sert de login)
     * @var string
     */
    protected $_email;

    /**
     * password de connection de la personne
     * @var string
     */
    protected $_password;

    /**
     * role ACL associé (stocké en session apres authentification)
     * @var string
     */
    protected $_role;
    protected $_password_salt;

    /**
     * Mapper associé au modele
     * @var Application_Model_PersonneMapper
     */
    protected $_mapper;
    //--------------------------------------------------------------------------
    //info externes à recuperer d'autres tables
    //--------------------------------------------------------------------------
    //Telephone
    /**
     * Tableau d'objet telephone associé à la personne
     * @var array (Application_Model_Telephone)
     */
    protected $_telephone = array();
    //Adresse
    /**
     * objet Adresse associé
     *
     * @var Application_Model_Adresse
     */
    protected $_adresse;

    //--------------------------------------------------------------------------
    //constructeur
    //--------------------------------------------------------------------------
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Personne');
    }

    //--------------------------------------------------------------------------
    //Methodes
    //--------------------------------------------------------------------------
    //Recuperation de l'adresse
    public function _getAdresseForPersonne()
    {
        $objAdresse = Application_Model_Adresse::getAdresse($this->_noAdresse);
        if (isEmpty($objAdresse) || !isset($objAdresse)) {
            return false;
        }
        return $objAdresse;
    }

    //TODO : a bouger dans le modele Telephone (ou pas)
    /**
     * Recuperation des id des numéros de téléphond'une personne
     * @param int $id
     * @return array $return Tableau de tableau
     * @access protected
     * @author pewho
     */
    protected function _getNoTelephoneForPersonne($id)
    {
        $return = Application_Model_PersonneHasTelephoneMapper::getTelephonesByIdPersonne($id);
        return $return;
    }

    //--------------------------------------------------------------------------
    /**
     * Recuperation d'une liste de toutes les personnes
     * @return array
     * @access public
     * @author pewho
     */
    public static function getListePersonne()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Personne');
        try {
            $return = $mapper->fetchAll();
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
        return $return;
    }

    /**
     * Récupère une personne suivant son id
     * @param int $id
     * @return Personne
     * @author pewho
     * @access public
     * @static
     */
    public static function getPersonneById($id)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Personne');
        try {
            $return = $mapper->find($id);
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
        return $return;
    }
    
    /**
     * Récupère une personne suivant son numéro Insee
     * @param int $noInsee
     * @return Personne
     * @author Camille
     * @access public
     * @static
     */
    public static function getPersonneByNoInsee($noInsee)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Personne');
        try {            
            $personne = $mapper->findByNoInsee($noInsee);            
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
        return $personne;
    }

    /**
     * Recupere une personne suivant son email
     * @param string $mail
     * @return Personne
     * @access Public
     * @author pewho
     */
    public static function getPersonneByMail($mail)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Personne');
        try {
            $return = $mapper->selectByMail($mail);
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
        return $return;
    }

    /** Sauve une Personne en base de donnée suivant son Id
     *
     * @param int $id
     * @return void
     * @access public
     * @author pewho
     */
    public function savePersonneById($id)
    {
        try {
            $this->_mapper->save($this, 'noPersonne');
        } catch (Spesx_Mapper_Exception $e) {
            Spesx_Log::Log(
                $e->getMessage() . ' ' . $e->getPrevious()->getMessage(), Zend_Log::ERR);
        }
    }

    //--------------------------------------------------------------------------
    //GETTER / SETTER
    //--------------------------------------------------------------------------
    public function get_noPersonne()
    {
        return $this->_noPersonne;
    }

    public function set_noPersonne($_noPersonne)
    {
        $this->_noPersonne = $_noPersonne;
        return $this;
    }

    public function get_nom()
    {
        return $this->_nom;
    }

    public function set_nom($_nom)
    {
        $this->_nom = $_nom;
        return $this;
    }

    public function get_prenom()
    {
        return $this->_prenom;
    }

    public function set_prenom($_prenom)
    {
        $this->_prenom = $_prenom;
        return $this;
    }

    public function get_prenom2()
    {
        return $this->_prenom2;
    }

    public function set_prenom2($_prenom2)
    {
        $this->_prenom2 = $_prenom2;
        return $this;
    }

    public function get_prenom3()
    {
        return $this->_prenom3;
    }

    public function set_prenom3($_prenom3)
    {
        $this->_prenom3 = $_prenom3;
        return $this;
    }

    public function get_dateNaissance()
    {
        return $this->_dateNaissance;
    }

    public function set_dateNaissance($_dateNaissance)
    {
        $this->_dateNaissance = $_dateNaissance;
        return $this;
    }

    public function get_responsableLegal()
    {
        return $this->_responsableLegal;
    }

    public function set_responsableLegal($_responsableLegal)
    {
        $this->_responsableLegal = $_responsableLegal;
        return $this;
    }

    public function get_noINSEE()
    {
        return $this->_noINSEE;
    }

    public function set_noINSEE($_noINSEE)
    {
        $this->_noINSEE = $_noINSEE;
        return $this;
    }

    public function get_noAdresse()
    {
        return $this->_noAdresse;
    }

    public function set_noAdresse($_noAdresse)
    {
        $this->_noAdresse = $_noAdresse;
        return $this;
    }

    public function get_labelPays()
    {
        return $this->_labelPays;
    }

    public function set_labelPays($_labelPays)
    {
        $this->_labelPays = $_labelPays;
        return $this;
    }

    public function get_email()
    {
        return $this->_email;
    }

    public function set_email($_email)
    {
        $this->_email = $_email;
        return $this;
    }

    public function get_role()
    {
        return $this->_role;
    }

    public function set_role($_role)
    {
        $this->_role = $_role;
        return $this;
    }

    public function get_password()
    {
        return $this->_password;
    }

    public function set_password($_password)
    {
        $this->_password = $_password;
        return $this;
    }

    public function get_password_salt()
    {
        return $this->_password_salt;
    }

    public function set_password_salt($_password_salt)
    {
        $this->_password_salt = $_password_salt;
        return $this;
    }

}
?>
