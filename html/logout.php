<?php
setcookie('mail',null, time() -3600, '/');
session_start();
session_destroy();
header('location: accueil.php');


?>
