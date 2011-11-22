<?php

class ServCommercial_Model_Agence
{

    //--------------------------------------------------------------------------
    //Attributs
    //--------------------------------------------------------------------------
    /**
     * numero de l'agence
     * @var int
     */
    protected $_noAgence;

    /**
     * label de l'agence
     * @var string
     */
    protected $_labelAgence;

    /**
     * date de lancement
     * @var int
     */
    protected $_dateLancement;

    /**
     * date de cloture
     * @var int
     */
    protected $_dateCloture;

    /**
     * Acces extranet, 0 si inactif, 1 si actif
     * @var bool
     */
    protected $_accesExtranet;

    /**
     * numero de l'adresse
     * @var int
     */
    protected $_noAdresse;

    /**
     * Mapper de l'objet
     * @var ServCommercial_Model_AgenceMapper
     */
    private $_mapper;

    /**
     * Constructeur
     * return void
     * @author charles
     */
    public function __construct()
    {
        $this->_mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Agence");
    }

    //--------------------------------------------------------------------------
    // Methodes
    //--------------------------------------------------------------------------
    /**
     * Ajoute ou modifie une agence dans la BD.
     *
     * @author charles
     * @access public
     *
     */
    public function addAgence()
    {
        $this->_mapper->save($this, 'noAgence');
    }

    /**
     * Suprime une agence a partir de son noIncident
     *
     * @author charles
     * @access public
     * @param int $noAgence
     *
     */
    public function delAgence($noAgence)
    {
        try {
            $this->_mapper->delete('noAgence', $noAgence);
        } catch (Zend_Exception $e) {
            echo 'Serv_Commercial_Models_Agence_delAgence() Exception - ' .
            $e->getMessage() . ' - ' . $e->getPrevious();
        }
    }

    /**
     * Retourne une Agence sous forme de tableau HTML
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public function getAgenceHTML()
    {
        $Incident = "<table class='grid_16'>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Id</td>
                    <td class='grid_3'>" . $this->get_noAgence() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Label</td>
                    <td class='grid_3'>" . $this->get_labelAgence() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Date de Lancement</td>
                    <td class='grid_3'>" . $this->get_dateLancement() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>Date de Cloture</td>
                    <td class='grid_3'>" . $this->get_dateCloture() . "</td>
                </tr>
                <tr bgcolor='#CCCCCC'>
                    <td class='grid_3'>Acces Extranet</td>
                    <td class='grid_3'>" . $this->get_accesExtranet() . "</td>
                </tr>
                <tr>
                    <td class='grid_3'>No Adresse</td>
                    <td class='grid_3'>" . $this->get_noAdresse() . "</td>
                </tr>
            </table>";
        return $Incident;
    }

    /**
     * Retourne une Agence a partir de son noAgence
     * Si elle n'existe pas, retourne null.
     * 
     * @access public
     * @author charles
     * @param int $noAgence
     * @return null|ServCommercial_Model_Agence
     *  
     */
    public function getAgence($noAgence)
    {
        return $this->_mapper->find($noAgence);
    }

    /**
     * Retourne tous les incidents sous forme de tableau html, 
     * retourne une phrase disant qu'il n'y en a pas dans la bd si c'est le cas
     * 
     * @access public
     * @author charles
     * @return string
     *  
     */
    public static function getListeAgenceHTML()
    {
        $html = ServCommercial_Model_Agence::getListeAgence();
        $color = true;

        if (!empty($html)) {
            $tableau = "<table class='grid_16'>
                        <tr>
                            <td class='grid_1'>Id</td>
                            <td class='grid_3'>Label</td>
                            <td class='grid_2'>Lancement</td>
                            <td class='grid_2'>Date de Cloture</td>
                            <td class='grid_1'>Extranet</td>
                            <td class='grid_1'>Adresse</td>
                            <td class='grid_1'></td>
                            <td class='grid_2'></td>
                        </tr>";

            foreach ($html as $val) {
                if ($color) {
                    $tableau .= "<tr bgcolor='#CCCCCC'>";
                }
                $color = !$color;
                $tableau .= "<td class='grid_1'>" . $val->get_noAgence() . "</td>
                                <td class='grid_3'>" . $val->get_labelAgence() . "</td>
                                <td class='grid_2'>" . $val->get_dateLancement() . "</td>";
                if ($val->get_dateCloture() != null) {
                    $tableau .= "<td class='grid_2'>" . $val->get_dateCloture() . "</td>";
                } else {
                    $tableau .= "<td class='grid_2'>Actif</td>";
                }
                $tableau .= "<td class='grid_1'>";
                if ($val->get_accesExtranet() == 1)
                    $tableau .= "Actif";
                else
                    $tableau .= "Inactif";
                $tableau .= "</td>
                                <td class='grid_1'>" . $val->get_noAdresse() . "</td>
                                <td class='grid_1'><a href='/ServCommercial/Agence/upd?id=" . $val->get_noAgence() . "'>Modifier</a></td>
                                <td class='grid_2'><a href='/ServCommercial/Agence/del?id=" . $val->get_noAgence() . "'>Supprimer</a></td>
                            </tr>";
            }
            $tableau .= "</table>";
        } else {
            $tableau = "<div>Il n'y a pas d'incident dans la base de donnée</div>";
        }
        return $tableau;
    }

    /**
     * Retourne toutes les agences, null si il n'y en as pas dans la BD
     * 
     * @access public
     * @author charles
     * @return null|array(Application_Model_Agence)
     *  
     */
    public static function getListeAgence()
    {
        $mapper = Spesx_Mapper_MapperFactory::getMapper("ServCommercial_Model_Agence");
        try {
            return $mapper->findAll();
        } catch (Spesx_Mapper_Exception $e) {
            echo $e->getMessage() . " - " . $e->getPrevious()->getMessage();
        }
    }

    //--------------------------------------------------------------------------
    // Getter / setter
    //--------------------------------------------------------------------------
    public function get_noAgence()
    {
        return $this->_noAgence;
    }

    public function set_noAgence($_noAgence)
    {
        $this->_noAgence = $_noAgence;
        return $this;
    }

    public function get_labelAgence()
    {
        return $this->_labelAgence;
    }

    public function set_labelAgence($_labelAgence)
    {
        $this->_labelAgence = $_labelAgence;
        return $this;
    }

    public function get_dateLancement()
    {
        return $this->_dateLancement;
    }

    public function set_dateLancement($_dateLancement)
    {
        $this->_dateLancement = $_dateLancement;
        return $this;
    }

    public function get_dateCloture()
    {
        return $this->_dateCloture;
    }

    public function set_dateCloture($_dateCloture)
    {
        $this->_dateCloture = $_dateCloture;
        return $this;
    }

    public function get_accesExtranet()
    {
        return $this->_accesExtranet;
    }

    public function set_accesExtranet($_accesExtranet)
    {
        $this->_accesExtranet = $_accesExtranet;
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

}

?>
