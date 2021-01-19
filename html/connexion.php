<?php
session_start();
require_once '../class/user.php';
$user=new user()
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
<?php
if (isset($_COOKIE['mail']))
{
echo "Vous êtes déjà connecté" . "<br>";
echo "<button><a href='logout.php'>Se déconnecter</a></button>";
}
else
{
?>
<div class="bloc">
<h1>Connexion</h1>
<div class="form">
<form action="" method="post">
    <?php
    if (isset($_POST['submit_connect']))
    {
        if ($user -> connect($_POST['login'], $_POST['password'])==true) {
            $_SESSION['login'] = $user->getLogin();
            $_SESSION['id'] = $user->getId();
            $_SESSION['status'] = $user->getStatus();
            echo "Bonjour" . " " . $user->getLogin() . " " . "vous êtes connecté" . "<br>";
            echo "Vous allez être automatiquement redirigé vers l'accueil, sinon cliquez " . "<a href='../index.php'>ici</a>";
            //header('Refresh: 3; url=../index.php');
            if (isset($_POST['souvenir'])) {
                setcookie('mail', $user->getEmail(), time() + 3600, '/');
            }
        } else
        {
            foreach ($user->errors as $values){
                echo $values . "<br>";
            }
        }
    }
    }
    ?>
   <div class="login">
   <label for="login">Login : </label>
    <input type="text" name="login">
   </div>
    <div class="password">
    <label for="password"  >Password :</label>
    <input type="password" name="password">

    </div>
    <div class="button">
    <input class="button-in" type="submit" name="submit_connect" value="Connecter">
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
