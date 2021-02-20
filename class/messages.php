<?php

class messages
{

    public $id_topic;
    public $id_conversation;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=forum;host=localhost', "root", "");
        $this->allresult = array();

    }

    public function afficherTopic()
    {
        $query = $this->pdo->prepare("SELECT id,nom_topic,access FROM `topic`");
        $query->execute();
        $this->allresult_topic = $query->fetchAll();
        return true;
    }

    public function afficherTopicmembres()
    {
        $access = "membres";
        $access1 = "public";
        $query = $this->pdo->prepare("SELECT id,nom_topic,access FROM `topic` WHERE access=:access OR access=:access1");
        $query->execute(['access' => $access, 'access1' => $access1]);
        $this->allresult_topic_membres = $query->fetchAll();
        return true;
    }

    public function afficherTopicpublic()
    {
        $query = $this->pdo->prepare("SELECT id,nom_topic,access FROM `topic` WHERE access=:access");
        $query->execute(['access' => "public"]);
        $this->allresult_topic_public = $query->fetchAll();
        return true;
    }

    public function titreTopic($id_topic)
    {
        $query = $this->pdo->prepare("SELECT nom_topic FROM `topic` WHERE id=:id_topic");
        $query->execute(['id_topic' => $id_topic]);
        $this->titre_topic = $query->fetchColumn();
        return $this->titre_topic;
    }

    public function titreConversation($id_conversation)
    {
        $query = $this->pdo->prepare("SELECT nom_conversation FROM `conversations` WHERE id=:id_conversation");
        $query->execute(['id_conversation' => $id_conversation]);
        $this->titre_conversation = $query->fetchColumn();
        return $this->titre_conversation;
    }

    public function afficherConversation($id_topic)
    {
        $query = $this->pdo->prepare("SELECT id,nom_conversation FROM `conversations` WHERE id_topic=:id");
        $query->execute(["id" => $id_topic]);
        $this->id_topic = $id_topic;
        $this->allresult_conversation = $query->fetchAll();
        return true;
    }

    public function afficherMessage($id_conversation)
    {
        $query = $this->pdo->prepare("SELECT id, titre, message, id_utilisateur ,login, date FROM `messages` WHERE id_conversation=:id");
        $query->execute(["id" => $id_conversation]);
        $this->id_conversation = $id_conversation;
        $this->allresult_messages = $query->fetchAll();
        return true;
    }

    public function ajouterMessage($titre, $message, $id_conversation, $id_utilisateur, $login)
    {

        $query = $this->pdo->prepare("INSERT INTO `messages`(`titre`, `message`, `id_conversation`, `id_utilisateur`, `login`, `date`) VALUES (:titre, :message, :id_conversation, :id_utilisateur, :login, NOW())");
        $query->execute(["titre" => $titre, "message" => $message, "id_conversation" => $id_conversation, "id_utilisateur" => $id_utilisateur, "login" => $login]);
        return true;
    }

    public function supprimerMessage($id_message)
    {
        $query = $this->pdo->prepare("DELETE from messages WHERE id=:id_message");
        $query->execute(["id_message" => $id_message]);
    }

    public function ajouterConversation($nom_conversation, $login, $id_topic)
    {
        $query = $this->pdo->prepare("SELECT id FROM conversations WHERE nom_conversation=:nom_conversation");
        $query->execute(["nom_conversation" => $nom_conversation]);
        $check_conv = $query->fetchColumn();
        if (!$check_conv) {
            $query = $this->pdo->prepare("INSERT INTO `conversations`(`nom_conversation`, `createur_conversation`, `id_topic`) VALUES (:nom_conversation, :login, :id_topic)");
            $query->execute(["nom_conversation" => $nom_conversation, "login" => $login, "id_topic" => $id_topic]);
            return;
        } else {
            return "<p>" . "Il existe déjà un sujet du même nom" . "</p>";
        }

    }

    public function ajouterTopic($nom_topic, $login, $access)
    {
        $query = $this->pdo->prepare("SELECT id FROM topic WHERE nom_topic=:nom_topic");
        $query->execute(["nom_topic" => $nom_topic]);
        $check_topic = $query->fetchColumn();
        if (!$check_topic) {
            $query = $this->pdo->prepare("INSERT INTO `topic`(`nom_topic`, `createur_topic`, `access`) VALUES (:nom_topic, :login, :access)");
            $query->execute(["nom_topic" => $nom_topic, "login" => $login, "access" => $access]);
            return "<p>" . "Topic ajoute" . "</p>";
        } else {
            return "<p>" . "Il existe deja un topic du meme nom" . "</p>";
        }

    }

    public function ajouterlike($id_message, $id_utilisateur)
    {
        $query = $this->pdo->prepare("SELECT id FROM suivi_like WHERE id_utilisateur=:id_utilisateur AND id_message=:id_message");
        $query->execute(["id_utilisateur" => $id_utilisateur, "id_message" => $id_message]);
        $check_like = $query->fetchColumn();
        if (!$check_like) {
            $query = $this->pdo->prepare("INSERT INTO `suivi_like`(`id_message`,`id_utilisateur`,`like_send`) VALUES (:id_message, :id_utilisateur, :like_send)");
            $query->execute(["id_message" => $id_message, "id_utilisateur" => $id_utilisateur, "like_send" => 1]);
            return true;
        } else {
            return false;
        }

    }

    public function ajouterdislike($id_message, $id_utilisateur)
    {
        $query = $this->pdo->prepare("SELECT id FROM suivi_like WHERE id_utilisateur=:id_utilisateur AND id_message=:id_message");
        $query->execute(["id_utilisateur" => $id_utilisateur, "id_message" => $id_message]);
        $check_like = $query->fetchColumn();
        if (!$check_like) {
            $query = $this->pdo->prepare("INSERT INTO `suivi_like`(`id_message`,`id_utilisateur`,`dislike_send`) VALUES (:id_message, :id_utilisateur, :dislike_send)");
            $query->execute(["id_message" => $id_message, "id_utilisateur" => $id_utilisateur, "dislike_send" => 1]);
            return true;
        } else {
            return false;
        }

    }

    public function afficherlike($id_message)
    {
        $query = $this->pdo->prepare("SELECT COUNT(like_send) FROM `suivi_like` WHERE id_message=:id_message");
        $query->execute(["id_message" => $id_message]);
        $this->allresult_like = $query->fetchAll(PDO::FETCH_ASSOC);
        return $this->allresult_like[0]['COUNT(like_send)'];
    }

    public function afficherdislike($id_message)
    {
        $query = $this->pdo->prepare("SELECT COUNT(dislike_send) FROM `suivi_like` WHERE id_message=:id_message");
        $query->execute(["id_message" => $id_message]);
        $this->allresult_dislike = $query->fetchAll(PDO::FETCH_ASSOC);
        return $this->allresult_dislike[0]['COUNT(dislike_send)'];
    }

    public function setidConversation($id_conversation)
    {
        $this->id_conversation = $id_conversation;
    }

    public function getidConversation()
    {
        return $this->id_conversation;
    }

}
