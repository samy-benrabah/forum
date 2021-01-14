<?php

class messages{

    public $id_topic;
    public $id_conversation;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=forum;host=localhost',"root","");
        $this->allresult=array();

    }

    public function afficherTopic()
    {
        $query = $this->pdo->prepare("SELECT id,nom_topic FROM `topic`");
        $query->execute();
        $this->allresult_topic=$query->fetchAll();
        return true;
    }

    public function afficherConversation($id_topic)
    {
        $query = $this->pdo->prepare("SELECT id,nom_conversation FROM `conversations` WHERE id_topic=:id");
        $query->execute(["id" => $id_topic]);
        $this->id_topic=$id_topic;
        $this->allresult_conversation=$query->fetchAll();
        return true;
    }

    public function afficherMessage($id_conversation)
    {
        $query = $this->pdo->prepare("SELECT id, titre, message, id_utilisateur ,login, date FROM `messages` WHERE id_conversation=:id");
        $query->execute(["id" => $id_conversation]);
        $this->id_conversation=$id_conversation;
        $this->allresult_messages=$query->fetchAll();
        return true;
    }

    public function ajouterMessage($titre, $message, $id_conversation, $id_utilisateur, $login, $date)
    {
        $query = $this->pdo->prepare("INSERT INTO `messages`(`titre`, `message`, `id_conversation`, `id_utilisateur`, `login`, `date`) VALUES (':titre', ':message', ':id_conversation', ':id_utilisateur', ':login', ':date' ");
        $query->execute(["titre"=>$titre, "message"=>$message, "id_conversation"=>$id_conversation, "id_utilisateur"=>$id_utilisateur, "login"=>$login, "date"=>$date]);
    }   

    public function setConversation($id_conversation)
    {
        $this->id_conversation=$id_conversation;
    }

    public function getConversation()
    {
        return $this->id_conversation;
    }




}
?>