<?php
require_once 'Conge.php';

class CongeTest extends PHPUnit_Framework_TestCase {
    protected $conge;
    
    protected function setUp()
    {
        $this->conge = new Conge;
    }
    
    //Une demande de congé est initialement placée en attente
    public function testCongeIsInitiallyEnAttente()
    {
        $this->assertEquals(1, $this->conge->get_enAttentedeTraitement());
    }
    
    //Vérifie les dates de congé
    public function testDateFinIsSupDateDebut()
    {
        //Récupère les dates 
        $dateDebut = $this->conge->get_dateDebut();
        $dateFin = $this->conge->get_dateFin();
        
        //Enlève les "-" et stocke les chiffres dans un array
        $debut = explode("-", $dateDebut); // $debut[0] = dd, $debut[1] = mm et $debut[2] = aaaa
        $fin = explode("-", $dateFin); //idem
        
        //Concatène les chiffres dans l'ordre inverse
        $d = $debut[2].$debut[1].$debut[0]; //aaaammdd
        $f = $fin[2].$fin[1].$fin[0];
        
         //Vérifie si la date de fin $f est supérieure à la date debut $d
        $this->assertGreaterThan($d, $f);
    }
    
    //Vérifie que les congés soit bien compris dans l'année en cours
    public function testDateDebutIsSupOrEqDateAnnee()
    {
        //Récupère les dates début et annee
        $dateDebut = $this->conge->get_dateDebut();
        $dateAnnee = $this->conge->get_dateDebut_Annee();
        
        //Enlève les "-" et stocke les chiffres dans un array
        $debut = explode("-", $dateDebut); // $debut[0] = dd, $debut[1] = mm et $debut[2] = aaaa
        $annee = explode("-", $dateAnnee); //idem
        
        //Concatène les chiffres dans l'ordre inverse
        $d = $debut[2].$debut[1].$debut[0]; //aaaammdd
        $a = $annee[2].$annee[1].$annee[0];
        
         //Vérifie si la date de debut du congé est égale ou est supérieure à la date annee $d
        $this->assertGreaterThanOrEqual($a, $d);
    }
    
    //Vérifie la durée du congé selon la durée max
    public function testDureeCongeIsCorrect()
    {
        //Récupère les dates début et fin du congé
        $dateDebut = $this->conge->get_dateDebut();
        $dateFin = $this->conge->get_dateFin();
        
        //Enlève les "-" et stocke les chiffres dans un array
        $debut = explode("-", $dateDebut); // $debut[0] = dd, $debut[1] = mm et $debut[2] = aaaa
        $fin = explode("-", $dateFin); //idem
        
        //Concatène les chiffres dans l'ordre inverse
        $d = $debut[2].$debut[1].$debut[0]; //aaaammdd
        $f = $fin[2].$fin[1].$fin[0];
        
         //Vérifie si la durée du congé est inférieure ou égal à 30 jours
        $this->assertLessThanOrEqual(20, (intval($f)-intval($d)));
    }
}

?>
