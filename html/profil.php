<?php

require '../class/user.php';
session_start();
$user = new user();

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

<div class="bloc-profil">
    <div class="int-bloc-profil">
<h1>Profil</h1>
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
   <label for="password"  >Confirm Password :</label>
    <input type="password" name="password">
   </div>

    </div>
    <div class="button-inscription">
    <input name="submit_register"  type="submit" value="S'inscrire">
    </div>
</form>
</div>
<div class="bloc-avatar">
    <img src="<?=$_SESSION['avatar']?>" alt="picture">
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="picture" >
    <input type="submit" name ="upload" value="Upload">
</form>

</div>
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
