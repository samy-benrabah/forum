<?php
session_start();
$bdd = new PDO('mysql:dbname=forum;host=localhost', "root", "");
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
    <form method="get" class="header-search-box" action="affichage-message.php">
        <input autocomplete="off" type="search" name="search" class="header-search-input" placeholder="Recherche">
        <i class="fas fa-search"></i>
    </form>
</header>
<main class="accueil-recherche">

            <div class="titre-topic-recherche">
            <h1>Resultats de la recherche de Sujets <br> correspondant a: <?php echo $_GET['search'];?></h1>
            </div>
            <table class="table_topic_recherche">
   <?php
$articles = $bdd->query('SELECT id,nom_conversation FROM conversations ORDER BY id DESC');
if (isset($_GET['search']) and !empty($_GET['search'])) {

    $q = htmlspecialchars($_GET['search']);
    $articles = $bdd->query('SELECT id,nom_conversation FROM conversations WHERE nom_conversation LIKE "%' . $q . '%" ORDER BY id DESC');
    if ($articles->rowCount() == 0) {
        $articles = $bdd->query('SELECT nom_conversation FROM conversations WHERE CONCAT(nom_conversation, contenu) LIKE "%' . $q . '%" ORDER BY id DESC');
    }
}if ($articles != false && $articles->rowCount() > 0) {?>
<tr>
   <?php while ($a = $articles->fetch()) {
    $id_topic = $a['id'];

    echo "<tr>" . "<td>" . "<a href='sujet.php?id_topic=$id_topic'>" . $a['nom_conversation'] . "</a>" . "</td>" . "</tr>";
}?>
</tr>
<?php } else if ($articles == false) {?>
Aucun résultat pour: <?=$q?>...
<?php }?>
</table>

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