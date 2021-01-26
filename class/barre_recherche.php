<?php
require_once 'user.php';

class Recherche
{
    private $pdo;
    private $submit;
    private $search;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=forum;host=localhost', "root", "");
    }

    public function recherche_topic($search, $submit)
    {
        if (isset($submit) and !empty($search)) {
            $this->submit = htmlspecialchars(trim($submit));
            $this->search = htmlspecialchars(trim($search));
            $alltopics = $this->pdo->prepare("SELECT nom_topic FROM topic WHERE nom_topic LIKE " % '.$search.' % " ORDER BY id DESC");
            $alltopics->execute();

            if ($alltopics->rowCount() > 0) {
                while ($user = $alltopics->fetch(PDO::FETCH_OBJ)) {
                    echo $user->nom_topic;
                }
            } else {
                echo "Aucun résultat";
            }
        }

    }
}
