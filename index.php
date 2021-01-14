<?php
session_start();
require_once 'class/messages.php';

$messages=new messages();
if($messages->afficherTopic()==true)
{
    for ($i=0;isset($messages->allresult_topic[$i]);$i++){
        $id_topic=$messages->allresult_topic[$i]['id'];
        echo "<a href='pages/conversation.php?id_topic=$id_topic'>" . $messages->allresult_topic[$i]['nom_topic'] . "</a>" . "<br>";
    }
}

if (isset($_SESSION['login']))
{
    if($_SESSION['status']=='admin' || $_SESSION['status']=='mod')
    {?>
        <form method="post">
            <label for="text">Ajouter un topic</label>
            <input type="text" name="titre_topic" id="titre_topic" placeholder="nom du topic">
            <label for="select_access"> Visibilité du topic</label>
            <select name="select_access" value="Niveau d'accesssibilité">
                <option>Public</option>
                <option>Membres</option>
                <option>Administrateurs</option>
            </select>
            <input type="submit" name="submit_new_topic" id="submit_new_topic" value="Valider">
        </form>
        <?php
        if (isset($_POST['submit_new_topic']))
        {
            $access=$_POST['select_access'];
            if ($access=="Public"){
                $access="mod";
            }
            if ($access=="Administrateur"){
                $access="admin";
            }
            if ($access=="Membre"){
                $access="membre";
            }
            $titre=$_POST['titre_topic'];
            $messages->ajouterTopic($titre, $_SESSION['login'], $access);
            echo "Le sujet à bien été ajouté";
        }
    }
}