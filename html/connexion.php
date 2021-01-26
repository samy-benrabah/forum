<?php
require_once '../class/user.php';
session_start();
$user = new user();

if (isset($_COOKIE['mail'])) {
    echo "Vous etes deja connecte" . "<br>";
    echo "<button><a href='logout.php'>Se déconnecter</a></button>";
} else {
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

</header>
<main>
<div class="full-bloc">
<div class="bloc">
<h1>Connexion</h1>
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
    <div class="button">
    <input name="submit_connect" class="button-in" type="submit" value="Connecter">
    </div>
</form>
</div>
</div>
<?php
if (isset($_POST['submit_connect'])) {?>
<div class="bloc_error">
    <?php
if ($user->connect($_POST['login'], $_POST['password']) == true) {
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['id'] = $user->getId();
        $_SESSION['status'] = $user->getStatus();
        $_SESSION['avatar'] = $user->getAvatar();
        $_SESSION['visite'] = 'non';
        echo "Bonjour" . " " . $user->getLogin() . " " . "vous etes connecte" . "<br>";
        echo "Vous allez etre automatiquement redirige vers l'accueil patientez quelques secondes, sinon cliquez " . "<a href='../index.php'>ici</a>";
        header('Refresh: 6; url=../html/accueil.php');
        if (isset($_POST['souvenir'])) {
            setcookie('mail', $user->getEmail(), time() + 3600, '/');
        }
    } else {?>
         <div class=error_message>
             <?php
foreach ($user->errors as $values) {
        echo $values . "<br>";
    }?>
            </div>
      <?php }
    }
}
?>
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

