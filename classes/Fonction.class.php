<?php

class Fonction
{
    //VARIABLES
    private $fon_num;
    private $fon_libelle;

    //CONSTRUCTEUR
    public function __construct($valeurs = array())
    {
        if (!empty($valeurs)) {
            $this->affecte($valeurs);
        }
    }

    //METHODES
    public function affecte($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            switch ($attribut) {
                case 'fon_num':
                    $this->setFonNum($valeur);
                    break;
                case 'fon_libelle':
                    $this->setFonLibelle($valeur);
                    break;
            }
        }
    }

    //GETTERS ET SETTERS
    public function getFonNum()
    {
        return $this->fon_num;
    }

    public function setFonNum($fon_num)
    {
        $this->fon_num = $fon_num;
    }

    public function getFonLibelle()
    {
        return $this->fon_libelle;
    }

    public function setFonLibelle($fon_libelle)
    {
        $this->fon_libelle = $fon_libelle;
    }
}