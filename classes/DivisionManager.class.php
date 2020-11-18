<?php

class DivisionManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterDivision($division)
    {
        $sql = 'INSERT INTO division (div_nom) VALUES (:divnom)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':divnom', $division->getDivNom());

        $retour = $requete->exectue();
        $requete->closeCursor();

        return $retour;
    }

    public function getAllDivisions()
    {
        $listeDivisions = array();
        $sql = 'SELECT div_num, div_nom FROM division ORDER BY 1';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($division = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeDivisions[] = new Division($division);
        }

        $requete->closeCursor();
        return $listeDivisions;
    }
}