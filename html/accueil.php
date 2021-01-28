<?php
session_start();

require_once '../class/compteur/compteur.php';
require_once '../class/messages.php';
require_once '../class/admin.php';
// require_once '../class/barre_recherche.php';
$compteur = new Compteur();
$messages = new messages();
$articles = '';
// $search = new Recherche();

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
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="profil.php">Profil</a></li>
    </ul>
    <form method="get" class="header-search-box" action="affichage-test.php">
        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <button type="submit" name="submit" >
            <i class="fa fa-search" color = "blue"></i></button>
    </form>
</header>
<main class="accueil-global">
    <div class="accueil">
        <p><b>Bienvenue sur le forum Dev.Help</b></br> Le forum d'entraide
            des developpeurs que tu sois plutot front , back ou full!!
        <?php
        if (isset($_SESSION['login']) && $_SESSION["visite"] != "oui") {?>
        <br> Nombre de visiteurs depuis la creation de ce forum :
           <?php echo $compteur->afficher_compteur(); ?>!
            <?php $_SESSION["visite"] = "oui";
        } else?></p>
        <div class="full-topic">
            <div class="topic">
                <div class="titre-topic">
                    <h1>Topics</h1>
                </div>
                <table class="table_topic">
                    <?php
                    if ($messages->afficherTopic()==true)
                    {
                        if (!isset($_SESSION['login']))
                        {
                            $messages->afficherTopicpublic();
                            for ($i=0;isset($messages->allresult_topic_public[$i]);$i++){
                                $id_topic=$messages->allresult_topic_public[$i]['id'];
                                echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic_public[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                            }
                        }
                        if (isset($_SESSION['status']) AND $_SESSION['status']=='membre')
                        {
                            $messages->afficherTopicmembres();
                            for ($i=0;isset($messages->allresult_topic_membres[$i]);$i++){
                                $id_topic=$messages->allresult_topic_membres[$i]['id'];
                                echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic_membres[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                            }
                        }
                        if (isset($_SESSION['status']))
                        {
                            if ($_SESSION['status']=='admin' || $_SESSION['status']=='mod') {
                                for ($i = 0; isset($messages->allresult_topic[$i]); $i++) {
                                    $id_topic = $messages->allresult_topic[$i]['id'];
                                    echo "<tr>" . "<td>" . "<a href='../html/sujet.php?id_topic=$id_topic'>" . $messages->allresult_topic[$i]['nom_topic'] . "</a>" . "</td>" . "</tr>";
                                }
                            }
                        }

                    } else "Aucun topic à afficher";
                    ?>
                </table>
                <?php
                if (isset($_SESSION['status']))
                {
                    if ($_SESSION['status']=='admin' || $_SESSION['status']=='mod')
                    {
                        echo'<form action="" method="post">
                <div class="button-topic">
                    <input class="button-topic" name="button_topic" id="button_topic" type="submit" value="Ajouter">
                </div>';
                    }
                }
                ?>
            </div>
        <?php
        if (isset($_POST['button_topic'])) {
            echo '<div class="formulaire">
        <div class="titre-topic">
            <h1>Ajouter un topic</h1>
        </div>
        <div class="login">
           <label for="login">Titre : </label>
            <input type="text" name="titre_topic" id="titre_topic">
       </div>
            <label class="select_access" for="modif_access">Accessibilité :</label>
            <select name="modif_access" id="modif_access">
                <option></option>
                <option>Membre</option>
                <option value="mod">Modérateur</option>
                <option value="admin">Administrateur</option>
            </select>
            <input type="submit" value="Valider" name="submit_topic" id="submit_topic">';
            }
            if (isset($_POST['submit_topic'])) {
                if (!empty(trim($_POST['submit_topic']))) {
                    echo $messages->ajouterTopic($_POST['titre_topic'], $_SESSION['login'], $_POST['modif_access']);
                } else echo "Merci de completer le titre du topic";
            } ?>
    </div>
</main>
<footer>
    <section>
        <p>Copyright &copy All right reserved</p>
    <div class="footer-link-1">
        <a href="https://www.facebook.com/">Facebook</a>
        <a href="https://www.github.com/">GitHub</a>
        <a href="https://www.twitter.com/twitter.php">Twitter</a>
    </div>
    <div class="footer-link-2">
    <a href="connexion.php">Connexion</a>
    <a href="inscription.php">Inscription</a>
    <a href="profil.php">Profil</a>
    </div>

    </section>

</footer>
</body>
</html>
