<?php
session_start();
require_once '../class/messages.php';

$messages=new messages();
if($messages->afficherConversation($_GET['id_topic'])==true)
{
    for ($i=0;isset($messages->allresult_conversation[$i]);$i++){
        $id_conversation=$messages->allresult_conversation[$i]['id'];
        echo "<strong>" . "<a href='messages.php?id=$id_conversation'>" . $messages->allresult_conversation[$i]['nom_conversation'] . "</a>" . "</strong>" . "<br>";
        if ($messages->afficherMessage($messages->allresult_conversation[$i]['id'])==true){
            for ($j=0; isset($messages->allresult_messages[$j]); $j++){
                $login = $messages->allresult_messages[$j]['login'];
                $id = $messages->allresult_messages[$j]['id_utilisateur'];
                echo "auteur du message: " . "<a href='profil.php?id=$id'>" . $login . "</a>" . "<br>";
                echo $messages->allresult_messages[$j]['titre'] . "<br>";
                echo $messages->allresult_messages[$j]['message'] . "<br>";
            }
        }
    }
}

if (isset($_SESSION['login']))
{
    if($_SESSION['status']=='admin' || $_SESSION['status']=='mod')
    {?>
<form method="post">
    <label for="text">Ajouter un sujet</label>
    <input type="text" name="titre_conv" id="titre_conv" placeholder="nom du sujet">
    <label for="select_acces"> Visibilité du sujet</label>
    <select name="select_access" value="niveau d'accesssibilité">
        <option>Public</option>
        <option>Membres</option>
        <option>Administrateurs</option>
    </select>
    <input type="submit" name="submit_new_conv" id="submit_new_conv" value="Valider">
</form>
<?php
    if (isset($_POST['submit_new_conv']))
    {
        $titre=$_POST['titre_conv'];
        $messages->ajouterConversation($titre, $_SESSION['login'], $_GET['id_topic']);
        echo "Le sujet à bien été ajouté";
    }
    }
}
?>
