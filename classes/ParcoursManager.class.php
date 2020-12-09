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
        $parcours1 = $this->getParcours($parcours->getVilNum1(), $parcours->getVilNum2());
        $parcours2 = $this->getParcours($parcours->getVilNum2(), $parcours->getVilNum1());

        if ($parcours1 != null || $parcours2 != null)
            return false;
        else {
            $sql = 'INSERT INTO parcours (vil_num1, vil_num2, par_km) VALUES (:vil_num1, :vil_num2, :par_km)';
            $requete = $this->db->prepare($sql);
            $requete->bindValue(':par_km', $parcours->getParKm());
            $requete->bindValue(':vil_num1', $parcours->getVilNum1());
            $requete->bindValue(':vil_num2', $parcours->getVilNum2());
            $retour = $requete->execute();

            $requete->closeCursor();
            return $retour;
        }
    }

    public function getParcours($vil_num1, $vil_num2)
    {
        $sql = 'SELECT par_num FROM parcours WHERE (vil_num1 = :vil_num1 AND vil_num2 = :vil_num2) OR (vil_num1 = :vil_num2 AND vil_num2 = :vil_num1)';

        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_num1', $vil_num1);
        $requete->bindValue(':vil_num2', $vil_num2);
        $requete->execute();

        $par_num = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        return $par_num->par_num;
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

    public function getAllVilles()
    {
        $sql = 'SELECT DISTINCT vil_num, vil_nom FROM ville WHERE vil_num IN (SELECT vil_num1 FROM parcours) OR vil_num IN (SELECT vil_num2 FROM parcours)';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        $listeVilles = array();
        while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeVilles[] = new Ville($ville);
        }

        $requete->closeCursor();
        return $listeVilles;
    }

    public function getAllArrivees($vil_num1)
    {
        $sql = 'SELECT DISTINCT vil_num, vil_nom FROM ville 
                WHERE vil_num IN 
                    (SELECT vil_num1 FROM parcours WHERE vil_num2 = :vil_num1 ) 
                OR vil_num IN 
                   (SELECT vil_num2 FROM parcours WHERE vil_num1 = :vil_num1)';

        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_num1', $vil_num1);
        $requete->execute();

        $listeVilles = array();
        while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeVilles[] = new Ville($ville);
        }

        $requete->closeCursor();
        return $listeVilles;
    }

}