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
        $sql = 'INSERT INTO propose (per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:pernum, :date, :time, :place, :sens)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':pernum', $trajet->getPerNum());
        $requete->bindValue(':date', $trajet->getProDate());
        $requete->bindValue(':time', $trajet->getProTime());
        $requete->bindValue(':place', $trajet->getProPlace());
        $requete->bindValue(':sens', $trajet->getProSens());


        $retour = $requete->exectue();
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
}