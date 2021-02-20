<?php
class Compteur
{
    private $fichier;
    private $compteur;

    public function __construct()
    {
        $this->fichier = fopen("class/compteur/compteur.txt", "r+");
        $this->compteur = fgets($this->fichier);
        $this->incrementation();
    }

    public function __destructor()
    {
        fclose($this->fichier);
    }

    public function incrementation()
    {

        fseek($this->fichier, 0);
        fputs($this->fichier, $this->compteur);
        $this->compteur++;

    }
    public function afficher_compteur()
    {
        return $this->compteur;
    }
}
