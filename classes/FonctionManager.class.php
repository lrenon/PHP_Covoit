<?php

class FonctionManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterFonction($fonction)
    {
        $sql = 'INSERT INTO fonction (fon_libelle) VALUES (:libelle)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':libelle', $fonction->getDepNom());

        $retour = $requete->exectue();
        $requete->closeCursor();

        return $retour;
    }

    public function getAllFonctions()
    {
        $listeFonctions = array();
        $sql = 'SELECT fon_num, fon_libelle FROM fonction ORDER BY 1';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($fonction = $requete->fetch(PDO::FETCH_OBJ)) {
            $listeFonctions[] = new Fonction($fonction);
        }

        $requete->closeCursor();
        return $listeFonctions;
    }
}