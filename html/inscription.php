<?php

require '../class/user.php';
session_start();
$user = new user();

?>


<!DOCTYPE html>
<html lang="fr">
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
    <div class="full-bloc">
<div class="bloc">
<h1>Inscription</h1>


<div class="form">
<form action="" method="post">
   <div class="login">
   <label for="login">Login : </label>
    <input type="text" name="login">
   </div>
    <div class="password">
    <label for="password"  >Password :</label>
    <input type="password" name="password">
</div>
   <div class="confirm-password">
   <label for="email"  >Email :</label>
    <input type="email" name="email">
   </div>

    </div>
    <div class="button-inscription">
    <input name="submit_register"  type="submit" value="S'inscrire">
    </div>
</form>
</div>

<?php
if (isset($_POST['submit_register'])) {

    if ($user->register($_POST['login'], $_POST['password'], $_POST['email']) == true) {?>
       <div class="bloc_error">
<?php
echo "Bonjour, votre profil à bien ete cree" . "<br>";
        echo "Votre login :" . " " . $user->getLogin() . "<br>";
        echo "Votre email :" . " " . $user->getEmail() . "<br>";
        echo "Vous allez etre redirige vers la page de connexion";
        header("Refresh: 6;url=connexion.php");
    } else {
        ?>

        <div class=error_message>
        <?php
foreach ($user->errors as $values) {
            echo $values . "<br>";
        }
        ?>
        </div>

   <?php }

}
?>
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
