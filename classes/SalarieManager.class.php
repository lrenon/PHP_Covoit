<?php

class SalarieManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterSalarie($salarie, $per_num)
    {
        $sql = 'INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES (:per_num, :telprof, :fonnum)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':per_num', $per_num);
        $requete->bindValue(':telprof', $salarie->getSalTelprof());
        $requete->bindValue(':fonnum', $salarie->getFonNum());

        $retour = $requete->execute();
        $requete->closeCursor();

        return $retour;
    }

    public function getSalarie($per_num) {
        $sql = 'SELECT * FROM salarie WHERE per_num = ' . $per_num;
        $requete = $this->db->prepare($sql);
        $requete->execute();

        return new Salarie($requete->fetch(PDO::FETCH_OBJ));
    }
}