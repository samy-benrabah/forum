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
    <ul>
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
        <form method="get" class="header-search-box" action="affichage-sujet.php">

        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <i class="fas fa-search"></i>
    </form>
</header>
<main class="sujet-global">
    <div class="full-sujet">
        <div class="sujet">
            <div class="titre-topic">
                <h1><?php echo $messages->titreTopic($_GET['id_topic']) ?></h1>
            </div>
        <div class="titre-sujet">
            <h2> Sujets</h2>
        </div>
        <table class="table_sujet">
            <tr>
                <?php
                if($messages->afficherConversation($_GET['id_topic'])==true)
                {
                    for ($i=0;isset($messages->allresult_conversation[$i]);$i++){
                        $id_conversation=$messages->allresult_conversation[$i]['id'];
                        echo "<tr>" . "<td>" . "<p>" . "<a href='message.php?id_conversation=$id_conversation'>" . $messages->allresult_conversation[$i]['nom_conversation'] . "</a>" . "</p>" . "</td>" . "</tr>";
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
            <div class="ajout-sujet">
                <label for="ajout-sujet">Titre : </label>
                <input type="text" name="titre_conv">
            </div>
            <div class="button-topic">
                <input class="button-topic" type="submit" name="submit_new_conv" value="Ajouter">
            </div>
        <?php
    if (isset($_POST['submit_new_conv'])) {
        if (!empty($_POST['titre_conv'])) {
            $titre = $_POST['titre_conv'];
            echo "<div class='msg_titre_topic'>" . $messages->ajouterConversation($titre, $_SESSION['login'], $_GET['id_topic']) . "</div>";
        } else {
            echo "<div class='msg_titre_topic'>" . "<p>" . "Merci de compléter le titre du sujet" . "</p>" . "</div>";
        }

    }
?>
        </form>
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
