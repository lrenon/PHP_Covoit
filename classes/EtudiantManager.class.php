<?php

class EtudiantManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterEtudiant($etudiant, $per_num)
    {
        $sql = 'INSERT INTO etudiant (per_num, dep_num, div_num) VALUES (:per_num, :depnum, :divnum)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':per_num', $per_num);
        $requete->bindValue(':depnum', $etudiant->getDepNum());
        $requete->bindValue(':divnum', $etudiant->getDivNum());

        $retour = $requete->execute();
        $requete->closeCursor();

        return $retour;
    }

    public function getAllEtudiants()
    {
        $listeEtudiants = array();
        $sql = 'SELECT per_num, dep_num, div_num FROM etudiant ORDER BY 1';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($etudiant = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeEtudiants[] = new Etudiant($etudiant);
        }

        $requete->closeCursor();
        return $listeEtudiants;
    }
}