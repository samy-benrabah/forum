<?php
session_start();
require_once '../class/compteur/compteur.php';
// require '../class/compteur/compteur.txt';
$compteur = new Compteur();
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
<p>Bienvenue sur le forum Dev.Help le forum d'entraide
des developpeurs que tu sois plutot front , back ou full!! </br>



<?php
if ($_SESSION['login'] && $_SESSION["visite"] != "oui") {?>
Nombre de visiteurs depuis la creation de ce forum :
   <?php echo $compteur->afficher_compteur(); ?>!
    <?php $_SESSION["visite"] = "oui";
}?>
</p>

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
