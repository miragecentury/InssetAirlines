<?php

class ServLogCom_Model_RegimeAlimentaire
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * id du regimeAlimentaire
     * @var int
     */
    protected $_noRegimeAlimentaire;

    /**
     * label du regimeAlimentaire
     * @var string
     */
    protected $_labelRegimeAlimentaire;

    /**
     * Mapper de l'objet
     * @var ServLogCom_Model_RegimeAlimentaireMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_RegimeAlimentaire");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Sauvegarde un RegimeAlimentaire, selon l'existence ou non du 
     * labelRegimeAlimentaire, il est ajouté ou modifié
     *
     * @author charles
     * @access public
     *
     */
    public function addRegimeAlimentaire()
    {
        $this->_mapper->save($this, 'noRegimeAlimentaire');
    }

    /**
     * Suprime un ou plusieurs RegimeAlimentaire a partir
     * d'un nom de col et d'une valeur
     *
     * @author charles
     * @access public
     * @param string $val, string col
     *
     */
    public function delRegimeAlimentaire($noRegimeAlimentaire)
    {
        try {
            $this->_mapper->delete('noRegimeAlimentaire', $noRegimeAlimentaire);
        } catch (Zend_Exception $e) {
            echo 'ServLogCom_Models_RegimeAlimentaire_delRegimeAlimentaire() 
                Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne un RegimeAlimentaire a partir de l'id fourni en parametre.
     * Si l'id n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $id
     * @return null|ServLogCom_Model_RegimeAlimentaire
     *  
     */
    public function getRegimeAlimentaire($noRegimeAlimentaire)
    {
        return $this->_mapper->find($noRegimeAlimentaire);
    }

    /**
     * Retourne un Regime Alimentaire sous forme de tableau HTML
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public function getRegimeAlimentaireHTML()
    {
        $regimeAlimentaire = "<div>Id : " . $this->get_noRegimeAlimentaire() . "</div>";
        $regimeAlimentaire.= "<div>Regime Alimentaire : " . $this->get_labelRegimeAlimentaire() . "</div>";
        return $regimeAlimentaire;
    }

    /**
     * Retourne tout les RegimeAlimentaire, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(ServLogCom_Model_RegimeAlimentaire)
     *  
     */
    public static function getListeRegimeAlimentaire()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServLogCom_Model_RegimeAlimentaire");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
        return $return;
    }

    /**
     * Retourne tous les regimeAlimentaire sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeRegimeAlimentaireHTML()
    {
        $allRA = ServLogCom_Model_RegimeAlimentaire::getListeRegimeAlimentaire();


        if (!empty($allRA)) {
            $tableau = "<table>
                        <tr>
                            <td>Id</td>
                            <td>Regime Alimentaire</td>
                            <td></td>
                            <td></td>
                        </tr>";

            foreach ($allRA as $val) {
                $tableau .= "<tr>
                                <td>" . $val->get_noRegimeAlimentaire() . "</td>
                                <td>" . $val->get_labelRegimeAlimentaire() . "</td>
                                <td><a href='/ServLogCom/Regimealimentaire/upd?id=" . $val->get_noRegimeAlimentaire() . "'>Modifier</a></td>
                                <td><a href='/ServLogCom/Regimealimentaire/del?id=" . $val->get_noRegimeAlimentaire() . "'>Supprimer</a></td>
                            </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas de Regime Alimentaire dans la base de donnée</div>";
        }
        return $tableau;
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noRegimeAlimentaire()
    {
        return $this->_noRegimeAlimentaire;
    }

    public function set_noRegimeAlimentaire($_noRegimeAlimentaire)
    {
        $this->_noRegimeAlimentaire = $_noRegimeAlimentaire;
        return $this;
    }

    public function get_labelRegimeAlimentaire()
    {
        return $this->_labelRegimeAlimentaire;
    }

    public function set_labelRegimeAlimentaire($_labelRegimeAlimentaire)
    {
        $this->_labelRegimeAlimentaire = $_labelRegimeAlimentaire;
        return $this;
    }

}

?>
