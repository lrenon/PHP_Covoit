<?php

class ParcoursManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterParcours($parcours)
    {
        $sql = 'INSERT INTO parcours (vil_num1, vil_num2, par_km) VALUES (:vil_num1, :vil_num2, :par_km)';
        $requete = $this->db->prepare($sql);
        $requete->bindValue(':par_km', $parcours->getParKm());
        $requete->bindValue(':vil_num1', $parcours->getVilNum1());
        $requete->bindValue(':vil_num2', $parcours->getVilNum2());
        $retour = $requete->execute();

        $requete->closeCursor();
        return $retour;
    }

    public function getAllParcours()
    {
        $listeParcours = array();
        $sql = 'SELECT par_num, vil_num1, vil_num2, par_km FROM parcours ORDER BY par_num';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($parcours = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeParcours[] = new Parcours($parcours);
        }

        $requete->closeCursor();
        return $listeParcours;
    }

    public function getNbrParcours()
    {
        $sql = 'SELECT COUNT(par_num) AS nbrParcours FROM parcours';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $nbrParcours = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $nbrParcours->nbrParcours;
    }

}