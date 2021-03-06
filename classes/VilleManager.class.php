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
    public function ajouterVille($ville)
    {
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

    public function getAllVilles()
    {
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

    public function getVilNom($vil_num)
    {
        $sql = 'SELECT vil_nom FROM ville WHERE vil_num =' . $vil_num;
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $vil_nom = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $vil_nom->vil_nom;
    }

    public function getNbrVilles()
    {
        $sql = 'SELECT COUNT(vil_num) AS nbrVilles FROM ville';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $nbrVilles = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $nbrVilles->nbrVilles;
    }

    public function getVille($vil_num) {
        $sql = 'SELECT * FROM ville WHERE vil_num = ' . $vil_num;
        $requete = $this->db->prepare($sql);
        $requete->execute();

        return new Ville($requete->fetch(PDO::FETCH_OBJ));
    }
}