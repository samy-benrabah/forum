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
        <h1><?php echo $messages->titreTopic($_GET['id_topic'])?></h1>
    </div>
    <div class="titre-sujet">
        <h2> Sujets</h2>
    </div>
    <table>
    <tr>
            <?php
            if($messages->afficherConversation($_GET['id_topic'])==true)
            {
                for ($i=0;isset($messages->allresult_conversation[$i]);$i++){
                    $id_conversation=$messages->allresult_conversation[$i]['id'];
                    echo "<tr>" . "<td>" . "<h2>" . "<a href='message.php?id_conversation=$id_conversation'>" . $messages->allresult_conversation[$i]['nom_conversation'] . "</a>" . "</h2>" . "</td>" . "</tr>";
                }
            }
            ?>
    </tr>
    </table>


    </div>

    <div class="formulaire">

        <div class="titre-topic">
            <h1>Ajouter un sujet</h1>
        </div>
<form method="post">
    <div class="login">
   <label for="login">Titre : </label>
    <input type="text" name="titre_conv">
   </div>
<div class="button-topic">
    <input class="button-topic" type="submit" name="submit_new_conv" value="Ajouter">
    </div>
</form>

    <?php
    if (isset($_POST['submit_new_conv']))
    {
        if(!empty($_POST['titre_conv'])) {
            $titre = $_POST['titre_conv'];
            echo "<div class='msg_titre_topic'>" . $messages->ajouterConversation($titre, $_SESSION['login'], $_GET['id_topic']) . "</div>";
        } else echo "<div class='msg_titre_topic'>" . "Merci de compléter le titre du sujet" . "</div>";
    }
    ?>
    </form>
    </div>
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
