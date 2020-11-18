<?php

class DepartementManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterDepartement($departement)
    {
        $sql = 'INSERT INTO departement (dep_nom, vil_num) VALUES (:depnom, :vilnum)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':depnom', $departement->getDepNom());
        $requete->bindValue(':vilnum', $departement->getVilNum());

        $retour = $requete->exectue();
        $requete->closeCursor();

        return $retour;
    }

    public function getAllDepartements()
    {
        $listeDepartements = array();
        $sql = 'SELECT dep_num, dep_nom, vil_num FROM departement ORDER BY 1';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($departement = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeDepartements[] = new Departement($departement);
        }

        $requete->closeCursor();
        return $listeDepartements;
    }
}