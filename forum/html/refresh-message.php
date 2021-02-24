<?php
session_start();
$id_conversation = $_SESSION['id_conversation'];
if ($_SESSION['page_message'] = "oui") {
    header("Location: message.php?id_conversation=$id_conversation");
}
