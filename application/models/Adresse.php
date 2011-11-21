<?php
/**
 * Modele de l'objet adresse
 * @author pewho
 */
class Application_Model_Adresse
{
    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id de l'Adresse
     * @var int
     */
    protected $_noAdresse;

    /**
     * Numero de porte
     * @var string
     */
    protected $_numero;

    /**
     * mention suplementaire
     * @var string
     */
    protected $_porte;

    /**
     * adresse
     * @var string
     */
    protected $_adresse;

    /**
     * etage de l'appartement
     * @var string
     */
    protected $_etage;

    /**
     * immeuble de l'appartement
     * @var string
     */
    protected $_immeuble;

    /**
     * Commentaire supl.
     * @var string
     */
    protected $_commentaire;

    /**
     * CP
     * @var string
     */
    protected $_codepostal;

    /**
     * Etat / region
     * @var string
     */
    protected $_etatProvince;

    /**
     * cle vers la ville
     * @var string
     */
    protected $_labelVille;

    /**
     * cle vers le pays
     * @var string
     */
    protected $_labelPays;

    /**
     * Mapper de l'objet
     * @var Application_Model_AdresseMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * @return void
     * @author pewho
     */
    public function __construct()
    {
       $this->_mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Adresse');
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauve une adresse en bdd, pour une modification ou un ajout (suivant
     * la definition de noAdresse
     *
     * @author pewho
     * @access public
     *
     */
    public function addAdresse()
    {
        $this->_mapper->save($this,'noAdresse');
    }
    /**
     * Retourne un objet adresse correspondant à l'id fourni en parametre
     * Si l'id n'existe pas, retourne 'null'
     *
     * @access public
     * @author pewho
     * @param int $id
     * @return null|Application_Model_adresse
     */
    public static function getAdresse($id)
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper('Application_Model_Adresse');
        return $mapper->find($id);
    }

    //--------------------------------------------------------------------------
    //Getter / setter
    //--------------------------------------------------------------------------
    public function get_noAdresse()
    {
        return $this->_noAdresse;
    }

    public function set_noAdresse($_noAdresse)
    {
        $this->_noAdresse = $_noAdresse;
        return $this;
    }

    public function get_numero()
    {
        return $this->_numero;
    }

    public function set_numero($_numero)
    {
        $this->_numero = $_numero;
        return $this;
    }

    public function get_porte()
    {
        return $this->_porte;
    }

    public function set_porte($_porte)
    {
        $this->_porte = $_porte;
        return $this;

    }

    public function get_adresse()
    {
        return $this->_adresse;
    }

    public function set_adresse($_adresse)
    {
        $this->_adresse = $_adresse;
        return $this;
    }

    public function get_etage()
    {
        return $this->_etage;
    }

    public function set_etage($_etage)
    {
        $this->_etage = $_etage;
        return $this;
    }

    public function get_immeuble()
    {
        return $this->_immeuble;
    }

    public function set_immeuble($_immeuble)
    {
        $this->_immeuble = $_immeuble;
        return $this;
    }

    public function get_commentaire()
    {
        return $this->_commentaire;
    }

    public function set_commentaire($_commentaire)
    {
        $this->_commentaire = $_commentaire;
        return $this;
    }

    public function get_codepostal()
    {
        return $this->_codepostal;
    }

    public function set_codepostal($_codepostal)
    {
        $this->_codepostal = $_codepostal;
        return $this;
    }

    public function get_etatProvince()
    {
        return $this->_etatProvince;
    }

    public function set_etatProvince($_etatProvince)
    {
        $this->_etatProvince = $_etatProvince;
        return $this;
    }

    public function get_labelVille()
    {
        return $this->_labelVille;
    }

    public function set_labelVille($_labelVille)
    {
        $this->_labelVille = $_labelVille;
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

}
?>
