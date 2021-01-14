<?php

require_once '../class/messages.php';

$messages=new messages();
if($messages->afficherConversation($_GET['id'])==true)
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
?>
