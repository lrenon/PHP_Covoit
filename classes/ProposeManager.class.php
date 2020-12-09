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

    public function getAllTrajets($vil_num1, $vil_num2, $pro_date, $precision, $pro_time)
    {
        $listeTrajets = array();

        $sql = 'SELECT * FROM
                    (SELECT p.par_num, per_num, DATE_FORMAT(pro_date, "%Y-%m-%d") as pro_date, pro_time, pro_place, pro_sens FROM propose p 
                    INNER JOIN parcours p2 on p.par_num = p2.par_num
                    WHERE vil_num1 = :vil_num1 AND vil_num2 = :vil_num2 AND pro_sens = 0
                    UNION
                    SELECT p.par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM propose p 
                    INNER JOIN parcours p2 on p.par_num = p2.par_num
                    WHERE vil_num1 = :vil_num2 AND vil_num2 = :vil_num1 AND pro_sens = 1) A
                WHERE pro_place > 0 AND pro_time >= :pro_time AND pro_date BETWEEN (DATE_ADD((:pro_date), INTERVAL -(:precision) DAY)) AND (DATE_ADD((:pro_date), INTERVAL (:precision) DAY))
                ORDER BY pro_date, pro_time';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':vil_num1', $vil_num1);
        $requete->bindValue(':vil_num2', $vil_num2);
        $requete->bindValue(':pro_time', $pro_time);
        $requete->bindValue(':pro_date', $pro_date);
        $requete->bindValue(':precision', $precision);
        $requete->execute();

        while ($trajet = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeTrajets[] = new Propose($trajet);
        }

        $requete->closeCursor();
        return $listeTrajets;
    }

    public function getProSens($vil_num1, $vil_num2)
    {
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

    public function getAllDeparts()
    {
        $villes_depart = array();

        $sql = 'SELECT vil_num, vil_nom FROM ville v 
                INNER JOIN parcours p on v.vil_num = p.vil_num1
                INNER JOIN propose p2 on p.par_num = p2.par_num
                WHERE pro_sens = 0
                UNION
                SELECT vil_num, vil_nom FROM ville v2
                INNER JOIN parcours p3 on v2.vil_num = p3.vil_num2
                INNER JOIN propose p4 on p3.par_num = p4.par_num
                WHERE pro_sens = 1';

        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
            $villes_depart[] = new Ville($ville);
        }

        $requete->closeCursor();
        return $villes_depart;
    }
}