<?php

class VilleManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterVille($ville) {
        $sql = 'INSERT INTO ville (vil_nom) VALUES (:nom)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':nom', $ville->getVilNom());
        $retour = $requete->execute();

        //echo "<pre>";
        //print_r($requete->debugDumpParams());
        //echo"/<pre>";

        $requete->closeCursor();
        return $retour;
    }

    public function getAllVilles() {
        $listeVilles = array();
        $sql = 'SELECT vil_num, vil_nom FROM ville ORDER BY 2';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeVilles[] = new Ville($ville);
        }

        $requete->closeCursor();
        return $listeVilles;
    }

    public function getNbrVilles() {
        $sql = 'SELECT COUNT(vil_num) AS nbrVilles FROM ville';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $nbrVilles = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $nbrVilles->nbrVilles;
    }

}