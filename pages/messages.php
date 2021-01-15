<?php
session_start();
require_once '../class/messages.php';

var_dump($_SESSION['id']);
var_dump($_SESSION['login']);

$messages=new messages();
if($messages->afficherMessage($_GET['id'])==true)
{
    $messages->setidConversation($_GET['id']);
    for ($i=0; isset($messages->allresult_messages[$i]); $i++){
        $login = $messages->allresult_messages[$i]['login'];
        $id = $messages->allresult_messages[$i]['id_utilisateur'];
        $id_message=$messages->allresult_messages[$i]['id'];
        echo "auteur du message: " . "<a href='profil.php?id=$id'>" . $login . "</a>" . "<br>";
        echo $messages->allresult_messages[$i]['titre'] . "<br>";
        echo $messages->allresult_messages[$i]['message'] . "<br>";
        echo "<form method='post'>" . "<input type='submit' name='like=$id_message' id='like=$id_message' value='aime'>". $messages->afficherlike($id_message,$_SESSION['id']) . "<input type='submit' name='dislike=$id_message' id='dislike=$id_message' value='aime pas'>" . $messages->afficherdislike($id_message) . "</form>";
        if (isset($_POST["like=$id_message"]))
        {
            $messages->ajouterlike($id_message, $_SESSION['id']);
            var_dump($id_message);
            var_dump($_SESSION['id']);
            echo "like ajouté";
        }
        if (isset($_POST["dislike=$id_message"]))
        {
            $messages->ajouterdislike($id_message, $_SESSION['id']);
            echo "envoi dislike";
        }
    }
}
?>
<form method="post">
    <label for="textarea">Ajouter un message à cette conversation</label>
    <input type="text" placeholder="titre du message" name="titre_message" id="titre_message">
    <textarea placeholder="ajoutez votre message" name="message" id="message"></textarea>
    <input type="submit" name="submit_message" id="submit_message">
</form>

<?php
if (isset($_POST['submit_message']))
{
    $date = date('Y-m-d H:i:s');
    $id_conversation = $messages->getConversation();
    $messages->ajouterMessage($_POST['titre_message'], $_POST['message'], $id_conversation, $_SESSION['id'], $_SESSION['login'], $date );
    echo "Votre message à bien été ajouté" . "<br>";
    echo $_POST['titre_message'] . "<br>";
    echo $_POST['message'] . "<br>";
    echo $_SESSION['id'] . "<br>";
    echo $_SESSION['login'] . "<br>";
    echo $messages->getConversation() . "<br>";
    echo $date;
}
?>


