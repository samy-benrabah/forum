<?php

require_once 'class/messages.php';

$messages=new messages();
if($messages->afficherTopic()==true)
{
    for ($i=0;isset($messages->allresult_topic[$i]);$i++){
        echo "<strong>" . $messages->allresult_topic[$i]['nom_topic'] . "</strong>" . "<br>";
        if ($messages->afficherConversation($messages->allresult_topic[$i]['id'])==true){
            for ($j=0; isset($messages->allresult_conversation[$j]); $j++){
                $id=$messages->allresult_conversation[$j]['id'];
                var_dump($id);
                echo "<a href='pages/conversation.php?id=$id'>" . $messages->allresult_conversation[$j]['nom_conversation'] . "</a>" . "<br>";
            }
        }
    }
}