<?php

class ProposeManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterTrajet($trajet)
    {
        $sql = 'INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:parnum, :pernum, :date, :time, :place, :sens)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':parnum', $trajet->getParNum());
        $requete->bindValue(':pernum', $trajet->getPerNum());
        $requete->bindValue(':date', $trajet->getProDate());
        $requete->bindValue(':time', $trajet->getProTime());
        $requete->bindValue(':place', $trajet->getProPlace());
        $requete->bindValue(':sens', $trajet->getProSens());


        $retour = $requete->execute();
        $requete->closeCursor();

        return $retour;
    }

    public function getAllTrajets()
    {
        $listeTrajets = array();
        $sql = 'SELECT par_num, pro_date, pro_time, pro_place, pro_sens FROM propose ORDER BY 2';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($trajet = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeTrajets[] = new Propose($trajet);
        }

        $requete->closeCursor();
        return $listeTrajets;
    }

    public function getProSens($vil_num1, $vil_num2) {
        $sql = 'SELECT par_num FROM parcours WHERE vil_num1 = :vil_num1 AND vil_num2 = :vil_num2';

        $requete = $this->db->prepare($sql);
        $requete->bindValue(':vil_num1', $vil_num1);
        $requete->bindValue(':vil_num2', $vil_num2);
        $requete->execute();

        if ($requete->rowCount() == 0) {
            return 0;
        }
        return 1;
    }
}