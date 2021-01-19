<?php
session_start();
require_once '../class/messages.php';
$messages = new messages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/218e7c5bb4.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<header>
    <div class="header-first">
        <img src="../image/logo.black.svg">
        <h1>Dev<span class="header-span-title">.Help</span></h1>
    </div>
    <form method="get" class="header-search-box">
        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <i class="fas fa-search"></i>
    </form>
</header>
<main>
    <div class="full-topic">
<div class="topic">
    <div class="titre-topic">
        <h1>Topics</h1>
    </div>
    <table>
        <?php
        if ($messages->afficherTopic()==true)
        {
            if (!$_SESSION['login'])
            {
                $messages->afficherTopicpublic();
                for ($i=0;isset($messages->allresult_topic_public[$i]);$i++){
                    $id_topic=$messages->allresult_topic_public[$i]['id'];
                    echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic_public[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                }
            }
            if ($_SESSION['status']=='membre')
            {
                $messages->afficherTopicmembres();
                for ($i=0;isset($messages->allresult_topic_membres[$i]);$i++){
                    $id_topic=$messages->allresult_topic_membres[$i]['id'];
                    echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic_membres[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                }
            }
            if ($_SESSION['status']=='admin' || $_SESSION['status']=='mod') {
                for ($i = 0; isset($messages->allresult_topic[$i]); $i++) {
                    $id_topic = $messages->allresult_topic[$i]['id'];
                    echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                }
            }
        } else "Aucun topic à afficher"
        ?>
    </table>
<form action="" method="get">
<div class="button-topic">
    <input class="button-topic" type="submit" value="Ajouter">
    </div>
    </form>
    </div>

    <div class="formulaire">
    <div class="titre-topic">
        <h1>Topics</h1>
    </div>

    <div class="login">
   <label for="login">Titre : </label>
    <input type="text" name="login">
   </div>

<form action="" method="get">
<div class="button-topic">
    <input class="button-topic" type="submit" value="Ajouter">
    </div>
    </form>
    </div>
    </div>
</main>
<footer>
    <section>
        <p>Copyright &copy All right reserved</p>
    <div class="footer-link-1">
        <a href="">Facebook</a>
        <a href="">GitHub</a>
        <a href="">Twitter</a>
    </div>
    <div class="footer-link-2">
    <a href="">Connexion</a>
    <a href="">Inscription</a>
    </div>

    </section>

</footer>
</body>
</html>
