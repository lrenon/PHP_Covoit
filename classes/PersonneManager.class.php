<?php

class PersonneManager
{
    //VARIABLES
    private $db;

    //CONSTRUCTEUR
    public function __construct($db)
    {
        $this->db = $db;
    }

    //METHODES
    public function ajouterPersonne($personne)
    {
        $sql = 'INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:nom, :prenom, :tel, :mail, :login, :pwd)';
        $requete = $this->db->prepare($sql);

        $requete->bindValue(':nom', $personne->getPerNom());
        $requete->bindValue(':prenom', $personne->getPerPrenom());
        $requete->bindValue(':tel', $personne->getPerTel());
        $requete->bindValue(':mail', $personne->getPerMail());
        $requete->bindValue(':login', $personne->getPerLogin());
        $requete->bindValue(':pwd', $personne->getPerPwd());

        $requete->execute();
        $requete->closeCursor();

        return $this->db->lastInsertId();
    }

    public function getAllPersonnes()
    {
        $listePersonnes = array();
        $sql = 'SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd FROM personne ORDER BY 1';
        $requete = $this->db->prepare($sql);
        $requete->execute();

        while ($personne = $requete->fetch(PDO::FETCH_OBJ)) {
            $listePersonnes[] = new Personne($personne);
        }

        $requete->closeCursor();
        return $listePersonnes;
    }

    public function getNbrPersonnes()
    {
        $sql = 'SELECT COUNT(per_num) AS nbrPersonnes FROM personne';
        $requete = $this->db->prepare($sql);
        $requete->execute();
        $nbrPersonnes = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();

        return $nbrPersonnes->nbrPersonnes;
    }
}